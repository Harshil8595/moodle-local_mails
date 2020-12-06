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

require_once("$CFG->libdir/filelib.php");

class api {
    public static function get_mails($useridto = 0, $type = helper::typereceipent,$sort = 'DESC', $limit = 0, $offset = 0) {
        global $DB, $USER;

        $sort = strtoupper($sort);
        if ($sort != 'DESC' && $sort != 'ASC') {
            throw new \moodle_exception('invalid parameter: sort: must be "DESC" or "ASC"');
        }

        if (empty($useridto)) {
            $useridto = $USER->id;
        }

        if ($useridto == $USER->id) {
            $user = $USER;
        } else {
            $user = \core_user::get_user($useridto, "*", MUST_EXIST);
        }
        $params = ['mail' => $user->email,];
        $context_system = \context_system::instance();
        $type == helper::typeall && !helper::is_manager($user)?helper::typereceipent:$type;

        switch ($type){
            case helper::typeall;
                $sqlwhere = ' 1 = 1';
                break;
            case helper::typesender:
                $sqlwhere = 'm.mail = :mail';
                break;
            default:
                $sqlwhere = 'm.id IN (SELECT mailid FROM {'.helper::receipenttable.'} 
            WHERE mail = :mail)';
                break;
        }

        $sql = "SELECT m.*,u.id AS userid FROM {".helper::mailtable."} m
                LEFT JOIN {user} u ON u.email = m.mail
                WHERE {$sqlwhere}
                ORDER BY m.timesent $sort, m.timeread $sort, m.id $sort";
        $mails = $DB->get_records_sql($sql, $params, $offset, $limit);

        if(!empty($mails)){
            list($mailsin,$mailparams) = $DB->get_in_or_equal(array_keys($mails));
            $sql = "SELECT r.*,u.id AS userid FROM {".helper::receipenttable."} r
                LEFT JOIN {user} u ON u.email = r.mail
                WHERE r.mailid {$mailsin}";
            $receipents = $DB->get_records_sql($sql, $mailparams);
            foreach ($receipents as $receipent){
                $mails[$receipent->mailid]->{$receipent->type}[] = $receipent;
            }
        }

        $fs = get_file_storage();
        foreach ($mails as $mail){
            $attachments = $fs->get_area_files($context_system->id,
                    helper::component, helper::attachmentarea,
                    $mail->id);
            if(!empty($attachments)){
                foreach ($attachments as $attachment) {
                    if($attachment->get_filesize() <= 0) {
                        continue;
                    }
                    $fileurl = \moodle_url::make_pluginfile_url(
                            $attachment->get_contextid(), $attachment->get_component(),
                            $attachment->get_filearea(), $attachment->get_itemid(),
                            '/', $attachment->get_filename()
                    )->out(false);
                    $mail->attachments[] = [
                        'url' => $fileurl,
                        'name' => $attachment->get_filename(),
                        'icon' => file_file_icon($attachment,128),
                    ];
                }
            }
            $mimes = $fs->get_area_files($context_system->id,
                    helper::component, helper::bodyarea,
                    $mail->id);
            if(!empty($mimes)){
                foreach ($mimes as $mimefile) {
                    if($mimefile->get_filesize() <= 0) {
                        continue;
                    }
                    $mail->{$mimefile->get_filename()} = $mimefile->get_content();
                }
            }
        }

        return $mails;
    }

    public static function get_unread_count($useridto = 0) {
        global $USER, $DB;

        if (empty($useridto)) {
            $useridto = $USER->id;
        }

        if ($useridto == $USER->id) {
            $user = $USER;
        } else {
            $user = \core_user::get_user($useridto, "*", MUST_EXIST);
        }
        $params = ['mail' => $user->email,];
        $context_system = \context_system::instance();
        if(helper::is_manager($user)){
            $sqlwhere = ' 1 = 1';
        }else{
            $sqlwhere = 'm.id IN (SELECT mailid FROM {'.helper::receipenttable.'} 
            WHERE mail = :mail)';
        }

        return $DB->count_records_sql(
                "SELECT count(id)
               FROM {".helper::mailtable."} m
              WHERE {$sqlwhere}
                AND timeread is NULL",
                $params
        );
    }

    public static function mark_all_mails_as_read($useridto, $timecreatedto = null) {
        global $DB,$USER;

        if ($useridto == $USER->id) {
            $user = $USER;
        } else {
            $user = \core_user::get_user($useridto, "*", MUST_EXIST);
        }
        $params = ['mail' => $user->email,];
        $context_system = \context_system::instance();
        if(helper::is_manager($user)){
            $sqlwhere = ' 1 = 1';
        }else{
            $sqlwhere = 'm.id IN (SELECT mailid FROM {'.helper::receipenttable.'} 
            WHERE mail = :mail)';
        }

        $mailsql = "SELECT m.*
                              FROM {".helper::mailtable."} m
                             WHERE {$sqlwhere}
                               AND timeread is NULL";
        if (!empty($fromuserid)) {
            $mailsql .= " AND useridfrom = ?";
            $mailsparams[] = $fromuserid;
        }
        if (!empty($timecreatedto)) {
            $mailsql .= " AND timecreated <= ?";
            $mailsparams[] = $timecreatedto;
        }

        $mails = $DB->get_recordset_sql($mailsql, $params);
        foreach ($mails as $mail) {
            self::mark_mail_as_read($mail);
        }
        $mails->close();
    }

    public static function mark_mail_as_read($mail, $timeread = null) {
        global $DB;

        if (is_null($timeread)) {
            $timeread = time();
        }

        if (is_null($mail->timeread)) {
            $updatemail = new \stdClass();
            $updatemail->id = $mail->id;
            $updatemail->timeread = $timeread;

            $DB->update_record(helper::mailtable, $updatemail);

        }
    }

}