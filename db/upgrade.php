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

function xmldb_local_mails_upgrade($oldversion) {
    global $CFG,$DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2020080101) {

        // Define table local_mail to be created.
        $table = new xmldb_table('local_mail');

        // Adding fields to table local_mail.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('mail', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('subject', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('timesent', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timeread', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table local_mail.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Adding indexes to table local_mail.
        $table->add_index('umail', XMLDB_INDEX_NOTUNIQUE, ['mail']);

        // Conditionally launch create table for local_mail.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table local_mail_receipent to be created.
        $table = new xmldb_table('local_mail_receipent');

        // Adding fields to table local_mail_receipent.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('mailid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('mail', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('type', XMLDB_TYPE_CHAR, '5', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_mail_receipent.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('fkmailid', XMLDB_KEY_FOREIGN, ['mailid'], 'local_mail', ['id']);

        // Adding indexes to table local_mail_receipent.
        $table->add_index('umail', XMLDB_INDEX_NOTUNIQUE, ['mail']);

        // Conditionally launch create table for local_mail_receipent.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Mails savepoint reached.
        upgrade_plugin_savepoint(true, 2020080101, 'local', 'mails');
    }


    return true;
}
