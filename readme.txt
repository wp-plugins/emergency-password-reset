=== Emergency Password Reset ===
Contributors: andymoyle
Donate link: http://www.themoyles.co.uk/
Tags: emergency password reset
Requires at least: 2.7.0
Tested up to: 4.2
Stable tag: 0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows the admin to reset all the passwords and automatically email them out 

== Description ==

This plugin allows the admin to reset all the passwords and automatically email them out 

== Installation ==

1. Upload the `emergency-password-reset` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Click on Emergency Password Reset in the Users menu
4. Click on the 'Reset Passwords' button
5. If you still have "admin" as a username, a form is displayed to change it - really important as hackers often do automated login attempts with admin username.

== Frequently Asked Questions ==
= How does it work? =
When you click rest passwords, the plugin recreates random passwords for every user and emails them the new password. If the user doesn't get the email they will have to click the Lost password link to recreate their password!

= Will I be secure now from a hack? =
Not necessarily. We advise you change your SALTS in the wp-config.php file which will force logouts for all users. Wordpress provide a <a href="https://api.wordpress.org/secret-key/1.1/salt/">tool</a> to generate new ones.
Check out our <a href="http://www.themoyles.co.uk/2013/02/so-your-wordpress-site-has-been-hacked/">blog post</a> on hacked Wordpress sites


== Screenshots ==
1. The main and only screen!

== Changelog ==
* 0.5 Form to change username from "admin"
* 0.4 Shows WP 4.0 compatability
* 0.3 Add Screenshot
* 0.2 Correct the title in readme.txt!
* 0.1 Initial release


== Upgrade notice ==
* 0.5

