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

use local_mails\helper;

require_once(__DIR__ . '/../../config.php');

$id = optional_param('id', 0, PARAM_INT);
$offset = optional_param('offset', 0, PARAM_INT);
$limit = optional_param('limit', helper::pagesize, PARAM_INT);
$userid = $USER->id;

$url = new moodle_url('/local/mails/index.php');
$url->param('id', $id);

$PAGE->set_url($url);

require_login();

if (isguestuser()) {
    print_error('guestnoeditmessage', 'message');
}

if (!$user = $DB->get_record('user', ['id' => $userid])) {
    print_error('invaliduserid');
}

$personalcontext = context_user::instance($user->id);

$PAGE->set_context($personalcontext);
$PAGE->set_pagelayout('admin');

// Display page header.
$title = get_string('pluginname', 'local_mails');
$PAGE->set_title("{$SITE->shortname}: " . $title);
$PAGE->set_heading(fullname($user));

// Grab the renderer.
$renderer = $PAGE->get_renderer('core');
$context = [
    'id' => $id,
    'userid' => $userid,
    'limit' => $limit,
    'offset' => $offset,
    'types' => helper::get_mailtypes(),
    'canseeall' => helper::is_manager($userid),
];

echo $OUTPUT->header();
//echo $OUTPUT->heading($title);

echo $renderer->render_from_template('local_mails/notification_area', $context);
echo $OUTPUT->footer();

