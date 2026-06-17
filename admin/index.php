<?php
session_start();
$current_step = 'loginpage';
$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';

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
<form method="post" action="'.ADMIN_DIR.'/index.php" accept-charset="'.$charset_.'">
<table border="0">
	<tr><td>Username:</td><td><input name="username" style="width: 200px;" /></td></tr>
	<tr><td>Password:</td><td><input type="password" name="password" style="width: 200px;" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
</table>
</form>
</div>
';
print $form;
}

if (isset($_POST['username'])){

	$found = 0;
	$administrator_count = count($administrator);
	for ($i=0; $i<$administrator_count; $i++){
		if ($administrator[$i]['name'] == $_POST['username']) {
			if ($administrator[$i]['password']==$_POST['password']){
				$found++;
				$adminname = $administrator[$i]['name'];
				$admintype = $administrator[$i]['type'];
			}
		}
	}
	

	
	if ($found){
		// set the memberarea cookie
		setcookie(md5("adminname".__SECRET_WORD__),encryptstr($adminname,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
		setcookie(md5("admintype".__SECRET_WORD__),encryptstr($admintype,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
		
		header("location: ".ADMIN_DIR."/cp/");
		exit;
	} else {
		$errormsg = '<p style="color: #cc0000;">Oops! Unrecognized login.  Please try again.</p>';
		$_SESSION['attempt']++;
		if ($_SESSION['attempt'] >= 4){
			header('location: '.$program_url);
			exit;
		}
	}
	
} else {
	$_SESSION['attempt']=0;
	// do nothing
	if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)])){
		header("location: ".ADMIN_DIR."/cp/");
		exit;
	}
}


?>
<?php include_once 'admin_page_template.php'; ?>