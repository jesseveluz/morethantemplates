<?php
$current_step = 'step4';

include_once '../inc/general_settings.php';
include_once '../inc/functions.php';


$password_isvalid = false;
if (isset($_POST['password'])){

	$decoded_email = urldecode($_POST['code']);
	$decrypted_email = decryptstr($decoded_email,__SECRET_WORD__);
	
	/*
	 * NOTE
	 * $decrypted_email is now referring to f_ID of members table
	 */	
	
	$password = $_POST['password'];	
	if (strlen($password)>5){
		include_once '../inc/go_dbconnect.php';
		$password_isvalid = true;
		
		$query = "update ".$dbprefix_."members set f_password='".@mysql_real_escape_string(trim($password))."' where f_ID='".$decrypted_email."' ";
		$queryresource = @mysql_query($query, CONNECTION);
		
		// set the memberarea cookie
		setcookie(md5("memberid".__SECRET_WORD__),encryptstr($decrypted_email,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
		setcookie(md5("membername".__SECRET_WORD__),encryptstr($_POST['firstname'],__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
		setcookie(md5("memberemail".__SECRET_WORD__),encryptstr($decrypted_email,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
		setcookie(md5("memberparent".__SECRET_WORD__),encryptstr($_POST['parentid'],__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
		
		$query = "select * from ".$dbprefix_."members where f_ID='".$decrypted_email."' ";
		$queryresource = @mysql_query($query, CONNECTION);
		$item = @mysql_fetch_assoc($queryresource);
		
		$email = $item['f_email'];
		$headers = 'From: '.$fromheader.' <'.$fromemail.'>' . "\r\n";
		$welcome_email = str_replace('#FIRSTNAME#',ucwords($item['f_firstname']),$welcome_email);
		$welcome_email = str_replace('#EMAIL#',$item['f_email'],$welcome_email);
		$welcome_email = str_replace('#PASSWORD#',$item['f_password'],$welcome_email);
		$welcome_email_subject = str_replace('#FIRSTNAME#',trim(ucwords($item['f_firstname'])),$welcome_email_subject);
	
		mail($email, $welcome_email_subject, $welcome_email, $headers);
		
		
		header("location: ".MEMBER_DIR."/cp/");
		exit;
	} else {
		// do nothing, let the user reenter the password
	}
} else {
	// do nothing  (access is invalid)	
	header("location: ".MEMBER_DIR."/");
	exit;
}



function set_passwordcreationform(){
	global $decoded_email;
	echo '
<div align="center" class="formstyle">
<form name="passwordform" method="post" action="'.MEMBER_DIR.'/step4.php">
<table border="0">
	<tr><td>Password:</td><td><input name="password" style="width: 150px;" /> Minimum of 6 characters</td></tr>
	<tr><td></td><td><input type="hidden" name="code" value="'.urlencode($decoded_email).'" /><input type="hidden" name="firstname" value="'.$_POST['firstname'].'" /><input type="hidden" name="parentid" value="'.$_POST['parentid'].'" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
</table>
</form>
</div>
';
}

$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';
?>
<?php include_once 'page_template.php'; ?>