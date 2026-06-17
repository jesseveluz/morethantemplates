<?php
session_start();
$current_step = 'loginpage';

include_once '../inc/general_settings.php';
include_once '../inc/functions.php';

$errormsg='';
function set_loginform($error=''){
	global $charset_;
	$form = '
<div align="center" class="formstyle">';

if (isset($_GET['expired'])){
	$form .= '<p style="color: #cc0000;">Oops! Your session has expired.  Please login again.</p>';
}

if (!empty($error)){
	$form .= '<p>'.$error.'</p>';
}

$form .= '
<form name="loginform" method="post" action="'.MEMBER_DIR.'/login.php" accept-charset="'.$charset_.'">
<table border="0">
	<tr><td>Email:</td><td><input name="email" style="width: 200px;" /></td></tr>
	<tr><td>Password:</td><td><input type="password" name="password" style="width: 200px;" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
</table>
</form>
</div>
';
print $form;
}

if (isset($_POST['email'])){
	
	include_once '../inc/go_dbconnect.php';
	
	$query = "select * from ".$dbprefix_."members where f_password='".mysql_real_escape_string(trim($_POST['password']))."'  and f_email='".mysql_real_escape_string(trim($_POST['email']))."'  ";
	$queryresource = @mysql_query($query, CONNECTION);
	$item = @mysql_fetch_assoc($queryresource);

	if (@mysql_num_rows($queryresource)) {
		
		if ($item['f_confirmed']=="N"){
			// member is not confirmed yet
			$errormsg = '<p style="color: #cc0000;">Please confirmed your subscription first.  We sent you the confirmation link in your email.  Please check your email.</p>';
		} else {		
			// set the memberarea cookie
			setcookie(md5("memberid".__SECRET_WORD__),encryptstr($item['f_ID'],__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
			setcookie(md5("membername".__SECRET_WORD__),encryptstr($item['f_firstname'],__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
			setcookie(md5("memberemail".__SECRET_WORD__),encryptstr($item['f_email'],__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
			setcookie(md5("memberparent".__SECRET_WORD__),encryptstr($item['f_parent'],__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
			
			header("location: ".MEMBER_DIR."/cp/");
			exit;
		}
	} else {
		$errormsg = '<p style="color: #cc0000;">Oops! Unrecognized login.  Please try again.</p>';
		$_SESSION['attempt']++;

		if ($_SESSION['attempt'] >= 4){
			header('location: '.MEMBER_DIR.'/accessdenied.php');
			exit;
		}
	}
	
} else {
	$_SESSION['attempt'] = 0;
	// do nothing
	if (isset($_COOKIE[md5("membername".__SECRET_WORD__)])){
		header("location: ".MEMBER_DIR."/cp/");
		exit;
	}
}

$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';
?>
<?php include_once 'page_template.php'; ?>