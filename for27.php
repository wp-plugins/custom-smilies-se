<?php
// enable smilies
if (!get_option('use_smilies')) {
    update_option('use_smilies', 1);
}

// add admin pages
add_action('admin_menu', 'clcs_add_pages');

function clcs_add_pages() {
	add_options_page(__('Smilies Options', 'custom_smilies'), __('Smilies', 'custom_smilies'), 8, CLCSABSFILE, 'clcs_options');
}

// add custom box
//add_action('admin_menu', 'clcs_add_custom_box');

function clcs_add_custom_box() {
	add_meta_box( 'clcsbox', __('Smilies', 'custom_smilies'), 'clcs_inner_custom_box', 'post', 'normal');
	add_meta_box( 'clcsbox', __('Smilies', 'custom_smilies'), 'clcs_inner_custom_box', 'page', 'normal');
}

// install & upgrade
//cs_activate();

// smilies options page
function clcs_options() {
	global $wpsmiliestrans;
	
	if ($_POST['update-options']) {
		$updated = false;
		if (get_option('cs_list') != $_POST['list']) {
			update_option('cs_list', $_POST['list']);
			$updated = true;
		}
		if ($updated) {
			$clcs_message = 'Preferences updated.';
		} else {
			$clcs_message = 'No changes made.';
		}
		echo '<div id="message" class="updated fade"><p><b>' . $clcs_message . '</b></p></div>';
	}
	
	// show all or show undefined?
	$su = ($_GET['su'] === '1');
	
	if ($_POST['update-smilies']) {
		// save smilies to file and refresh $wpsmiliestrans
		$wpsmiliestrans = cs_save_smilies($_POST);
		echo '<div id="message" class="updated fade"><p><strong>' . __('Your smilies have been updated.', 'custom_smilies') . '</strong></p></div>';
	}
	
	// $smilies: 1|gif, 2|gif, etc
	// $old_smilies: :D, :(, etc
	$smilies = cs_get_all_smilies();
	$old_smilies = cs_load_existing_smilies();
?>
<div class="wrap">
	<h2><?php _e('Manage Smilies', 'custom_smilies'); ?></h2>
	<p>
<?php
	echo ($su) ? '<a href="' . wp_nonce_url(CLCSOPTURL . '&su=0') . '">' . __('Display all smilies', 'custom_smilies') . '</a>' : '<a href="' . wp_nonce_url(CLCSOPTURL . '&su=1') . '">' . __('Display undefined smilies only', 'custom_smilies') . '</a>';
?>
	</p>
	<p align="right"><?php _e('Please note that your smilies cannot contain any of these characters: \' " \\', 'custom_smilies'); ?></p>
	<form id="manage-smilies-form" method="POST" action="" name="manage-smilies-form">
		<input type="hidden" name="page" value="custom-smilies.php" />
		<table class="widefat" style="text-align:center">
			<thead>
				<tr>
					<th scope="col">
						<div style="text-align: center;"><?php _e('Smilie', 'custom_smilies'); ?></div>
					</th>
					<th scope="col">
						<div style="text-align: center;"><?php _e('What to type', 'custom_smilies'); ?></div>
					</th>
					<th scope="col">
						<div style="text-align: center;"><?php _e('Smilie', 'custom_smilies'); ?></div>
					</th>
					<th scope="col">
						<div style="text-align: center;"><?php _e('What to type', 'custom_smilies'); ?></div>
					</th>
					<th scope="col">
						<div style="text-align: center;"><?php _e('Smilie', 'custom_smilies'); ?></div>
					</th>
					<th scope="col">
						<div style="text-align: center;"><?php _e('What to type', 'custom_smilies'); ?></div>
					</th>
                </tr>
    		</thead>
    		<tbody>
<?php
    if (is_array($smilies)) {
        foreach ($smilies as $smilie) {
            // 1|gif => 1.gif
            $smilie_name = str_replace('.', '|', $smilie);

            if ($su && $old_smilies[$smilie] != '') { // show undefined only
?>
                <input type="hidden" name="<?php echo $smilie_name ?>" value="<?php echo $old_smilies[$smilie] ?>" style="text-align:center" />
<?php
                continue;
            }

            // highlight even rows
            $class = ($count % 6 == 0) ? 'alternate' : '';

            // row starts
            if ($count % 3 == 0) {
?>
                <tr class="<?php echo $class ?>">
<?php
            }
?>
                    <td><img src="../wp-includes/images/smilies/<?php echo $smilie ?>" /></td>
                    <td><input type="text" name="<?php echo $smilie_name ?>" value="<?php echo $old_smilies[$smilie] ?>" style="text-align:center" /></td>
<?php
            // row ends
            if ($count % 3 == 2) {
?>
                </tr>
<?php
            }
            $count++;
        }
    }
?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="<?php _e('Update', 'custom_smilies'); ?>" name="update-smilies"/>
		</p>
	</form>
	
	<h2><?php _e('Smilies Options', 'custom_smilies'); ?></h2>
	<form id="smilies-options-form" method="POST" action="" name="smilies-options-form">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Display these smilies above the comment form by default:', 'custom_smilies'); ?></th>
				<td>
					<input type="text" value="<?php echo get_option('cs_list') ?>" name="list" style="width:95%"><br />
					<?php _e('Put your smilies here, separated by comma. Example: <b>:D, :), :wink:, :(</b>', 'custom_smilies'); ?><br />
					<?php _e('Leave this field blank if you want to display all smilies.', 'custom_smilies'); ?>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" value="<?php _e('Update Options', 'custom_smilies'); ?>" name="update-options"/>
		</p>
	</form>
</div>
<?php
}

