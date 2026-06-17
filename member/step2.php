<?php
session_start();
$current_step = 'step2';

include_once '../inc/general_settings.php';
include_once '../inc/functions.php';

$content = '';
if (isset($_GET['status'])){
	
	// THIS MESSAGE APPEARS WHEN SUCCESSFUL
	if ($_GET['status']=='success'){
		
		$content .= $step2_content;
		
	}
	
	
	// THIS MESSAGE APPEARS WHEN PROCESSING FAILED
	if ($_GET['status']=='failed'){
		
		$content .= '
		<div style="background: #ffffcc; border: 1px solid #ccc; margin-top: 20px; padding: 10px;">
		<span style="color: #ff0000;">Oops! Please check the following:</span>
		</div>
		
		<div style="width: 400px; margin: auto;">
			'.urldecode($_GET['msg']).' ';
		
			$content .= set_optinform();
		
		$content .= '</div>';
	}

} else {
	if (isset($_POST['email'])){
		include_once '../inc/go_dbconnect.php';
		
		include_once "../securimage/securimage.php";
		$img = new Securimage();
		$code_isvalid = $img->check($_POST['code']);
		
		
		// process new submission
		$email_isvalid = false;
		$firstname_isvalid = false;
		$lastname_isvalid = false;
		
		// check if email is empty
		$email_isvalid = check_email(trim($_POST['email']));
		$firstname_isvalid = check_name($_POST['firstname']);
		$lastname_isvalid = check_name($_POST['lastname']);
		$country_isvalid = check_name($_POST['country']);
		
		// check if email doesn't exist in the database
		$email_isnew = check_isemailnew(trim($_POST['email']));
		
		if ($email_isvalid && $firstname_isvalid && $lastname_isvalid && $email_isnew && $code_isvalid && $country_isvalid){

			// proceed to step3
			$email = trim($_POST['email']);
			$firstname = trim($_POST['firstname']);
			$lastname = trim($_POST['lastname']);
			$password = ''; // leave it blank yet.
			$dateconfirmed = '';  // leave it blank yet.
			$this_user_ip = get_client_ip();
			$country = trim($_POST['country']);
			$mstatus = 'FREE';
			$photo = '';
			
			// this is to track parentID or referrerID
			$parent = $defaultparentid;
			if (isset($_COOKIE[md5("subscrbrparentID".__SECRET_WORD__)])){
				$parent = decryptstr($_COOKIE[md5("subscrbrparentID".__SECRET_WORD__)],__SECRET_WORD__);
			} else {
				$parent = $defaultparentid;
			}
			
		
			// save data to database as unconfirmed
			$query = "insert into ".$dbprefix_."members values ('NULL','".$email."','".$firstname."','".$lastname."','".$password."','".$parent."','".$dateconfirmed."',NOW(),'N','".$this_user_ip."','".$country."','".$mstatus."','".$photo."','0','0') ";
			$queryresource = @mysql_query($query, CONNECTION);
			$insertedID = @mysql_insert_id(CONNECTION);
			
			// send an email for confirmation
				/*
				 * NOTE
				 * $encrypted_email is now referring to f_ID of members table and not to email anymore
				 */
			
			$encryptedemail = encryptstr(strval($insertedID),__SECRET_WORD__);
			$confirm_link = $program_url.'/member/step3.php?code='.urlencode($encryptedemail);
			//print $confirm_link;
			
			$headers = 'From: '.$fromheader.' <'.$fromemail.'>' . "\r\n";
			$confirm_email = str_replace('#FIRSTNAME#',ucwords($firstname),$confirm_email);
			$confirm_email = str_replace('#CONFIRM_LINK#',$confirm_link,$confirm_email);
			$confirm_email_subject = str_replace('#FIRSTNAME#',trim(ucwords($firstname)),$confirm_email_subject);
		
			if (mail($email, $confirm_email_subject, $confirm_email, $headers)){
				header("location: ".$program_url."/member/step2.php?status=success");
				exit;
			} else {
				header("location: ".$program_url."/member/emailproblem.php");
				exit;
			}
		} else {
			
			$errormsg = '<ul>';
			if (!$firstname_isvalid){
				$errormsg .= '<li>Firstname contains invalid character</li>';
			}
			if (!$lastname_isvalid){
				$errormsg .= '<li>Lastname contains invalid character</li>';
			}
			if (!$country_isvalid){
				$errormsg .= '<li>Country contains invalid character</li>';
			}
			if (!$email_isvalid){
				$errormsg .= '<li>Invalid email</li>';
			}
			if (!$email_isnew){
				$errormsg .= '<li>Email already exists</li>';
			}
			if (!$code_isvalid){
				$errormsg .= '<li>Incorrect validation code</li>';
			}
			$errormsg .= '</ul>';
			
			$msg = urlencode($errormsg);
			
			header("location: ".$program_url."/member/step2.php?status=failed&msg=".$msg."&fname=".$_POST['firstname']."&lname=".$_POST['lastname']."&email=".$_POST['email']."&country=".$_POST['country']."");
			exit;
		}
	} else {
		header("location: ".MEMBER_DIR);
		exit;
	}
}


function set_optinform(){
	global $charset_;
	return '
<div class="formstyle">
<form name="optinform" method="post" action="'.MEMBER_DIR.'/step2.php" accept-charset="'.$charset_.'">
<table width="100%" border="0">
	<tr><td width="10%">Firstname:</td><td><input name="firstname" value="'.$_GET['fname'].'" /></td></tr>
	<tr><td>Lastname:</td><td><input name="lastname" value="'.$_GET['lname'].'" /></td></tr>
	<tr><td>Email:</td><td><input name="email"  value="'.$_GET['email'].'" /></td></tr>
	<tr><td>Country</td><td><input name="country" value="'.$_GET['country'].'" /></td></tr>
	<tr valign="bottom"><td>Enter code:</td><td><img src="../securimage/securimage_show.php?sid='.md5(uniqid(time())).'"><br /><input name="code" value="'.$_POST['code'].'" /></td></tr>
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