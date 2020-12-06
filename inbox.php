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
$PAGE->set_url(new moodle_url('/local/mails/inbox.php'));
$PAGE->set_pagelayout('popup');

/* @var $OUTPUT \core_renderer */
$plus = $OUTPUT->image_url('plus', 'local_mails');
$inbox = $OUTPUT->image_url('inbox', 'local_mails');
$draft = $OUTPUT->image_url('draft', 'local_mails');
$send = $OUTPUT->image_url('send', 'local_mails');
$spam = $OUTPUT->image_url('spam', 'local_mails');
$trash = $OUTPUT->image_url('trash', 'local_mails');
$star = $OUTPUT->image_url('star', 'local_mails');
$more = $OUTPUT->image_url('more', 'local_mails');
$print = $OUTPUT->image_url('print', 'local_mails');
$backspace = $OUTPUT->image_url('backspace', 'local_mails');
$doc = $OUTPUT->image_url('doc', 'local_mails');
$tag = $OUTPUT->image_url('tag', 'local_mails');
$pin = $OUTPUT->image_url('pin', 'local_mails');
$avatarurl = $OUTPUT->image_url('avatar', 'local_mails');

echo $OUTPUT->header();
?>
    <div id="snippetContent">
        <div class="container">
            <div class="content-wrapper">
                <div class="email-app card-margin">
                    <div class="email-toolbars-wrapper">
                        <div class="toolbar-header">
                            <button type="button" class="btn btn-lg btn-block btn-compose-mail"><img src="<?php echo $plus; ?>" class="feather feather-plus" /> Compose Mail</button>
                        </div>
                        <div class="toolbar-body">
                            <div class="toolbar-title">Folders</div>
                            <ul class="toolbar-menu">
                                <li class="active"><img src="<?php echo $inbox; ?>" class="feather feather-mail" /> <a href="#">Inbox</a> <span class="badge badge-sb-base">8</span></li>
                                <li><img src="<?php echo $draft; ?>" class="feather feather-copy" /> <a href="#">Drafts</a></li>
                                <li><img src="<?php echo $send; ?>" class="feather feather-send" /> <a href="#">Sent</a></li>
                                <li><img src="<?php echo $spam; ?>" class="feather feather-alert-circle" /> <a href="#">Spam</a></li>
                                <li><img src="<?php echo $trash; ?>" class="feather feather-trash-2" /> <a href="#">Trash</a></li>
                                <li><img src="<?php echo $star; ?>" class="feather feather-star" /> <a href="#">Starred</a></li>
                            </ul>
                            <div class="contact-header">
                                <div class="contact-left">
                                    <h5 class="title">Contacts</h5>
                                    <span class="badge badge-sb-success">10</span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-flash-primary" type="button" id="product-action-pane" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?php echo $more; ?>" class="feather feather-more-vertical toolbar-icon" />
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><span class="dropdown-title">Action Pane</span></li>
                                        <li class="dropdown-item">
                                            <a class="dropdown-link" href="#">
                                                <img src="<?php echo $print; ?>" class="feather feather-printer" />
                                                Print
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="dropdown-link" href="#">
                                                <img src="<?php echo $backspace; ?>" class="feather feather-delete" />
                                                Remove
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="dropdown-link" href="#">
                                                <img src="<?php echo $send; ?>" class="feather feather-send" />
                                                Send Email
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="dropdown-link" href="#">
                                                <img src="<?php echo $doc; ?>" class="feather feather-file-text" />
                                                Export as PDF
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="dropdown-link" href="#">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark" />
                                                Save as Bookmark
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="contact-list">
                                <li class="contact-list-item">
                                    <a href="#">
                                        <span class="pro-pic"> <img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <i class="active">&nbsp;</i> </span>
                                        <div class="user">
                                            <p class="user-name">Poul Smith</p>
                                            <p class="user-designation">Founder @ Maxx</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="contact-list-item">
                                    <a href="#">
                                        <span class="pro-pic"> <img src="<?php echo $avatarurl; ?>" alt="Support User" title="Support User" /> <i class="active">&nbsp;</i> </span>
                                        <div class="user">
                                            <p class="user-name">John Wick</p>
                                            <p class="user-designation">CTO @ Lax</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="contact-list-item">
                                    <a href="#">
                                        <span class="pro-pic"> <img src="<?php echo $avatarurl; ?>" alt="Support User" title="Support User" /> <i class="busy">&nbsp;</i> </span>
                                        <div class="user">
                                            <p class="user-name">Susan Don</p>
                                            <p class="user-designation">CEO @ Don Co.</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="contact-list-item">
                                    <a href="#">
                                        <span class="pro-pic"> <img src="<?php echo $avatarurl; ?>" alt="profile pic" title="profile pic" /> <i class="busy">&nbsp;</i> </span>
                                        <div class="user">
                                            <p class="user-name">Sam Doe</p>
                                            <p class="user-designation">Tech Lead @ Poll</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="contact-list-item">
                                    <a href="#">
                                        <span class="pro-pic"> <img src="<?php echo $avatarurl; ?>" alt="Support User" title="Support User" /> <i class="inactive">&nbsp;</i> </span>
                                        <div class="user">
                                            <p class="user-name">John Smith</p>
                                            <p class="user-designation">Founder @ Dove</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="email-list-wrapper">
                        <div class="email-list-header">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-flash-border-base shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Recent</button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li class="dropdown-item"><a class="dropdown-link" href="#">Focused</a></li>
                                    <li class="dropdown-item"><a class="dropdown-link" href="#">Others</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="email-app-body" class="email-list-scroll-container ps ps--active-y">
                            <ul class="email-list">
                                <li class="email-list-item">
                                    <div class="recipient"><img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <a href="#" class="recipient-name">Pepper Potts</a></div>
                                    <a href="#" class="email-subject">Food App IOS &amp; Android - Need confirmation to start project execution<i class="unread">&nbsp;</i></a>
                                    <div class="email-footer">
                                        <div class="email-action">
                                            <a href="#" class="important">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark fill" />
                                            </a>
                                            <a href="#" class="starred">
                                                <img src="<?php echo $star; ?>" class="feather feather-star" />
                                            </a>
                                            <a href="#" class="attachment">
                                                <img src="<?php echo $pin; ?>" class="feather feather-paperclip" />
                                            </a>
                                        </div>
                                        <span class="email-time">11:50 AM</span>
                                    </div>
                                </li>
                                <li class="email-list-item active">
                                    <div class="recipient"><img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <a href="#" class="recipient-name">Poul Smith</a></div>
                                    <a href="#" class="email-subject">Prepare Mockup as per the spec document and Submit by Monday!!!<i class="unread">&nbsp;</i></a>
                                    <div class="email-footer">
                                        <div class="email-action">
                                            <a href="#" class="important">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark" />
                                            </a>
                                            <a href="#" class="starred">
                                                <img src="<?php echo $star; ?>" class="feather feather-star fill" />
                                            </a>
                                            <a href="#" class="attachment">
                                                <img src="<?php echo $pin; ?>" class="feather feather-paperclip" />
                                            </a>
                                        </div>
                                        <span class="email-time">11:50 AM</span>
                                    </div>
                                </li>
                                <li class="email-list-item">
                                    <div class="recipient"><img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <a href="#" class="recipient-name">Edwin Jarvis</a></div>
                                    <a href="#" class="email-subject">FixBazzar - Assign developer to develop project <i class="unread">&nbsp;</i></a>
                                    <div class="email-footer">
                                        <div class="email-action">
                                            <a href="#" class="important">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark fill" />
                                            </a>
                                            <a href="#" class="starred">
                                                <img src="<?php echo $star; ?>" class="feather feather-star" />
                                            </a>
                                            <a href="#" class="attachment">
                                                <img src="<?php echo $pin; ?>" class="feather feather-paperclip" />
                                            </a>
                                        </div>
                                        <span class="email-time">11:50 AM</span>
                                    </div>
                                </li>
                                <li class="email-list-item">
                                    <div class="recipient"><img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <a href="#" class="recipient-name">Edwin Jarvis</a></div>
                                    <a href="#" class="email-subject">Maxximo App - Request approved to deploy on server<i class="starred">&nbsp;</i></a>
                                    <div class="email-footer">
                                        <div class="email-action">
                                            <a href="#" class="important">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark" />
                                            </a>
                                            <a href="#" class="starred">
                                                <img src="<?php echo $star; ?>" class="feather feather-star fill" />
                                            </a>
                                            <a href="#" class="attachment">
                                                <img src="<?php echo $pin; ?>" class="feather feather-paperclip" />
                                            </a>
                                        </div>
                                        <span class="email-time">11:50 AM</span>
                                    </div>
                                </li>
                                <li class="email-list-item">
                                    <div class="recipient"><img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <a href="#" class="recipient-name">Jim Ward</a></div>
                                    <a href="#" class="email-subject">Invitation to join tech team meeting<i class="starred">&nbsp;</i></a>
                                    <div class="email-footer">
                                        <div class="email-action">
                                            <a href="#" class="important">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark fill" />
                                            </a>
                                            <a href="#" class="starred">
                                                <img src="<?php echo $star; ?>" class="feather feather-star fill" />
                                            </a>
                                            <a href="#" class="attachment">
                                                <img src="<?php echo $pin; ?>" class="feather feather-paperclip" />
                                            </a>
                                        </div>
                                        <span class="email-time">11:50 AM</span>
                                    </div>
                                </li>
                                <li class="email-list-item">
                                    <div class="recipient"><img src="<?php echo $avatarurl; ?>" alt="Profile Picture" /> <a href="#" class="recipient-name">Jane Doe</a></div>
                                    <a href="#" class="email-subject">DexLoop - Progress report<i class="starred">&nbsp;</i></a>
                                    <div class="email-footer">
                                        <div class="email-action">
                                            <a href="#" class="important">
                                                <img src="<?php echo $tag; ?>" class="feather feather-bookmark fill" />
                                            </a>
                                            <a href="#" class="starred">
                                                <img src="<?php echo $star; ?>" class="feather feather-star" />
                                            </a>
                                            <a href="#" class="attachment">
                                                <img src="<?php echo $pin; ?>" class="feather feather-paperclip" />
                                            </a>
                                        </div>
                                        <span class="email-time">11:50 AM</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; height: 911px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 772px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="email-desc-wrapper">
                        <div class="email-header">
                            <div class="email-date">Dec 1, 2019 12:02 PM</div>
                            <div class="email-subject">Prepare Mockup as per the spec document and Submit by Monday!!!</div>
                            <p class="recipient"><span>From:</span> Paul Smith &lt;paul.smith@domain.com&gt;</p>
                        </div>
                        <div class="email-body">
                            <p>Hi Jacob,</p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam accumsan orci ac urna tristique luctus. Duis sollicitudin quam eu ante faucibus, in fringilla sem placerat. Praesent eget nisi quis mauris luctus
                                dignissim. Nullam vel commodo augue, vitae auctor odio. Sed vel placerat nisi. Aliquam erat volutpat. Etiam mattis nisl magna, vel laoreet dolor hendrerit ut.
                            </p>
                            <p>
                                Etiam condimentum accumsan ligula eu ornare. Ut bibendum, lacus et tempus molestie, eros velit tincidunt felis, in dictum dolor nulla non dolor. Nulla ut dui gravida, interdum massa non, egestas lacus. Praesent
                                hendrerit nisl pellentesque massa aliquam, nec ultrices risus condimentum.
                            </p>
                            <p>
                                Thanks &amp; Regards <br />
                                Julian Cruise
                            </p>
                        </div>
                        <div class="email-attachment">
                            <div class="file-info">
                                <div class="file-size"><img src="<?php echo $pin; ?>" class="feather feather-paperclip" /> <span>Attachment (90 MB)</span></div>
                                <button class="btn btn-sm btn-soft-base">View All</button>
                                <button class="btn btn-sm btn-soft-success">Download All</button>
                            </div>
                            <ul class="attachment-list">
                                <li class="attachment-list-item"><img src="<?php echo $avatarurl; ?>" alt="Showcase" title="Showcase" /></li>
                                <li class="attachment-list-item"><img src="<?php echo $avatarurl; ?>" alt="Showcase" title="Showcase" /></li>
                                <li class="attachment-list-item"><img src="<?php echo $avatarurl; ?>" alt="Showcase" title="Showcase" /></li>
                                <li class="attachment-list-item"><img src="<?php echo $avatarurl; ?>" alt="Showcase" title="Showcase" /></li>
                                <li class="attachment-list-item"><span class="text-base">30+</span></li>
                            </ul>
                        </div>
                        <div class="email-action">
                            <button class="btn btn-base">Reply <i class="fa fa-reply"></i></button>
                            <button class="btn btn-info"><i class="fa fa-share"></i> Forward</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            body {
                background: #dcdcdc;
                margin-top: 20px;
            }

            .email-app {
                display: flex;
            }

            .email-app .email-toolbars-wrapper {
                background-color: #ffffff;
                width: 20%;
                margin-right: 1.5rem;
                border-radius: 4px;
                box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            }

            .email-app .email-toolbars-wrapper .toolbar-header {
                padding: 1rem;
                flex-flow: row;
                display: flex;
                align-items: center;
            }

            .email-app .email-toolbars-wrapper .toolbar-header .btn-compose-mail {
                background: #f4f7fd;
                font-weight: 300;
                letter-spacing: 0.5px;
                border: none;
                transition: all, 0.3s;
                color: #ffffff;
                background-image: -webkit-linear-gradient(left, #22b9ff 0%, rgba(34, 185, 255, 0.7) 100%);
                background-image: -o-linear-gradient(left, #22b9ff 0%, rgba(34, 185, 255, 0.7) 100%);
                background-image: linear-gradient(to right, #22b9ff 0%, rgba(34, 185, 255, 0.7) 100%);
                background-repeat: repeat-x;
                filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#FF22B9FF', endColorstr='#B322B9FF', GradientType=1);
            }

            @media (prefers-reduced-motion: reduce) {
                .email-app .email-toolbars-wrapper .toolbar-header .btn-compose-mail {
                    transition: none;
                }
            }

            .email-app .email-toolbars-wrapper .toolbar-header .btn-compose-mail svg {
                color: #ffffff;
                width: 22px;
                height: 22px;
            }

            .email-app .email-toolbars-wrapper .toolbar-header .btn-compose-mail:hover {
                box-shadow: 0px 1px 6px 0px rgba(34, 185, 255, 0.75);
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-title {
                color: #727686;
                padding: 0 1rem 0.5rem 1rem;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu {
                padding: 0;
                margin-bottom: 1rem;
                height: auto;
                list-style-type: none;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li {
                display: flex;
                align-items: center;
                padding: 0.5rem 1rem;
                transition: 0.4s;
                position: relative;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li:hover {
                color: #22b9ff;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li:hover a {
                color: #22b9ff;
                font-weight: 600;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li svg {
                margin-right: 0.625rem;
                width: 1rem;
                height: 1rem;
                line-height: 1.5;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li a {
                flex: 1;
                color: #394044;
                font-size: 14px;
                text-decoration: none;
                transition: all, 0.3s;
            }

            @media (prefers-reduced-motion: reduce) {
                .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li a {
                    transition: none;
                }
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li.active a {
                color: #22b9ff;
                font-weight: 600;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .toolbar-menu li.active svg {
                color: #22b9ff;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-header {
                padding: 1rem;
                justify-content: space-between;
                display: flex;
                align-items: center;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-header .contact-left {
                display: flex;
                align-items: center;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-header .contact-left .title {
                margin: 0 1rem 0 0;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-header .dropdown {
                float: right;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list {
                padding: 0 1rem;
                list-style-type: none;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item {
                padding: 0.625rem 0;
                display: block;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item:last-child {
                border-bottom: 0;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a {
                text-decoration: none;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .pro-pic {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                padding: 0;
                width: 20%;
                max-width: 40px;
                position: relative;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .pro-pic img {
                max-width: 100%;
                width: 100%;
                border-radius: 100%;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .pro-pic .active {
                width: 12px;
                height: 12px;
                background: #17d1bd;
                border-radius: 100%;
                position: absolute;
                top: 6px;
                right: -4px;
                border: 2px solid #ffffff;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .pro-pic .inactive {
                width: 12px;
                height: 12px;
                background: #dde1e9;
                border-radius: 100%;
                position: absolute;
                top: 6px;
                right: -4px;
                border: 2px solid #ffffff;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .pro-pic .busy {
                width: 12px;
                height: 12px;
                background: #f95062;
                border-radius: 100%;
                position: absolute;
                top: 6px;
                right: -4px;
                border: 2px solid #ffffff;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .user {
                width: 100%;
                padding: 5px 10px 0 15px;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .user .user-name {
                margin: 0;
                font-weight: 400;
                font-size: 13px;
                line-height: 1;
                color: #394044;
            }

            .email-app .email-toolbars-wrapper .toolbar-body .contact-list .contact-list-item a .user .user-designation {
                font-size: 12px;
                color: #727686;
                overflow: hidden;
                max-width: 100%;
                white-space: nowrap;
                margin-bottom: 0;
            }

            .email-app .email-list-wrapper {
                width: 30%;
                margin-right: 1.5rem;
            }

            .email-app .email-list-wrapper .email-list-scroll-container {
                height: 100vh;
                position: relative;
            }

            .email-app .email-list-wrapper .email-list-header {
                padding: 1rem 0;
                flex-direction: row;
                justify-content: space-between;
                display: flex;
                align-items: center;
            }

            .email-app .email-list-wrapper .email-list {
                height: calc(100vh - 70px);
                list-style-type: none;
                padding: 0;
            }

            .email-app .email-list-wrapper .email-list .email-list-item {
                margin-bottom: 1.2rem;
                background-color: #ffffff;
                padding: 1rem;
                display: flex;
                flex-direction: column;
                text-decoration: none;
                border-radius: 4px;
                box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            }

            .email-app .email-list-wrapper .email-list .email-list-item.active {
                border: 1.5px solid #22b9ff;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .recipient {
                display: flex;
                align-items: center;
                flex-shrink: 0;
                padding: 0;
                margin-bottom: 0.7rem;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .recipient img {
                margin-right: 0.5rem;
                width: 40px;
                height: 40px;
                border-radius: 100%;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .recipient .recipient-name {
                font-weight: 500;
                font-size: 14px;
                line-height: 1;
                color: #727686;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .recipient .recipient-name:hover {
                color: #22b9ff;
                text-decoration: none;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-subject {
                display: flex;
                align-items: center;
                justify-content: space-between;
                color: #394044;
                font-size: 1rem;
                font-weight: 400;
                margin-bottom: 0.7rem;
                text-decoration: none;
                line-height: 1.5;
                transition: all, 0.3s;
            }

            @media (prefers-reduced-motion: reduce) {
                .email-app .email-list-wrapper .email-list .email-list-item .email-subject {
                    transition: none;
                }
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-subject .unread {
                flex-shrink: 0;
                margin-left: 1rem;
                width: 0.5rem;
                height: 0.5rem;
                border-radius: 100%;
                display: block;
                background: #22b9ff;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-subject:hover {
                color: #22b9ff;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a {
                margin-right: 0.5rem;
                transition: all, 0.3s;
            }

            @media (prefers-reduced-motion: reduce) {
                .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a {
                    transition: none;
                }
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a.starred {
                color: #fd7e14;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a.starred .fill {
                stroke-width: 1px;
                fill: #fd7e14;
                color: #fd7e14;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a.important {
                color: #ffc107;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a.important .fill {
                stroke-width: 1px;
                fill: #ffc107;
                color: #ffc107;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a.attachment {
                color: #727686;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a.attachment:hover {
                color: #22b9ff;
                text-decoration: none;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-action a svg {
                width: 20px;
                height: 20px;
            }

            .email-app .email-list-wrapper .email-list .email-list-item .email-footer .email-time {
                color: #b1bac5;
            }

            .email-app .email-desc-wrapper {
                width: 50%;
                background-color: #ffffff;
                padding: 2rem;
                border-radius: 4px;
                box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            }

            .email-app .email-desc-wrapper .email-header {
                margin-bottom: 1.5rem;
            }

            .email-app .email-desc-wrapper .email-header .email-date {
                color: #727686;
                font-size: 13px;
                margin-bottom: 0.5rem;
            }

            .email-app .email-desc-wrapper .email-header .email-subject {
                color: #394044;
                font-size: 1.2rem;
                line-height: 1.5;
                font-weight: 500;
                margin-bottom: 0.8rem;
                flex-shrink: 0;
            }

            .email-app .email-desc-wrapper .email-header .recipient {
                margin: 0;
                font-size: 14px;
                line-height: 1;
                color: #727686;
            }

            .email-app .email-desc-wrapper .email-header .recipient span {
                font-weight: 500;
                color: #394044;
            }

            .email-app .email-desc-wrapper .email-body {
                min-height: 350px;
                color: #727686;
                margin-bottom: 2rem;
            }

            .email-app .email-desc-wrapper .email-body p {
                font-size: 13px;
                margin-bottom: 1rem;
                line-height: 2;
            }

            .email-app .email-desc-wrapper .email-attachment {
                margin-bottom: 2rem;
            }

            .email-app .email-desc-wrapper .email-attachment .file-info {
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
            }

            .email-app .email-desc-wrapper .email-attachment .file-info .file-size {
                color: #b1bac5;
                margin-right: 0.5rem;
                display: flex;
                align-items: center;
            }

            .email-app .email-desc-wrapper .email-attachment .file-info .file-size svg {
                width: 20px;
                height: 20px;
                margin-right: 0.5rem;
            }

            .email-app .email-desc-wrapper .email-attachment .file-info .btn,
            .email-app .email-desc-wrapper .email-attachment .file-info .wizard > .actions a,
            .wizard > .actions .email-app .email-desc-wrapper .email-attachment .file-info a,
            .email-app .email-desc-wrapper .email-attachment .file-info .fc button,
            .fc .email-app .email-desc-wrapper .email-attachment .file-info button {
                font-size: 13px;
                margin-right: 0.5rem;
                padding: 0.1875rem 0.7rem;
                box-shadow: none;
            }

            .email-app .email-desc-wrapper .email-attachment .attachment-list {
                padding: 0;
                height: 100%;
            }

            .email-app .email-desc-wrapper .email-attachment .attachment-list .attachment-list-item {
                display: inline-block;
                text-align: center;
                vertical-align: middle;
                width: 80px;
                height: 80px;
                overflow: hidden;
                margin: 0 0.5rem 0.5rem 0;
                background-color: #d3f1ff;
                border-radius: 4px;
            }

            .email-app .email-desc-wrapper .email-attachment .attachment-list .attachment-list-item span {
                height: 80px;
                display: table-cell;
                vertical-align: middle;
                width: 80px;
                font-weight: 300;
                font-size: 1.5rem;
            }

            .email-app .email-desc-wrapper .email-attachment .attachment-list .attachment-list-item img {
                width: 100%;
                height: 100%;
            }

            .email-app .email-desc-wrapper .email-attachment .attachment-list .attachment-list-item:hover {
                cursor: pointer;
            }

            .email-app .email-desc-wrapper .email-action .btn,
            .email-app .email-desc-wrapper .email-action .wizard > .actions a,
            .wizard > .actions .email-app .email-desc-wrapper .email-action a,
            .email-app .email-desc-wrapper .email-action .fc button,
            .fc .email-app .email-desc-wrapper .email-action button {
                margin-right: 0.7rem;
            }

            .email-app .email-desc-wrapper .email-action .btn:first-child i,
            .email-app .email-desc-wrapper .email-action .wizard > .actions a:first-child i,
            .wizard > .actions .email-app .email-desc-wrapper .email-action a:first-child i,
            .email-app .email-desc-wrapper .email-action .fc button:first-child i,
            .fc .email-app .email-desc-wrapper .email-action button:first-child i {
                font-size: 13px;
                margin-left: 0.5rem;
            }

            .email-app .email-desc-wrapper .email-action .btn:last-child i,
            .email-app .email-desc-wrapper .email-action .wizard > .actions a:last-child i,
            .wizard > .actions .email-app .email-desc-wrapper .email-action a:last-child i,
            .email-app .email-desc-wrapper .email-action .fc button:last-child i,
            .fc .email-app .email-desc-wrapper .email-action button:last-child i {
                font-size: 13px;
                margin-right: 0.5rem;
            }

            @media (max-width: 575px) {
                .email-app .email-toolbars-wrapper,
                .email-app .email-desc-wrapper {
                    display: none;
                }
                .email-app .email-list-wrapper {
                    width: 100%;
                    margin: 0;
                }
            }

            @media (min-width: 600px) and (max-width: 1024px) {
                .email-app .email-toolbars-wrapper {
                    display: none;
                }
                .email-app .email-desc-wrapper {
                    width: 60%;
                }
                .email-app .email-list-wrapper {
                    width: 40%;
                }
            }
        </style>
        <style>
            #region-main {
                background-color: transparent;
                border-color: transparent;
            }
        </style>
    </div>
<?php
echo $OUTPUT->footer();