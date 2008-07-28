<?php
/*
Plugin Name: Custom Smilies
Plugin URI: http://goto8848.net/custom-smilies
Description: Personalize your posts and comments using custom smilies. Previously named Custom Smileys. it (older than version  2.0) maintained by <a href="http://onetruebrace.com/2007/11/28/custom-smilies/">QAD</a>.
Author: Crazy Loong
Version: 2.0
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

----------------- QAD do it ---------------------
Version History:
- Version 1.0: First release. 
- Version 1.1: 
	+ Added: Automatically put a space after the smilie
	+ Added: The ability to specify which smilies to be displayed above the comment form
	+ Added: Return all smilies with cs_all_smilies()
	+ Fixed: Problems with file names 
- Version 1.2:
	+ Added: More/Less link
	+ Fixed: Blog URL changed to WordPress URL
----------------- I do it -----------------------
- Version 2.0:
	+ Fixed: Support WordPress 2.5 or greater

*/

include_once('init.php');

global $wp_version;
if (version_compare($wp_version, '2.5', '<')) {
	include('forold.php'); // For 2.3
} else {
	include('for25.php'); // For 2.5
}
?>