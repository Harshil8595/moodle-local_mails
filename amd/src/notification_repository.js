// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Retrieves notifications from the server.
 *
 * @module     local_mails/notification_repository
 * @class      notification_repository
 * @package    local_mails
 * @copyright  2020 Harshil Patel <harshil8595@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['core/ajax', 'core/notification'], function(Ajax, Notification) {
    /**
     * Retrieve a list of notifications from the server.
     *
     * @param {object} args The request arguments
     * @return {object} jQuery promise
     */
    var query = function(args) {
        if (typeof args.limit === 'undefined') {
            args.limit = 20;
        }

        if (typeof args.offset === 'undefined') {
            args.offset = 0;
        }

        var request = {
            methodname: 'local_mails_get_mails',
            args: args
        };

        var promise = Ajax.call([request])[0];

        promise.fail(Notification.exception);

        return promise;
    };

    /**
     * Get the number of unread notifications from the server.
     *
     * @param {object} args The request arguments
     * @return {object} jQuery promise
     */
    var countUnread = function(args) {
        var request = {
            methodname: 'local_mails_get_unread_count',
            args: args
        };

        var promise = Ajax.call([request])[0];

        promise.fail(Notification.exception);

        return promise;
    };

    /**
     * Mark all notifications for the given user as read.
     *
     * @param {object} args The request arguments:
     * @return {object} jQuery promise
     */
    var markAllAsRead = function(args) {
        var request = {
            methodname: 'local_mails_mark_all_mails_as_read',
            args: args
        };

        var promise = Ajax.call([request])[0];

        promise.fail(Notification.exception);

        return promise;
    };

    /**
     * Mark a specific notification as read.
     *
     * @param {int} id The notification id
     * @param {int} timeread The read timestamp (optional)
     * @return {object} jQuery promise
     */
    var markAsRead = function(id, timeread) {
        var args = {
            id: id,
        };

        if (timeread) {
            args.timeread = timeread;
        }

        var request = {
            methodname: 'local_mails_mark_mail_read',
            args: args
        };

        var promise = Ajax.call([request])[0];

        promise.fail(Notification.exception);

        return promise;
    };

    return {
        query: query,
        countUnread: countUnread,
        markAllAsRead: markAllAsRead,
        markAsRead: markAsRead,
    };
});
