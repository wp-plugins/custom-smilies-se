<?php
// add smilies for reply
/*
if (is_admin() && (strstr($_SERVER['PHP_SELF'], 'wp-admin/index.php') || strstr($_SERVER['PHP_SELF'], 'wp-admin/edit-comments.php'))) :

add_action('wp_print_scripts', 'clcs_add_js');
function clcs_add_js() {
	wp_enqueue_script('jquery-ui-dialog');
}
add_action('admin_head', 'clcs_add_css');
function clcs_add_css() {
	echo '<link rel="stylesheet" href="http://dev.jquery.com/view/tags/ui/latest/themes/flora/flora.all.css" type="text/css" media="screen" title="Flora (Default)">';
}
add_action('in_admin_footer', 'clcs_add_js4reply');
function clcs_add_js4reply() {
	include ('genlist_reply.php');
	$smilieslisturl = get_option('siteurl') . '/wp-content/plugins/custom-smilies-se/genlist_reply.js.php';
?>
<script type="text/javascript">
jQuery(document).ready(function (){
	jQuery('#ed_reply_toolbar').append('<input id="ed_reply_test" class="ed_button" type="button" value="smilies" onclick="smilies_list_show();" />');
	jQuery('body').append('<?php echo $clcs_smilies_list; ?>');
});
function smilies_list_show() {
	jQuery("#smilieslist").dialog();
	jQuery("#smilieslist").show();
}
function smilies_list_hide() {
	jQuery("#smilieslist").dialog("destroy");
	jQuery("#smilieslist").hide();
}
function smilies_insert(code) {
	edInsertContent(document.getElementById("replycontent"), ' ' + code + ' ');
	smilies_list_hide();
}
</script>
<?php
}

endif;
*/

// add admin pages
add_action('admin_menu', 'clcs_add_pages');

function clcs_add_pages() {
	add_options_page(__('Smilies Options', 'custom_smilies'), __('Smilies', 'custom_smilies'), 8, CLCSABSFILE, 'clcs_options_admin_page');
}

/*
// add custom box
//add_action('admin_menu', 'clcs_add_custom_box');

function clcs_add_custom_box() {
	add_meta_box( 'clcsbox', __('Smilies', 'custom_smilies'), 'clcs_inner_custom_box', 'post', 'normal');
	add_meta_box( 'clcsbox', __('Smilies', 'custom_smilies'), 'clcs_inner_custom_box', 'page', 'normal');
}
*/

function add_clcs_tinymce_plugin($plugins_array) {
	$plugins_array['clcs'] = CLCSURL . 'tinymce/plugins/custom-smilies-se/editor_plugin.js';
	return $plugins_array;
}
function add_clcs_tinymce_language($languages_array) {
	$languages_array['clcs'] = CLCSABSPATH . '/lang.php';
	return $languages_array;
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
		add_filter('mce_external_languages', 'add_clcs_tinymce_language');
		add_filter('mce_buttons', 'register_clcs_button');
	}
}
add_action('init', 'clcs_addbuttons');
?>