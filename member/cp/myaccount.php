<?php
include_once '../../inc/general_settings.php';
include_once 'authentication.php';
include_once '../../inc/go_dbconnect.php';

$pagetitle = 'My Account';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'noindex';
$pagerobotfollow = 'nofollow';

$accountform = '';
$errormessage = '';

if (isset($_POST['submit'])){
	
	if ($_POST['submit']=="Update Account") {
	
		// check email
		$email_isvalid = false;
		$email_isvalid = check_email(trim($_POST['email']));
		
		// check firstname and lastname
		$firstname_isvalid = false;
		$lastname_isvalid = false;
		$firstname_isvalid = check_name($_POST['firstname']);
		$lastname_isvalid = check_name($_POST['lastname']);
		
		// check if passwords match
		$password_isvalid = false;
		if ($_POST['password']==$_POST['cpassword']){
			$password_isvalid = true;
		}
		
		if (!$email_isvalid){ $errormessage .= '<li>Email is invalid</li>';	}
		if (!$firstname_isvalid) { $errormessage .= '<li>Invalid Firstname</li>'; }
		if (!$lastname_isvalid) { $errormessage .= '<li>Invalid Lastname</li>'; }
		if (!$password_isvalid) { $errormessage .= '<li>Passwords didn\'t match</li>'; }
		

		if ($errormessage){
			$msg = '<div class="errorbox"><ul>'.$errormessage.'</ul></div>';
			$accountform .= myaccountform($msg);
		} else {
			if (empty($_POST['password'])){
				$query = "update ".$dbprefix_."members set f_email='".$_POST['email']."', f_firstname='".$_POST['firstname']."', f_lastname='".$_POST['lastname']."', f_country='".$_POST['country']."' where f_ID='".$memberid."' ";
			} else {
				$query = "update ".$dbprefix_."members set f_email='".$_POST['email']."', f_firstname='".$_POST['firstname']."', f_lastname='".$_POST['lastname']."', f_password='".$_POST['password']."', f_country='".$_POST['country']."' where f_ID='".$memberid."' ";
			}
			$queryresource = @mysql_query($query, CONNECTION);
			if ($queryresource){
				$msg = '<div class="successbox">Profile has been successfully updated</div>';
				$accountform .= myaccountform($msg);
			} else {
				$msg = '<div class="errorbox">There was error updating database.  Please contact the webmaster.</div>';
				$accountform .= myaccountform($msg);
			}
		}
	} else if ($_POST['submit']=="Upload"){
		$msg = '';
		$message = '';
		$imagename = basename($_FILES['photo']['name']);
		$stuff = explode('.',$imagename);
		$extension = $stuff[1];
		//print_r($_FILES);
		
		// check for maximum photo profile size
		if ($_FILES['photo']['size']>$maximum_photo_profile_size){
			$msg .= '<li>Photo profile too big.  Photo should be less than 15KB</li>';
		} else {
			// filesize is OK
		}
		
		// check if legitimate image file
		if (eregi ('(gif|jpg|png)$',$_FILES['photo']['name'])) {
			// this is a valid image file
		} else {
			$msg .= '<li>File is not an image.  Please download an image file only</li';
		}
			
		if (empty($msg)){
			move_uploaded_file($_FILES['photo']['tmp_name'],"../photos/".$memberid.".".$extension);
			$query = "update ".$dbprefix_."members set f_photo='".$memberid.".".$extension."' where f_ID='".$memberid."' ";   
			$queryresource = @mysql_query($query, CONNECTION);
		} else {
			$message = '<div class="errorbox"><ul>'.$msg.'</ul></div>';
		}

			// Following code to fix line ends
		   /*if (! eregi ('(gif|jpg|png)$',$_FILES['photo']['name'])) {
			   $fi = file("../photos/".$memberid."_".$_FILES['photo']['name']);
			   $fi2 = fopen("../photos/".$memberid."_".$_FILES['photo']['name'],"w");
			   foreach ($fi as $lne) {
					   $n = rtrim ($lne);
					   fputs ($fi2,"$n\n");
				}
		   }*/
		   
		$accountform .= myaccountform($message);   
	} else {
		// do nothing
	}

	
	/*foreach($_POST as $key=>$val){
		$accountform .= $key.'=>'.$val.'<br />';
		}*/
} else {
	$accountform .= myaccountform();
}

function myaccountform($msg=''){
	global $dbprefix_,$memberid,$program_url;

	$query = "select * from ".$dbprefix_."members where f_ID='".$memberid."' ";
	$queryresource = @mysql_query($query, CONNECTION);
	$item = @mysql_fetch_assoc($queryresource);
	
	
	$form = '';
	$form .= $msg;
	$form .= '<table width="100%" border="0"><tr>';
	$form .= '<td>';
	$form .= '<form method="post"><table width="100%">
<tr><td>Email</td><td><input name="email" value="'.$item['f_email'].'" /></td></tr>
<tr><td>Firstname</td><td><input name="firstname" value="'.$item['f_firstname'].'" /></td></tr>
<tr><td>Lastname</td><td><input name="lastname" value="'.$item['f_lastname'].'" /></td></tr>
<tr><td>Date Joined</td><td><input name="datejoined" value="'.$item['f_datesignedup'].'" readonly="readonly" /></td></tr>
<tr><td>Date Confirmed</td><td><input name="dateconfirmed" value="'.$item['f_dateconfirmed'].'" readonly="readonly" /></td></tr>
<tr><td>Country</td><td><input name="country" value="'.$item['f_country'].'" /></td></tr>
<tr><td>Status</td><td><input name="status" value="'.$item['f_status'].'" readonly="readonly" /></td></tr>
<tr><td><hr /></td><td><hr /></td></tr>
<tr><td>Password</td><td><input name="password"  /></td></tr>
<tr><td>Confirm password</td><td><input name="cpassword" /></td></tr>
<tr><td><hr /></td><td><hr /></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Update Account" /></td></tr>
</table></form>';
	$form .= '</td>';
	$form .= '<td width="45%">';
	$form .= '<form method="post" enctype=multipart/form-data><table>
<tr><td><img src="'.$program_url.'/member/photos/'.$item['f_photo'].'" /></td></tr>
<tr><td>Change Photo<br /><input type="file" name="photo"  /></td></tr>
<tr><td><input type="submit" name="submit" value="Upload" /></td></tr>
</table></form>'; 
	$form .= '</td>';
	$form .= '</tr></table>';
	return $form;
}

/*
	f_ID  	int(10)  	 	
	f_email 	varchar(250) 	
	f_firstname 	varchar(100) 	
	f_lastname 	varchar(100) 
	f_password 	varchar(50) 	
	f_parent 	varchar(50) 	
	f_dateconfirmed 	datetime 	
	f_datesignedup 	datetime 	
	f_confirmed 	char(1) 
	f_ip 	varchar(20) 	
	f_country 	varchar(100) 	
	f_status 	tinyint(1) 		
	f_photo
*/

// content
function get_html_content() {
	global $Firstname,$homepagelink,$logoutlink,$changepasswordlink;
	ob_start(); 
?>
<?php //-------------------------------------------[ START CONTENT HERE ]------------------------------------- ?>
<?php //----[ DON'T EDIT ANYTHING ABOVE THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>


		<h1>My Account</h1>

		<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>


<?php //-------------------------------------------[  END CONTENT HERE ]------------------------------------- ?>
<?php //-------[ DON'T EDIT ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING]----------- ?>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}


$content = get_html_content();
$content .= $accountform;

include_once 'member_cp_template.php'; 
?>