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

namespace local_mails\output;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/message/lib.php');

use local_mails\helper;

class mail implements \templatable, \renderable {

    /**
     * @var \stdClass The notification.
     */
    protected $mail;

    /**
     * Constructor.
     *
     * @param \stdClass $mail
     */
    public function __construct($mail) {
        $this->mail = $mail;
    }

    public static function get_header_name($email,$name = null,$userid = null,$forceimg = false){
        global $PAGE;
        $header = [];
        $header['email'] = $email;
        $header['name'] = $name;
        /* @var $renderer \core_renderer */
        $renderer = $PAGE->get_renderer('core');
        if($forceimg) $header['iconurl'] = ($renderer->image_url('u/f2'))->out();
        if(!empty($userid)){
            $user = (object)['id' => $userid,];
            $userpicture = new \user_picture($user);
            $header['url'] = (new \moodle_url('/user/profile.php',['id' => $userid]))->out();
            $header['iconurl'] = ($userpicture->get_url($PAGE,$renderer))->out();
        }
        return $header;
    }

    public function export_for_template(\renderer_base $output) {
        $mail = $this->mail;
        $context = (object)['id' => $mail->id,];
        $context->timecreated = $mail->timesent;
        $context->timeread = $mail->timeread;
        $context->timecreatedpretty = get_string('ago', 'message', format_time(time() - $mail->timesent));
        $context->read = $mail->timeread ? true : false;
        $context->text = $mail->plain;
        $context->fullmessage = $mail->text;
        $context->fullmessagehtml = $mail->html;

        // Need to strip any HTML from these.
        $context->subject = clean_param($mail->subject, PARAM_TEXT);
        $context->shortenedsubject = shorten_text($context->subject, 125);

        $context->from = self::get_header_name($mail->mail,$mail->name,$mail->userid,true);
        foreach (helper::types as $type){
            if(isset($mail->{$type})){
                foreach ($mail->{$type} as $typeobj){
                    $context->{$type}[] = self::get_header_name($typeobj->mail,$typeobj->name,$typeobj->userid);
                }
            }
        }
        $context->hascc = !empty($context->cc);
        $context->hasbcc = !empty($context->bcc);
        $context->attachments = isset($mail->attachments) ? $mail->attachments : [];
        $context->hasattachments = !empty($mail->attachments);

        return $context;
    }
}