function clcs_inner_custom_box() {
	
	?>
    <script type="text/javascript">
    function grin(tag) {
    	var myField;
    	tag = ' ' + tag + ' ';
    	if (document.getElementById('content') && document.getElementById('content').style.display != 'none' && document.getElementById('content').type == 'textarea') {
    		myField = document.getElementById('content');
            if (document.selection) {
        		myField.focus();
        		sel = document.selection.createRange();
        		sel.text = tag;
        		myField.focus();
        	}
        	else if (myField.selectionStart || myField.selectionStart == '0') {
        		var startPos = myField.selectionStart;
        		var endPos = myField.selectionEnd;
        		var cursorPos = endPos;
        		myField.value = myField.value.substring(0, startPos)
        					  + tag
        					  + myField.value.substring(endPos, myField.value.length);
        		cursorPos += tag.length;
        		myField.focus();
        		myField.selectionStart = cursorPos;
        		myField.selectionEnd = cursorPos;
        	}
        	else {
        		myField.value += tag;
        		myField.focus();
        	}
    	} else {
            tinyMCE.execCommand('mceInsertContent', false, tag);
        }
    }
    </script><?php
            $smilies = cs_load_existing_smilies();
            $url = get_bloginfo('wpurl').'/wp-includes/images/smilies';


        	foreach ($smilies as $k => $v) {
            	echo "<img src='{$url}/{$k}' alt='{$v}' onclick='grin(\"{$v}\")' class='wp-smiley-select' /> ";
        	}

}

// scan directory & get all files
function cs_get_all_smilies() {
    if ($handle = opendir('../wp-includes/images/smilies')) {
        while (false !== ($file = readdir($handle))) {
            // no . nor ..
            if ($file != '.' && $file != '..') {
                $smilies[] = $file;
            }
        }
        closedir($handle);
    }
    return $smilies;
}

// load $wpsmiliestrans
function cs_load_existing_smilies() {
    global $wpsmiliestrans;
    return array_flip($wpsmiliestrans);
}

// install & upgrade older version if needed
function cs_activate() {
    global $wpdb, $table_prefix;

    // get out of here if no smileys table exists
    $table_name = $table_prefix.'smileys';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return;
    }

    // get existing smilies from database
    $result = $wpdb->get_results("SELECT * FROM `$table_name` ORDER BY `File`");
    $ext = get_option('csm_ext');
    foreach ($result as $object) {
        $tmp[$object->File.'.'.$ext] = $object->Emot;
    }

    // write to file
    cs_save_smilies($tmp);

    // uninstall
    $wpdb->query("DROP TABLE `{$table_prefix}smileys`");
    delete_option('csm_path');
	delete_option('csm_dbx');
	delete_option('csm_ext');
	delete_option('csm_spl');
}

