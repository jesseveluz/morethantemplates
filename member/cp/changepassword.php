<?php
include_once 'authentication.php';

$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'index';
$pagerobotfollow = 'follow';

$passwordform = '';
if (isset($_POST['newpassword'])){
	$newpassword = $_POST['newpassword'];
	$retypedpassword = $_POST['retypedpassword'];
	if ($newpassword==$retypedpassword){
		if (strlen($newpassword)>5){
		include_once '../../inc/go_dbconnect.php';
			
			$query = "update ".$dbprefix_."members set f_password='".@mysql_real_escape_string(trim($newpassword))."' where f_email='".$memberemail."' ";
			$queryresource = @mysql_query($query, CONNECTION);
			
			$passwordform .= '<p>Your password has been successfully updated.</p>';
			$passwordform .= '<p><a href="'.MEMBER_DIR.'/cp/">Go back to member area</a></p>';
		} else {
			$passwordform .= set_changepasswordform('Oops! Please enter password to have at least 6 characters.');
		}
	} else {
		$passwordform .= set_changepasswordform('Oops! Password entries didn\'t match.');
	}
} else {
	$passwordform .= set_changepasswordform();
}

function set_changepasswordform($error=''){
	$form = '
<div class="formstyle">';
if (!empty($error)){
$form .= '<span style="color: #ff0000">'.$error.'</span>';
}
$form .= '
<form name="optinform" method="post" action="'.MEMBER_DIR.'/cp/changepassword.php">
<table border="0">
	<tr><td width="10%">New Password:</td><td><input name="newpassword" /></td></tr>
	<tr><td width="10%">Retype Password:</td><td><input name="retypedpassword" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
</table>
</form>
</div>
';
return $form;
}

$content = '
<h1>Change Password</h1>

'.$passwordform.' ';



include_once 'member_cp_template.php';
?>