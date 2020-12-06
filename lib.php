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

use local_mails\api;
use local_mails\helper;

function local_mails_render_navbar_output(renderer_base $renderer) {
    global $USER, $CFG;

    // Early bail out conditions.
    if (!isloggedin() || isguestuser() || user_not_fully_set_up($USER) ||
            get_user_preferences('auth_forcepasswordchange') ||
            (!$USER->policyagreed && !is_siteadmin() &&
                    ($manager = new \core_privacy\local\sitepolicy\manager()) && $manager->is_defined())) {
        return '';
    }

    $output = '';

    $userid = $USER->id;
    $unreadcount = api::get_unread_count($userid);
    $context = [
            'userid' => $userid,
            'unreadcount' => $unreadcount,
            'urls' => [
                    'seeall' => (new moodle_url('/local/mails/index.php'))->out(),
            ],
            'limit' => helper::perpage,
            'types' => helper::get_mailtypes(),
            'canseeall' => helper::is_manager($userid),
    ];
    $output .= $renderer->render_from_template('local_mails/notification_popover', $context);

    return $output;
}

function local_mails_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    global $DB, $USER;

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }

    require_login();

    if ($filearea !== local_mails\helper::attachmentarea) {
        send_file_not_found();
    }

    $mailid = array_shift($args);

    if (!helper::check_user($mailid,$USER->email,$USER->id)) {
        send_file_not_found();
    }

    $fs = get_file_storage();

    $filename = array_pop($args);
    $filepath = $args ? '/' . implode('/', $args) . '/' : '/';

    if (!$file = $fs->get_file($context->id, local_mails\helper::component,
                    local_mails\helper::attachmentarea, $mailid,
                    $filepath, $filename) or $file->is_directory()) {
        send_file_not_found();
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}

function local_mails_get_fontawesome_icon_map() {
    return [
            'local_mails:icon' => 'fa-envelope',
            'local_mails:attachment' => 'fa-paperclip',
            'local_mails:pin' => 'fa-paperclip',
            'local_mails:backspace' => 'fa-backspace',
            'local_mails:doc' => 'fa-file',
            'local_mails:inbox' => 'fa-inbox',
            'local_mails:send' => 'fa-paper-plane',
            'local_mails:star' => 'fa-star',
            'local_mails:close' => 'fa-times',
    ];
}

function local_mails_extend_navigation(global_navigation $nav){
    global $USER;
    if(isloggedin()){
        $comp = local_mails\helper::component;
        $text = \get_string('mailbox',$comp);
        $unreadcount = api::get_unread_count($USER->id);
        if($unreadcount > 0){
            $text = html_writer::div($text.
            html_writer::span($unreadcount,'badge badge-primary ml-2',[
                    'data-region' => "mails-count-container",
            ]));
        }
        $url = new moodle_url('/local/mails/index.php');
        $nav->add($text,$url,navigation_node::TYPE_CUSTOM,
                null, $comp,new pix_icon('icon',$text, $comp)
                )->showinflatnavigation = true;
    }
    return true;
}
