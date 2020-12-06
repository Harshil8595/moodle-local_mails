<?php
// This file is part of the Mailbox plugin for Moodle - http://moodle.org/
//
// Mailbox is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Mailbox is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Mailbox.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package    local_mails
 * @copyright  2020 Harshil Patel <harshil8595@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_mails;

require_once __DIR__.'/../vendor/autoload.php';
require_once $CFG->libdir.'/filelib.php';

use context_system;
use stdClass;
use ZBateson\MailMimeParser\Header\AddressHeader;
use ZBateson\MailMimeParser\Message;

class helper {
    const types = ['from','to','cc','bcc',];
    const mailtable = 'local_mail';
    const receipenttable = 'local_mail_receipent';
    const component = 'local_mails';
    const attachmentarea = 'attachment';
    const bodyarea = 'mailbody';
    const plainfile = 'plain';
    const htmlbody = 'html';
    const textbody = 'text';
    const cap = 'local/mails:readallmails';
    const pagesize = 5;
    const typesender = 0;
    const typereceipent = 1;
    const typeall = 99;
    const perpage = 5;

    public static function get_mailtypes(){
        return [
            'sender' => static::typesender,
            'receiver' => static::typereceipent,
            'all' => static::typeall,
        ];
    }

    public static function parse($string){

        $message = Message::from($string);
        $requestdir = make_request_directory();

        $mailobj = new stdClass;
        $mailobj->mailbody = $string;
        $mailobj->subject = $message->getHeaderValue('subject');
        foreach (self::types as $type){
            /* @var $_types AddressHeader */
            $_types = $message->getHeader($type);
            if($_types) {
                foreach ($_types->getAddresses() as $address) {
                    $mailobj->{$type}[] = [
                            'name' => $address->getName(),
                            'mail' => $address->getEmail(),
                    ];
                }
            }
        }
        $mailobj->noattachments = $message->getAttachmentCount();
        for($i = 0; $i < $mailobj->noattachments; $i++){
            $attachment = $message->getAttachmentPart($i);
            $filepath = $requestdir.'/'.$attachment->getFilename();
            $attachment->saveContent($filepath);
            $mailobj->attachments[] = [
                    'filename' => $attachment->getFilename(),
                    'filetype' => $attachment->getContentType(),
                    'filepath' => $filepath,
            ];
        }
        $mailobj->text = $message->getTextContent();
        $mailobj->html = $message->getHtmlContent();
        $mailobj->date = $message->getHeaderValue('Date');
        $mailobj->timesent = isset($mailobj->date) ? strtotime($mailobj->date) : time();
        return $mailobj;
    }

    public static function store(stdClass $mailobj){
        global $DB;
        $systemctx = context_system::instance();
        $fs = get_file_storage();
        $record = new stdClass();
        $from = current($mailobj->from);
        $record->mail = $from['mail'];
        $record->name = $from['name'];
        $record->subject = $mailobj->subject;
        $record->timesent = $mailobj->timesent;
        $record->timeread = null;
        $record->mailid = $DB->insert_record(self::mailtable,$record);
        foreach (self::types as $type){
            if($type == 'from' || !isset($mailobj->{$type})) continue;
            foreach ($mailobj->{$type} as $receipent){
                $record->mail = $receipent['mail'];
                $record->name = $receipent['name'];
                $record->type = $type;
                $DB->insert_record(self::receipenttable,$record);
            }
        }
        $filerecord = [];
        $filerecord['contextid'] = $systemctx->id;
        $filerecord['component'] = self::component;
        $filerecord['itemid'] = $record->mailid;
        $filerecord['filepath'] = '/';
        if($mailobj->noattachments > 0){
            foreach ($mailobj->attachments as $attachment){
                $filerecord['filearea'] = self::attachmentarea;
                $filerecord['filename'] = $attachment['filename'];
                $fs->create_file_from_pathname($filerecord,$attachment['filepath']);
            }
        }
        $filerecord['filearea'] = self::bodyarea;
        $filerecord['filename'] = self::plainfile;
        $fs->create_file_from_string($filerecord,$mailobj->mailbody);
        if(!empty($mailobj->text)) {
            $filerecord['filename'] = self::textbody;
            $fs->create_file_from_string($filerecord, $mailobj->text);
        }
        if(!empty($mailobj->html)) {
            $filerecord['filename'] = self::htmlbody;
            $fs->create_file_from_string($filerecord, $mailobj->html);
        }
        return $record->mailid;
    }

    public static function parseandstrore($mailbody){
        $mailobj = self::parse($mailbody);
        return self::store($mailobj);
    }

    public static function check_user($mailorid,$email,$userid){
        global $DB;
        $ismanager = helper::is_manager($userid);
        if(is_int($mailorid)){
            $mail = $DB->get_record(self::mailtable, ['id' => $mailorid]);
        } else {
            $mail = $mailorid;
        }
        if(!$mail){
            return false;
        }
        if(!$ismanager && $mail->mail != $email &&
                !$DB->record_exists(self::receipenttable, ['mailid' => $mail->id, 'mail' => $email])){
            return false;
        }
        return true;
    }

    public static function is_manager($userorid){
        return has_capability(self::cap,context_system::instance(),$userorid);
    }
}