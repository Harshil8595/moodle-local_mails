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

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'local_mails_get_mails' => array(
        'classname' => 'local_mails\external',
        'methodname' => 'get_mails',
        'description' => 'Retrieve a list of mails for a user',
        'type' => 'read',
        'ajax' => true,
    ),
    'local_mails_get_unread_count' => array(
        'classname' => 'local_mails\external',
        'methodname' => 'get_unread_count',
        'description' => 'Retrieve the count of unread mails for a given user',
        'type' => 'read',
        'ajax' => true,
    ),
    'local_mails_mark_all_mails_as_read' => array(
        'classname' => 'local_mails\external',
        'methodname' => 'mark_all_mails_as_read',
        'description' => 'Mark all mails as read for a given user',
        'type' => 'write',
        'ajax' => true,
    ),
    'local_mails_mark_mail_read' => array(
        'classname' => 'local_mails\external',
        'methodname' => 'mark_mail_read',
        'description' => 'Mark a single mail as read',
        'type' => 'write',
        'ajax' => true,
    ),
);
