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

require_once(__DIR__ . '/../../config.php');

require_login(null, false);

if (isguestuser()) {
    redirect($CFG->wwwroot);
}

$id = required_param('id', PARAM_INT);

$mail = $DB->get_record(helper::mailtable, array('id' => $id));

$redirecturl = new moodle_url('/local/mails/index.php', ['id' => $id]);

// Check notification belongs to this user.
if (!helper::check_user($mail,$USER->email,$USER)) {
    redirect($CFG->wwwroot);
}

api::mark_mail_as_read($mail);
redirect($redirecturl);
