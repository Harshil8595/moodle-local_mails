# moodle-local_mails

This is Mailbox plugin for moodle

Plugin is useful for developer and QA/tester

To use this plugin either

[If you are server administrator]
add `send_mail_path=[Your Moodle Directory]/local/mails/cli/parse.php` to loading php ini and php cli init path

or
[Core Modification] 
add just `use \local_mails\traits\mailer;` to closing bracket of moodle_phpmailer([Your Moodle Directory]/lib/phpmailer/moodle_phpmailer.php) class
