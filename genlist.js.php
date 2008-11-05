<?php
require_once('../../../wp-load.php');

//echo get_option('siteurl');
$imagesdirurl = get_option('siteurl') . '/wp-includes/images/smilies/';
$clcs_smilies = get_option('clcs_smilies');

$smilies_sum = count($clcs_smilies);
$smilies_counter = 0;
$smilies_col = 5;
$smilies_row = ceil($smilies_sum/5);
$smilies_space = $smilies_row * $smilies_col - $smilies_sum;
?>
var smilies_list = "\
<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">\
<?php foreach ($clcs_smilies as $k => $v) : ?>
<?php if ($smilies_count % $smilies_col == 0) { ?>
	<tr>\
<?php }?>
		<td><a href=\"javascript:SmiliesDialog.insert('<?php echo $k?>');\"><img src=\"<?php echo $imagesdirurl; ?><?php echo $v?>\" border=\"0\" alt=\"smilies\" title=\"smilies\" /></a></td>\
<?php
if ($smilies_count >= $smilies_sum - 1) {
	for ($i = 0; $i < $smilies_space; $i++) {
		echo "		<td></td>\\\n";
		$smilies_count++;
	}
}
?>
<?php if ($smilies_count % $smilies_col == $smilies_col - 1) { ?>
	</tr>\
<?php }?>
<?php $smilies_count++; ?>
<?php endforeach; ?>
</table>";

document.write(smilies_list);