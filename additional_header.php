<?php
include_once 'menu/dropmenu.php';
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php print $program_url; ?>/slideshow/fadeslideshow.js">
/***********************************************
* Ultimate Fade In Slideshow v2.0- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/
</script>
<link type="text/css" media="screen" rel="stylesheet" href="<?php print $program_url; ?>/colorbox/colorbox.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php print $program_url; ?>/colorbox/jquery.colorbox.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".colorbox1").colorbox();
		$(".colorbox2").colorbox({width:"80%", height:"80%", iframe:true});
	});
</script>

<script type="text/javascript" src="inc/gradualfader.js">
/***********************************************
* Gradual Element Fader- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/
</script>

<?php 
/*
 * if using the facebook like it button with Open Graph
 */
if (USE_FB_OPEN_GRAPH){
?>
<!-- Start Facebook Open Graph -->
<meta property="og:title" content="<?php print $ogtitle; ?>"/> 
<meta property="og:type" content="<?php print $ogtype; ?>"/> 
<meta property="og:image" content="<?php print $ogimage; ?>"/> 
<meta property="og:url" content="<?php print $ogurl; ?>"/> 
<meta property="og:site_name" content="<?php print $ogsitename; ?>"/> 
<meta property="fb:admins" content="<?php print $ogadmins; ?>"/> 
<!-- End Facebook Open Graph -->
<?php
}
?>


<?php
// security test
// DO NOT MODIFY THIS OR YOU WILL REGRET IT LATER
if (file_exists('install/index.php')){
	die('<strong style="color:#cc0000;">VERY IMPORTANT</strong> - please remove [install] directory in your server for your site\'s protection.<br /><br />If you are installing the template for the first time, please read howtoinstall.txt');	
} else {
	if ($administrator[0]['name']=='superadminname' || $administrator[0]['password'] == 'superadminpassword' || $administrator[1]['name']=='adminname' || $administrator[1]['password'] == 'adminnamepassword' || $administrator[2]['name']=='staffname' || $administrator[2]['password'] == 'staffnamepassword'){
		die('<strong style="color:#cc0000;">SECURITY WARNING</strong> - You didn\'t change the users and passwords for your admin control panel area.  Please see the general_settings.php file to fix this. ');	
	} else {
		// proceed
	}
}
?>