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

use context_system;
use core_user;
use external_api;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;
use external_warnings;
use local_mails\output\mail;
use moodle_exception;

require_once("$CFG->libdir/externallib.php");

class external extends external_api {

    public static function get_mails_parameters() {
        return new external_function_parameters(
                array(
                        'useridto' => new external_value(PARAM_INT, 'the user id who received the message, 0 for current user'),
                        'type' => new external_value(PARAM_INT, 'type',VALUE_DEFAULT,helper::typereceipent),
                        'newestfirst' => new external_value(
                                PARAM_BOOL, 'true for ordering by newest first, false for oldest first',
                                VALUE_DEFAULT, true),
                        'limit' => new external_value(PARAM_INT, 'the number of results to return', VALUE_DEFAULT, helper::perpage),
                        'offset' => new external_value(PARAM_INT, 'offset the result set by a given amount', VALUE_DEFAULT, 0)
                )
        );
    }

    public static function get_mails($useridto, $type, $newestfirst, $limit, $offset) {
        global $USER, $PAGE;

        $params = self::validate_parameters(
                self::get_mails_parameters(),
                array(
                        'useridto' => $useridto,
                        'type' => $type,
                        'newestfirst' => $newestfirst,
                        'limit' => $limit,
                        'offset' => $offset,
                )
        );

        $context = context_system::instance();
        self::validate_context($context);

        $useridto = $params['useridto'];
        $newestfirst = $params['newestfirst'];
        $limit = $params['limit'];
        $offset = $params['offset'];
        $type = $params['type'];
        $ismanager = helper::is_manager($useridto);
        $renderer = $PAGE->get_renderer('core_message');

        if (empty($useridto)) {
            $useridto = $USER->id;
        }

        // Check if the current user is the sender/receiver or just a privileged user.
        if ($useridto != $USER->id and !$ismanager) {
            throw new moodle_exception('accessdenied', 'admin');
        }

        if (!empty($useridto)) {
            if (!core_user::is_real_user($useridto)) {
                throw new moodle_exception('invaliduser');
            }
        }

        $sort = $newestfirst ? 'DESC' : 'ASC';
        $mails = api::get_mails($useridto, $type, $sort, $limit, $offset);
        $mailcontexts = [];

        if ($mails) {
            foreach ($mails as $mail) {

                $mailoutput = new mail($mail);

                $mailcontext = $mailoutput->export_for_template($renderer);

                // Keep this for BC.
                $mailcontext->deleted = false;
                $mailcontext->showsender = $type == helper::typereceipent || $type == helper::typeall;
                $mailcontext->showreceiver = $type == helper::typesender || $type == helper::typeall;
                $mailcontexts[] = $mailcontext;
            }
        }

        return array(
                'notifications' => $mailcontexts,
                'unreadcount' => api::get_unread_count($useridto),
        );
    }

