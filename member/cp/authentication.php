<?php
include_once '../../inc/general_settings.php';
include_once '../../inc/functions.php';
include_once '../../inc/authenticatemember.php';

if (isset($_COOKIE[md5("membername".__SECRET_WORD__)])){
	// logout link
	$logoutlink = MEMBER_DIR.'/logout.php';
	$homepagelink = MEMBER_DIR.'/cp/';
	$gobacklink = 'javascript:history.back()';
	$changepasswordlink = MEMBER_DIR.'/cp/changepassword.php';
}
 else {
	header('location: '.MEMBER_DIR.'/login.php?expired=1');
	exit; 
} 