// save smilies to file
function cs_save_smilies($array) {
    if (!is_array($array)) {
        return;
    }

    foreach ($array as $k => $v) {
        // sanitize smilies: remove \ ' " and trim whitespaces
        $array[$k] = trim(str_replace(array('\'','\\', '"'), '', $v));
    }

    $array = array_flip($array);
    $array4db = array();

    foreach ($array as $k => $v) {
        // sanitize smilies file name
        $array[$k] = $v = str_replace('|', '.', $v);
        if (!in_array($v, array('update-smilies', 'page')) && !in_array($k, array('', 'QAD'))) {
            $array4db[$k] = $v;
        }
    }

	update_option('clcs_smilies', $array4db);

    return $array;
}

// ensure compatibility with older version
function csm_comment_form() {
    cs_print_smilies();
}

// return all smilies
function cs_all_smilies() {
	global $wpsmiliestrans;
	$url = get_bloginfo('wpurl').'/wp-includes/images/smilies';
	foreach ($wpsmiliestrans as $k => $v) {
		$smilies[$k] = "$url/$v";
	}
	return $smilies;
}

// print smilies list @ comment form
function cs_print_smilies() {
?>
    <script type="text/javascript">
    function grin(tag) {
    	var myField;
    	tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
    		myField = document.getElementById('comment');
    	} else {
    		return false;
    	}
    	if (document.selection) {
    		myField.focus();
    		sel = document.selection.createRange();
    		sel.text = tag;
    		myField.focus();
    	}
    	else if (myField.selectionStart || myField.selectionStart == '0') {
    		var startPos = myField.selectionStart;
    		var endPos = myField.selectionEnd;
    		var cursorPos = endPos;
    		myField.value = myField.value.substring(0, startPos)
    					  + tag
    					  + myField.value.substring(endPos, myField.value.length);
    		cursorPos += tag.length;
    		myField.focus();
    		myField.selectionStart = cursorPos;
    		myField.selectionEnd = cursorPos;
    	}
    	else {
    		myField.value += tag;
    		myField.focus();
    	}
    }
    
    function moreSmilies() {
    	document.getElementById('wp-smiley-more').style.display = 'inline';
    	document.getElementById('wp-smiley-toggle').innerHTML = '<a href="javascript:lessSmilies()">&laquo;&nbsp;less</a></span>';
    }
    
    function lessSmilies() {
    	document.getElementById('wp-smiley-more').style.display = 'none';
    	document.getElementById('wp-smiley-toggle').innerHTML = '<a href="javascript:moreSmilies()">more&nbsp;&raquo;</a>';
    }
    </script>
<?php
    $smilies = cs_load_existing_smilies();
    $url = get_bloginfo('wpurl').'/wp-includes/images/smilies';
    $list = get_option('cs_list');            

    if ($list == '') {
	    foreach ($smilies as $k => $v) {
	        echo "<img src='{$url}/{$k}' alt='{$v}' onclick='grin(\"{$v}\")' class='wp-smiley-select' /> ";
	    }
    } else {
    	$display = explode(',', $list);
    	$smilies = array_flip($smilies);
    	foreach ($display as $v) {
    		$v = trim($v);
    		echo "<img src='{$url}/{$smilies[$v]}' alt='{$v}' onclick='grin(\"{$v}\")' class='wp-smiley-select' /> ";
    		unset($smilies[$v]);    		
    	}
    	echo '<span id="wp-smiley-more" style="display:none">';
    	foreach ($smilies as $k => $v) {
    		echo "<img src='{$url}/{$v}' alt='{$k}' onclick='grin(\"{$k}\")' class='wp-smiley-select' /> ";
    	}
    	echo '</span> <span id="wp-smiley-toggle"><a href="javascript:moreSmilies()">more&nbsp;&raquo;</a></span>';
    }
}

//add_action('comment_form', 'cs_print_smilies');

function add_clcs_tinymce_plugin($plugin_array) {
	$plugin_array['clcs'] = CLCSURL . 'tinymce/plugins/custom-smilies-se/editor_plugin.js';
	return $plugin_array;
}
function register_clcs_button($buttons) {
	$buttons[] = 'separator';
	$buttons[] = 'clcs';
	return $buttons;
}
function clcs_addbuttons() {
	if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
		return;
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'add_clcs_tinymce_plugin');
		add_filter('mce_buttons', 'register_clcs_button');
	}
}
add_action('init', 'clcs_addbuttons');
?>