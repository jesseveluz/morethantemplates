<?php
/*
 *	MORETHANTEMPLATE Version 1.0.0.0
 * (c) Jesse Veluz, 2010
 * http://webmarketing411.com
 *
 */
session_start();
include_once 'general_settings.php';
include_once 'functions.php';

if (isset($_POST['submit'])){
	include_once "securimage/securimage.php";
	$img = new Securimage();
	$code_isvalid = $img->check($_POST['code']);
	
	$errormessage = '';
	
	// process new submission
	$email_isvalid = false;
	$fullname_isvalid = false;
	$message_isvalid = false;
	
	// check for empty field
	$email_isvalid = check_email(trim($_POST['email']));
	$fullname_isvalid = check_name($_POST['fullname']);
	if (strlen($_POST['message']) > 50){
		$message_isvalid = true;
	}

	if ($email_isvalid && $fullname_isvalid && $message_isvalid && $code_isvalid){
		// don't interrupt just proceed
	} else {
		$errormessage= '<ul>';
		if (!$fullname_isvalid){
			$errormessage .= '<li>Fullname contains invalid character</li>';
		}
		if (!$email_isvalid){
			$errormessage .= '<li>Invalid email</li>';
		}
		if (!$message_isvalid){
			$errormessage .= '<li>You don\'t have enough message to send</li>';
		}
		if (!$code_isvalid){
			$errormessage .= '<li>Incorrect validation code</li>';
		}
		$errormessage .= '</ul>';
	}
	
	// do checking
	if (!empty($errormessage)){
		// reload the form
	} else {
		// send the message now
		$subject = 'Inquiry from '.$_POST['fullname'].'';
		$message = $_POST['message'];
		$headers = 'From: '.$contact_form_fromheader.' <'.trim($_POST['email']).'>'. "\r\n";
		
		$safetogo = false;
		if (isInjected($contact_form_fromheader)){
		} else {
			if (isInjected($_POST['email'])){
			} else {
				if ( preg_match( "/[\r\n]/", $_POST['fullname'] ) || preg_match( "/[\r\n]/", $_POST['email'] ) ) {
				} else {
					$safetogo = true;
				}
			}
		}
		
		if ($safetogo){
			if (mail($contact_form_fromemail, $subject, $message, $headers)){
				mail($_POST['email'], $subject_for_inquirer, $message_for_inquirer, 'From: '.$contact_form_fromheader.' <'.trim($contact_form_fromemail).'>' . "\r\n");  // send an initial response to the inquirer
				header("location: ".$program_url."/messagesent.php");
				exit;
			} else {
				header("location: ".$program_url."/emailproblem.php");
				exit;
			}
		}
	}
	
} else {
	// do nothing just display the contact form
}

$html_output = get_html_content($errormessage);


function get_html_content($errormessage='') {
	global $charset_;
	ob_start(); 
?>
<?php //-------------------------------------------[ START CONTENT HERE ]------------------------------------- ?>
		<?php
		if (!empty($errormessage)){
		?>
		
		<div style="background: #ffffcc; padding: 10px; border: 1px solid #ccc; color: #cc0000; margin-bottom: 20px;"><?php print $errormessage; ?></div>
		<?php
		}
		?>
		<form method="post" accept-charset="<?PHP PRINT $charset_; ?>">
			<table width="100%">
				<tr ><td width="100">Full Name:</td><td><input name="fullname" value="<?php print $_POST['fullname']; ?>" /></td></tr>
				<tr><td>Email:</td><td><input name="email" value="<?php print $_POST['email']; ?>" /></td></tr>
				<tr valign="top"><td>Message:</td><td><textarea name="message" style="width:100%;" rows="10"><?php print stripslashes($_POST['message']); ?></textarea></td></tr>
				<tr valign="bottom"><td>Enter code:</td><td><img src="securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>"><br /><input name="code" /></td></tr>
				<tr><td></td><td><input type="submit" name="submit" value="submit" /></td></tr>
			</table>
		</form>

<?php //-------------------------------------------[  END CONTENT HERE ]------------------------------------- ?>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/*
 * courtesy of http://phpsense.com/php/php-mail.html
 */
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

?>