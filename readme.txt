=== Plugin Name ===
Contributors: Crazy Loong, quanganhdo(under version 2.0)
Tags: smilies, smileys, posts, comments
Requires at least: 2.3
Tested up to: 2.7
Stable tag: 2.5

Custom Smilies (previously named Custom Smileys) gives you a chance to personalize your posts and comments using smilies of your choice instead of default ones.

== Description ==

Custom Smilies (previously named Custom Smileys) gives you a chance to personalize your posts and comments using smilies of your choice instead of default ones.

Custom Smilies was selected as one of [30+ plugins for WordPress comments](http://mashable.com/2007/07/24/wordpress-comments/ "30+ plugins for WordPress comments") and [300+ tools for running your WordPress blog](http://mashable.com/2007/08/16/wordpress-god300-tools-for-running-your-wordpress-blog/ "300+ tools for running your WordPress blog"). These lists were conducted by Mashable, as of July 24th, 2007 and August 16th, 2007.

This plugin was first released in 2005 and it is now updated to be compatible with WordPress 2.3.2.

- Version 2.5:
	+ Fixed: A JS error in IE.
- Version 2.3:
	+ Fixed: Serious logical bug.
- Version 2.2:
	+ Fixed: The method of checking init.php
	+ Fixed: Optimize tips.
	+ Added: l8n and L10n.
	+ Added: Add cs_print_smilies() to the action named comment_form.
	+ Fixed: Replace init.php with DB.
	+ Added: TinyMCE button.
- Version 2.1:
	+ Added: Check whether init.php is writeable.
	+ Fixed: Fix the path of init.php
- Version 2.0:
	+ Fixed: Support WordPress 2.5 or greater
- Version 1.2:
	+ Added: More/Less link
	+ Fixed: Blog URL changed to WordPress URL
- Version 1.1: 
	+ Added: Automatically put a space after the smilie
	+ Added: The ability to specify which smilies to be displayed above the comment form
	+ Added: Return all smilies with cs_all_smilies()
	+ Fixed: Problems with file names 
- Version 1.0: First release. 

== Installation ==

1. Download and extract custom-smilies.zip; then, upload `init.php` and `custom-smilies.php` to the `/wp-content/plugins/custom-smilies` directory. Upload `smilies` folder to the `/wp-includes/images` directory.
1. Activate Custom Smilies in your Admin Panel
1. Put your smilies in smilies folder (wp-includes/images/smilies/)
1. Change the emoticons by navigating to Manage > Smilies and complete the form

Advanced use: [Click here to read my blog post](http://onetruebrace.com/custom-smilies "Custom Smilies")

== Screenshots ==

1. Smilies Manager
2. Docking box
3. Personalize your comments

== Troubleshooting ==

In case Custom Smilies doesn’t work well with your blog, make sure the `wp-plugins/custom-smilies/init.php` file is writable. CHMOD it to 777 or something like that.