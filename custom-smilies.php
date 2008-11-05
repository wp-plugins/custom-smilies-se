<?php
/*
Plugin Name: Custom Smilies
Plugin URI: http://goto8848.net/projects/custom-smilies/
Description: Personalize your posts and comments using custom smilies. Previously named Custom Smileys. it (older than version  2.0) maintained by <a href="http://onetruebrace.com/2007/11/28/custom-smilies/">QAD</a>.
Author: Crazy Loong
Version: 2.2
Author URI: http://goto8848.net

Copyright 2005 - 2008 Crazy Loong  (email : crazyloong@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Version History:
----------------- Do it by QAD ---------------------
- Version 1.0: First release. 
- Version 1.1: 
	+ Added: Automatically put a space after the smilie
	+ Added: The ability to specify which smilies to be displayed above the comment form
	+ Added: Return all smilies with cs_all_smilies()
	+ Fixed: Problems with file names 
- Version 1.2:
	+ Added: More/Less link
	+ Fixed: Blog URL changed to WordPress URL
----------------- Do it by Crazy Loong -------------
- Version 2.0:
	+ Fixed: Support WordPress 2.5 or greater
- Version 2.1:
	+ Added: Check whether init.php is writeable.
	+ Fixed: Fix the path of init.php
- Version 2.2:
	+ Fixed: The method of checking init.php
	+ Fixed: Optimize tips.
	+ Added: l8n and L10n.
	+ Added: Add cs_print_smilies() to the action named comment_form.
	+ Fixed: Replace init.php with DB.
	+ Added: TinyMCE button.
*/
// Pre-2.6 compatibility
if (!defined('WP_CONTENT_URL'))
	define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if (!defined('WP_CONTENT_DIR'))
	define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
if (!defined('WP_PLUGIN_URL'))
	define('WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins');
if (!defined('WP_PLUGIN_DIR'))
	define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

define('CLCSABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
define('CLCSABSFILE', str_replace('\\', '/', dirname(__FILE__)) . '/' . basename(__FILE__));
define('CLCSINITABSPATH', CLCSABSPATH . 'init.php');
define('CLCSMGRURL', get_option('siteurl') . '/wp-admin/edit.php?page=' . plugin_basename(CLCSABSFILE));
define('CLCSURL', get_option('siteurl') . '/wp-content/plugins/custom-smilies-se/');

if (function_exists('load_plugin_textdomain')) {
	load_plugin_textdomain('custom_smilies', PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)) . '/lang');
}

$wpsmiliestrans = get_option('clcs_smilies');

global $wp_version;
if (version_compare($wp_version, '2.5', '<')) {
	include('forold.php'); // For 2.3
} else {
	include('for25.php'); // For 2.5 and above

	add_filter('plugin_action_links', 'add_settings_tab', 10, 4);
	function add_settings_tab($action_links, $plugin_file, $plugin_data, $context) {
		if (strip_tags($plugin_data['Title']) == 'Custom Smilies') {
			$tempstr0 = '<a href="' . wp_nonce_url('edit.php?page=' . $plugin_file) . '" title="' . __('Manage') . '" class="edit">' . __('Manage', 'custom_smilies') . '</a>';
			$tempstr1 = '<a href="' . wp_nonce_url('options-general.php?page=' . $plugin_file) . '" title="' . __('Options') . '" class="edit">' . __('Options', 'custom_smilies') . '</a>';
			array_unshift($action_links, $tempstr0, $tempstr1);
		}
		return $action_links;
	}
}

//$message = '<div class="error"><p>';
//$message .= '</p></div>';
//add_action('admin_notices', create_function('', "echo '$message';"));

register_activation_hook(__FILE__, 'clcs_activate');
function clcs_activate() {
	if (file_exists(CLCSINITABSPATH)) { // Upgrade from older.
		include_once(CLCSINITABSPATH);
		if (isset($wpsmiliestrans) && is_array($wpsmiliestrans) && get_option('clcs_smilies') === false) {
			add_option('clcs_smilies', $wpsmiliestrans);
		} else {
			$array4db = array();
			update_option('clcs_smilies', $array4db);
		}
		if (is_writeable(CLCSINITABSPATH)) {
			unlink(CLCSINITABSPATH);
		}
	}
}
?>