    public static function get_mails_returns() {
        $headersingle = new external_single_structure(
                array(
                        'email' => new external_value(PARAM_RAW, 'Email'),
                        'name' => new external_value(PARAM_RAW, 'Name', VALUE_OPTIONAL),
                        'url' => new external_value(PARAM_URL, 'Profile url', VALUE_OPTIONAL),
                        'iconurl' => new external_value(PARAM_URL, 'Icon img', VALUE_OPTIONAL),
                )
        );
        $header = new external_multiple_structure($headersingle, 'header', VALUE_OPTIONAL);
        return new external_single_structure(
                array(
                        'notifications' => new external_multiple_structure(
                                new external_single_structure(
                                        array(
                                                'id' => new external_value(PARAM_INT, 'Notification id (this is not guaranteed to be unique
                                within this result set)'),
                                                'subject' => new external_value(PARAM_TEXT, 'The notification subject'),
                                                'shortenedsubject' => new external_value(PARAM_TEXT, 'The notification subject shortened
                                with ellipsis'),
                                                'text' => new external_value(PARAM_RAW, 'The message text formated'),
                                                'fullmessage' => new external_value(PARAM_RAW, 'The message'),
                                                'fullmessagehtml' => new external_value(PARAM_RAW, 'The message in html'),
                                                'showsender' => new external_value(PARAM_BOOL,'Show Sender'),
                                                'showreceiver' => new external_value(PARAM_BOOL,'Show Receiver'),
                                                'from' => $headersingle,
                                                'to' => $header,
                                                'cc' => $header,
                                                'bcc' => $header,
                                                'timecreated' => new external_value(PARAM_INT, 'Time created'),
                                                'timecreatedpretty' => new external_value(PARAM_TEXT,
                                                        'Time created in a pretty format'),
                                                'timeread' => new external_value(PARAM_INT, 'Time read'),
                                                'read' => new external_value(PARAM_BOOL, 'notification read status'),
                                                'deleted' => new external_value(PARAM_BOOL, 'notification deletion status'),
                                                'attachments' => new external_multiple_structure(
                                                        new external_single_structure(
                                                                array(
                                                                        'name' => new external_value(PARAM_RAW, 'filename'),
                                                                        'icon' => new external_value(PARAM_RAW, 'file icon',
                                                                                VALUE_OPTIONAL),
                                                                        'url' => new external_value(PARAM_URL, 'file url'),
                                                                )
                                                        ), 'attachment', VALUE_OPTIONAL),
                                                'hascc' => new external_value(PARAM_BOOL,'Includes CC'),
                                                'hasbcc' => new external_value(PARAM_BOOL,'Includes BCC'),
                                                'hasattachments' => new external_value(PARAM_BOOL,'Includes Attachment'),
                                        ), 'message'
                                )
                        ),
                        'unreadcount' => new external_value(PARAM_INT, 'the number of unread message for the given user'),
                )
        );
    }

    public static function get_unread_count_parameters() {
        return new external_function_parameters(
                array(
                        'useridto' => new external_value(PARAM_INT, 'the user id who received the message, 0 for any user',
                                VALUE_REQUIRED),
                )
        );
    }

    public static function get_unread_count($useridto) {
        global $USER;

        $params = self::validate_parameters(
                self::get_unread_count_parameters(),
                array('useridto' => $useridto)
        );

        $context = context_system::instance();
        self::validate_context($context);

        $useridto = $params['useridto'];

        if (!empty($useridto)) {
            if (core_user::is_real_user($useridto)) {
                $userto = core_user::get_user($useridto, '*', MUST_EXIST);
            } else {
                throw new moodle_exception('invaliduser');
            }
        }

        // Check if the current user is the sender/receiver or just a privileged user.
        if ($useridto != $USER->id and !helper::is_manager($USER)) {
            throw new moodle_exception('accessdenied', 'admin');
        }

        return api::get_unread_count($useridto);
    }

    public static function get_unread_count_returns() {
        return new external_value(PARAM_INT, 'The count of unread popup notifications');
    }

    public static function mark_all_mails_as_read_parameters() {
        return new external_function_parameters(
                array(
                        'useridto' => new external_value(PARAM_INT, 'the user id who received the message, 0 for any user',
                                VALUE_REQUIRED),
                        'timecreatedto' => new external_value(
                                PARAM_INT, 'mark messages created before this time as read, 0 for all messages',
                                VALUE_DEFAULT, 0),
                )
        );
    }

    public static function mark_all_mails_as_read($useridto, $useridfrom, $timecreatedto = 0) {
        global $USER;

        $params = self::validate_parameters(
                self::mark_all_mails_as_read_parameters(),
                array(
                        'useridto' => $useridto,
                        'timecreatedto' => $timecreatedto,
                )
        );

        $context = context_system::instance();
        self::validate_context($context);

        $useridto = $params['useridto'];
        $timecreatedto = $params['timecreatedto'];

        if (!empty($useridto)) {
            if (core_user::is_real_user($useridto)) {
                $userto = core_user::get_user($useridto, '*', MUST_EXIST);
            } else {
                throw new moodle_exception('invaliduser');
            }
        }

        api::mark_all_mails_as_read($useridto, $timecreatedto);

        return true;
    }

    public static function mark_all_mails_as_read_returns() {
        return new external_value(PARAM_BOOL, 'True if the messages were marked read, false otherwise');
    }

    public static function mark_mail_read_parameters() {
        return new external_function_parameters(
                array(
                        'id' => new external_value(PARAM_INT, 'id of the notification'),
                        'timeread' => new external_value(PARAM_INT, 'timestamp for when the notification should be marked read',
                                VALUE_DEFAULT, 0)
                )
        );
    }

    public static function mark_mail_read($id, $timeread) {
        global $CFG, $DB, $USER;

        // Warnings array, it can be empty at the end but is mandatory.
        $warnings = array();

        // Validate params.
        $params = array(
                'id' => $id,
                'timeread' => $timeread
        );
        $params = self::validate_parameters(self::mark_mail_read_parameters(), $params);

        if (empty($params['timeread'])) {
            $timeread = time();
        } else {
            $timeread = $params['timeread'];
        }

        // Validate context.
        $context = context_system::instance();
        self::validate_context($context);

        $mail = $DB->get_record(helper::mailtable, ['id' => $params['id']], '*', MUST_EXIST);

        api::mark_mail_as_read($mail, $timeread);

        $results = array(
                'id' => $mail->id,
                'warnings' => $warnings
        );

        return $results;
    }

    public static function mark_mail_read_returns() {
        return new external_single_structure(
                array(
                        'id' => new external_value(PARAM_INT, 'id of the notification'),
                        'warnings' => new external_warnings()
                )
        );
    }
}