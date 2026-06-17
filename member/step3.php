<?php
$current_step = 'step3';

include_once '../inc/general_settings.php';
include_once '../inc/functions.php';

if (isset($_GET['code'])){
	include_once '../inc/go_dbconnect.php';
	$decoded_email = urldecode($_GET['code']);
	$decrypted_email = decryptstr($decoded_email,__SECRET_WORD__);
	
	/*
	 * NOTE
	 * $decrypted_email is now referring to f_ID of members table
	 */

	// check if this account has been confirmed already
	$query = "select * from ".$dbprefix_."members where f_ID='".trim($decrypted_email)."' ";
	$queryresource = @mysql_query($query, CONNECTION);
	$item = mysql_fetch_assoc($queryresource);
	$previouslyconfirmed = false;
	if (mysql_num_rows($queryresource)) {
		if ($item['confirmed']=='Y'){
			// do nothing;
			$date_confirmed = $item['f_dateconfirmed'];
			$previouslyconfirmed = true;
		} else {
			// update to confirm
			$query = "update ".$dbprefix_."members set f_confirmed='Y', f_dateconfirmed=NOW() where f_ID='".trim($decrypted_email)."' ";
			$queryresource = @mysql_query($query, CONNECTION);
			
			$query = "select * from ".$dbprefix_."members where f_ID='".trim($decrypted_email)."' ";
			$queryresource = @mysql_query($query, CONNECTION);
			$item = @mysql_fetch_assoc($queryresource);
			$firstname = $item['f_firstname'];
			$lastname = $item['f_lastname'];
			$parentid = $item['f_parent'];
			$femail = $item['f_email'];
				
		}
	} else {
		// the code is not correct (not valid access)
		header("location: ".MEMBER_DIR."/");
		exit;
	}
} else {
	// no code is provided (not valid access)
	header("location: ".MEMBER_DIR."/");
	exit;
}



function set_passwordcreationform(){
	global $decoded_email,$firstname,$parentid;
	echo '
<div align="center" class="formstyle">
<form name="passwordform" method="post" action="'.MEMBER_DIR.'/step4.php">
<table border="0">
	<tr><td>Password:</td><td><input name="password" style="width: 150px;" /> Minimum of 6 characters</td></tr>
	<tr><td></td><td><input type="hidden" name="code" value="'.urlencode($decoded_email).'" /><input type="hidden" name="firstname" value="'.$firstname.'" /><input type="hidden" name="parentid" value="'.$parentid.'" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
</table>
</form>
</div>
';
}

$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'noindex';
$pagerobotfollow = 'nofollow';
?>
<?php include_once 'page_template.php'; ?>