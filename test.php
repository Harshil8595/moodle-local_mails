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

require_once '../../config.php';
$PAGE->set_context(context_system::instance());
$from = $USER;
$to = \core_user::get_user(4);
$from->customheaders = [
    'cc:adm@test.com',
    'bcc:adm@bbc.com',
];

var_dump(email_to_user($to,$from,
        'Test Subject','Test Message',
        '<h1>Test Message</h1>',
        $CFG->dirroot.'/TRADEMARK.txt',
        'trademark.txt'));