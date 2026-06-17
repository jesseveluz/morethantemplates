<?php
include_once '../../inc/general_settings.php';
include_once '../../inc/functions.php';
include_once '../../inc/authenticateadmin.php';

if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)])){
	// logout link
	$logoutlink = ADMIN_DIR.'/logout.php';
	$homepagelink = ADMIN_DIR.'/cp/';
	$gobacklink = 'javascript:history.back()';
}
 else {
	header('location: '.ADMIN_DIR.'/index.php?expired=1');
	exit; 
} 