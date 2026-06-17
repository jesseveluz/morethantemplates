<?php
session_start();
header("Cache-Control: no-cache");  // Forces caches to obtain a new copy of the page from the origin server
header("Cache-Control: no-store");  // Directs caches not to store the page under any circumstance
header("Expires: " . date('D, d M Y H:i:s', 0) . ' GMT'); //Causes the proxy cache to see the page as "stale"
header("Pragma: no-cache");         // HTTP 1.0 backward compatibility

include_once 'admin_functions.php';
include_once 'csvhelper.php';
include_once '../../inc/tablecreator/tablecreator.php';
include_once '../../inc/dbnavigator/dbnavigator.php';
include_once '../../inc/general_settings.php';
include_once '../../inc/functions.php';
include_once '../../inc/go_dbconnect.php';

$pagetitle = '';
$pagedescription = '';
$pagekeywords = '';
$pagerobotindex = 'noindex';
$pagerobotfollow = 'nofollow';
$extra_meta = '';


// first check if there is someone being searched
if (isset($_POST['word2search']) && !empty($_POST['word2search'])){
	
	header('location: memberdetails.php?email='.strtolower(trim($_POST['word2search'])));
	exit;
}	

$programtitle = 'Member Details';

// global member search form
$searchform = searchform();

if (isset($_GET['email'])){
	
	$query = 'select f_ID from '.$dbprefix_.'members where f_email=\''.$_GET['email'].'\' ';
	$queryresource = @mysql_query($query, CONNECTION);
	$item = @mysql_fetch_assoc($queryresource);
	$mem_ID = $item['f_ID'];
	
	header('location: memberdetails.php?fid='.$mem_ID.'');
	exit;
} else {
	
	//$query = "update ".$dbprefix_."members set f_confirmed='Y', f_dateconfirmed=NOW() where f_ID='".trim($decrypted_email)."' ";
	if (isset($_POST['submit']) && $_POST['submit']=='Update'){
		$query = "update ".$dbprefix_."members set 
f_email='".$_POST['femail']."',
f_firstname='".$_POST['ffirstname']."',
f_lastname='".$_POST['flastname']."',
f_password='".$_POST['fpassword']."',
f_country='".$_POST['fcountry']."',
f_status='".$_POST['fstatus']."'
where f_ID='".$_GET['fid']."'
";
		$queryresource = @mysql_query($query, CONNECTION);
	}
	
	$query = 'select f_ID,f_email,f_firstname,f_lastname,f_password,f_parent,date_format( f_dateconfirmed, "%M %e, %Y" ) AS f_dateconfirmed,date_format( f_datesignedup, "%M %e, %Y" ) AS f_datesignedup,f_confirmed,f_ip,f_country,f_status from '.$dbprefix_.'members where f_ID=\''.$_GET['fid'].'\' ';
	$queryresource = @mysql_query($query, CONNECTION);
	$item = @mysql_fetch_assoc($queryresource);
	
	$qry_string = 'fid='.$_GET['fid'];
}

if (@mysql_num_rows($queryresource)){
	$admincontent = '';

	$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';

	$admincontent .= '<form method="post" action="memberdetails.php?'.$qry_string.'">';
	$admincontent .= '<table width="70%">';
	$admincontent .= '<tr><td>Member ID:</td><td><input name="fid" value="'.$item['f_ID'].'"  readonly="readonly" /></td></tr>';
	$admincontent .= '<tr><td>Firstname:</td><td><input name="ffirstname" value="'.$item['f_firstname'].'" /></td></tr>';
	$admincontent .= '<tr><td>Lastname:</td><td><input name="flastname" value="'.$item['f_lastname'].'" /></td></tr>';
	$admincontent .= '<tr><td>Email:</td><td><input name="femail" value="'.$item['f_email'].'" /></td></tr>';
	$admincontent .= '<tr><td>Password:</td><td><input name="fpassword" value="'.$item['f_password'].'" /></td></tr>';
	$admincontent .= '<tr><td>Confirmed:</td><td><input name="fdateconfirmed" value="'.$item['f_dateconfirmed'].'"  readonly="readonly" /></td></tr>';
	$admincontent .= '<tr><td>Signed up:</td><td><input name="fdatesignedup" value="'.$item['f_datesignedup'].'"  readonly="readonly" /></td></tr>';
	$admincontent .= '<tr><td>Country:</td><td><input name="fcountry" value="'.$item['f_country'].'" /></td></tr>';
	$admincontent .= '<tr><td>Status:</td><td><input name="fstatus" value="'.$item['f_status'].'" /></td></tr>';
	$admincontent .= '<tr><td>IP:</td><td><input name="fip" value="'.$item['f_ip'].'" readonly="readonly" /></td></tr>';
	$admincontent .= '<tr><td></td><td><br /></td></tr>';
	$admincontent .= '<tr><td></td><td><input type="submit" name="submit" value="Update" /></td></tr>';
	$admincontent .= '</table>';
	$admincontent .= '</form>';
} else {
	$admincontent = '';
	$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';	
	$admincontent .= '<div style="color: #cc0000; padding: 10px; ">Member does not exist</div>';
}

/*
f_email   	 f_firstname   	 f_lastname   	 f_password   	 f_parent   	 f_dateconfirmed   	 f_datesignedup   	 confirmed   	 f_ip   	 f_club   	 f_cityortown   	 f_country   	 f_status
*/


include_once 'admin_cp_template.php';
?>