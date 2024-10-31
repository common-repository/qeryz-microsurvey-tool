=== Qeryz Wordpress Survey ===
Contributors: h3sean
Donate link: https://qeryz.com/
Tags: survey tool, qeryz, microsurvey, wordpress survey
Requires at least: 3.0.1
Tested up to: 5.0.1
Stable tag: 1.6.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Qeryz is a pop-up, as-you-go microsurvey that you can put in any and every webpage you have in your website.

== Description ==

Get 700% more responses than a normal survey.
Qeryz is a pop-up, as-you-go microsurvey tool that you can put in any and every webpage you have in your website. 
Never ask your customers to click on a link to go to your survey. Gather customer insights without the hassle. 
Create surveys in multiple choice, checkbox, scale or a simple text area.

 = IMPORTANT =
Qeryz Microsurvey has renamed to Qeryz Wordpress Survey. If you have trouble updating your plugin, just delete the old version and install the newer version of the plugin.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Sign in to the survey using your Qeryz username and password.
4. Activate your survey in your Qeryz dashboard

== Frequently Asked Questions ==

= What is this plugin for? =

This plugin is developed so that you don't have to copy-paste the Qeryz code to each of your pages in Wordpress. Simply enter your email and password and activate your Qeryz survey for you to get started with Qeryz.

= Where can I get my Qeryz account? =

Qeryz is Free. You can get your account by registering to www.qeryz.com.

= Can I edit my survey? = 
Yes, you can edit your survey. Just log in to Qeryz dashboard.

== Screenshots ==

1. screenshot1.png 
2. screenshot2.jpg
3. screenshot3.png

== Upgrade Notice ==

= 1.6.3 =
* If the survey is not showing after updating the plugin, please click on deactivate link located at the top right of the plugin dashboard and try to login again.

* If you manually pasted the identity code and installed the plugin, please remove the pasted code or just remove the installed plugin.

== Changelog ==

= 1.6.3 =
* Tested plugin's compatibility for WordPress 4.7
* Edit text

= 1.6.2 =
* Added \' in popup login message
* Change metabox div id 

= 1.6.1 =
* Change the position of signup button
* Added global $current_user in qeryz identity tracking
* Change ENTER IDENTITY HERE to $current_user->firstname and $current_user->user_email as default in identity tracking 

= 1.6.0 =
* Added Identity features in Qeryz plugin dashboard
* Added comment tags on functions
* Change Sign up url link
* Rephrase Qeryz login notification
* Removed constant QERYZ_SIGNUP_REDIRECT_URL

= 1.5.0 =
* Updated Qeryz Javascript Version to 3.2

= 1.4.0 =
* Updated Qeryz Tracking Code
* Removed uneccessary var qryz_s on qeryz code
* Make var qRz global by putting it before the function
* Added Wordpress Plugin in the comment bar

= 1.3.3 =
* Added is_wp_error to check if request is failure  
* Added qeryz_ on some variables 
* Change comparison operator

= 1.3.2 =
* Fix Login Error bug
* Change signup url 

= 1.3.1 =
* "Launch Qeryz" button can now access dashboard 
* Change form login field names
* Change login url and dashboard url
* Change launch qeryz link into button type
* Added form into Launch Qeryz button

= 1.3.0 =
* Change Qeryz tracking code
* Change array request
* Fix fatal error cannot use object of type wp_error as array

= 1.2.0 =
* Rename plugin into Qeryz Wordpress Survey
* Added notification in plugin page if account is not yet login
* Change Screenshots in Qeryz plugin page
* Added some new frequently asked question.

= 1.1.3 =
* Rename user_details.txt file to qeryz_user_details.txt
* Change the location of qeryz_user_details.txt file from wp-admin folder to plugin directory
* Added $qeryz_user_details variable for qeryz_user_details.txt location 
* Remove unnecessary div tags
* Added icon-128x128.png and icon-256x256.png on assets folder

= 1.1.2 =
* Fix error for logging
* Commented url replace on wp_remote_post

= 1.1.1 =
* Change wp_register_script qeryz_cookie to qeryz_js
* Change qryz_v3.js to qryz_wordpress_v3.js
* Change button's label to Launch Qeryz in admin panel
* Change php Constant http to https
* Change the password value to "" if password is not blank

= 1.1.0 =
* Change jquery to javascript qeryz code to avoid conflict in other plugins and themes
* Remove cookie.js file in plugin
* Added new javascript file
* Remove image in survey button
* Fix survey button
* Bugfix on survey not showing on some sites
* Change QERYZ_SIGN_UP URL
* Added user_details.txt on wp_admin to access qeryz account in dashboard
* Remove qeryz_cookie

= 1.0 =
* First version. No changes yet.
