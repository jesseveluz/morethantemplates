<?php
include_once '../../inc/general_settings.php';
include_once 'admin_authentication.php';
?>

<?php
// content
$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';
$extra_meta = '';

function get_html_content() {
	global $Adminname,$homepagelink,$logoutlink;
	ob_start(); 
?>
<?php //-------------------------------------------[ START CONTENT HERE ]------------------------------------- ?>
<?php //----[ DON'T EDIT ANYTHING ABOVE THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>



<p>Hello <?php print $Adminname; ?>, Put your content here</p>



<?php //-------------------------------------------[  END CONTENT HERE ]------------------------------------- ?>
<?php //-------[ DON'T EDIT ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

$content = get_html_content();

include_once 'admin_cp_template.php'; ?>
