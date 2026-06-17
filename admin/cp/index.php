<?php
include_once '../../inc/general_settings.php';
include_once 'admin_authentication.php';
?>

<?php
// content
$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'noindex';
$pagerobotfollow = 'nofollow';
$extra_meta = '';

// to redirect the page straight to the member list page
// uncomment if you want to make use of it.
// $extra_meta = '<META HTTP-EQUIV="Refresh" CONTENT="0; URL='.ADMIN_DIR.'/cp/members.php">';

function get_html_content() {
	global $Adminname,$homepagelink,$logoutlink;
	ob_start(); 
?>
<?php //-------------------------------------------[ START CONTENT HERE ]------------------------------------- ?>
<?php //----[ DON'T EDIT ANYTHING ABOVE THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>



<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>



<?php //-------------------------------------------[  END CONTENT HERE ]------------------------------------- ?>
<?php //-------[ DON'T EDIT ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

$admincontent = get_html_content();

include_once 'admin_cp_template.php'; ?>
