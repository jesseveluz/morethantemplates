<?php
session_start();

$current_step = 'forgotpassword';
$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';


include_once '../inc/general_settings.php';
include_once '../inc/functions.php';

$errormsg='';
function set_forgotpasswordform($error=''){
	$form = '
<div class="formstyle">';

if (!empty($error)){
	$form .= '<p style="color:#ff0000">'.$error.'</p>';
}

$form .= '
<form name="forgotpasswordform" method="post" action="'.MEMBER_DIR.'/forgot.php">
<table border="0">
	<tr><td>Email:</td><td><input name="email" /></td></tr>
	<tr valign="bottom"><td>Enter code:</td><td><img src="../securimage/securimage_show.php?sid='.md5(uniqid(time())).'"><br /><input name="code" value="'.$_POST['code'].'" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
</table>
</form>
</div>
';
print $form;
}

if (isset($_POST['email'])){
	include_once "../securimage/securimage.php";
	$img = new Securimage();
	$code_isvalid = $img->check($_POST['code']);
	
	if ($code_isvalid){
	
		include_once '../inc/go_dbconnect.php';
		
		$query = "select * from ".$dbprefix_."members where f_email='".mysql_real_escape_string(trim($_POST['email']))."' ";
		$queryresource = @mysql_query($query, CONNECTION);
		$item = @mysql_fetch_assoc($queryresource);

		if (@mysql_num_rows($queryresource)) {
			
			$thepassword = $item['f_password'];
			if (empty($item['f_password'])){
				$thepassword = 'x7dqsy';
				
				$query = "update ".$dbprefix_."members set f_password='".$thepassword."' where f_email='".mysql_real_escape_string(trim($_POST['email']))."'  ";
				@mysql_query($query, CONNECTION);
			} 
			
			$email = $item['f_email'];
			$headers = 'From: '.$fromheader.' <'.$fromemail.'>' . "\r\n";
			$forgot_email = str_replace('#FIRSTNAME#',ucwords($item['f_firstname']),$forgot_email);
			$forgot_email = str_replace('#EMAIL#',$item['f_email'],$forgot_email);
			$forgot_email = str_replace('#PASSWORD#',$thepassword,$forgot_email);
			$forgot_email_subject = str_replace('#FIRSTNAME#',trim(ucwords($item['f_firstname'])),$forgot_email_subject);
		
			mail($email, $forgot_email_subject, $forgot_email, $headers);
			
			header("location: ".MEMBER_DIR."/passwordsent.php");
			exit;
			
		} else {
			$errormsg = 'Oops! Email doesn\'t exists.  Please try again.';
		}
	} else {
		$errormsg = 'Oops! code is incorrect.  Please try again.';
	}
	
} else {
	// do nothing
}


$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';

?>
<?php include_once 'page_template.php'; ?>