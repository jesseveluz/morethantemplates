<?php
include_once '../../inc/general_settings.php';
include_once 'authentication.php';
?>

<?php
$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';


// content
function get_html_content() {
	global $Firstname,$homepagelink,$logoutlink,$changepasswordlink,$parentid,$memberemail,$memberid;
	ob_start(); 
?>
<?php //-------------------------------------------[ START CONTENT HERE ]------------------------------------- ?>
<?php //----[ DON'T EDIT ANYTHING ABOVE THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>


		<p><strong>Welcome <?php print $Firstname; ?>,</strong></p>
		
		<?php if (!empty($parentid)){ ?>
		<p>Your Parent ID: <?php print $parentid; ?></p>
		<?php } ?>

		<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

		<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>


<?php //-------------------------------------------[  END CONTENT HERE ]------------------------------------- ?>
<?php //-------[ DON'T EDIT ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

$content = get_html_content();

include_once 'member_cp_template.php'; 
?>