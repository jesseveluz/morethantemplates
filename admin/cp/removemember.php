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

$programtitle = 'Confirm Member Removal';

// global member search form
$searchform = searchform();

$admincontent = '';

$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';


if ($_POST['submit']){
	if ($_POST['submit']=='delete'){
		$query = 'delete from '.$dbprefix_.'members where f_ID=\''.$_GET['fid'].'\' ';
		$queryresource = @mysql_query($query, CONNECTION);
		
		$admincontent .= '<br /><br /><br />';
		$admincontent .= 'Member has been removed';
	}
} else {
		$query = 'select f_email,f_firstname,f_lastname,f_password,f_parent,date_format( f_dateconfirmed, "%M %e, %Y" ) AS f_dateconfirmed,date_format( f_datesignedup, "%M %e, %Y" ) AS f_datesignedup,f_confirmed,f_ip,f_country,f_status from '.$dbprefix_.'members where f_ID=\''.$_GET['fid'].'\' ';
		$queryresource = @mysql_query($query, CONNECTION);
		$item = @mysql_fetch_assoc($queryresource);

		if (@mysql_num_rows($queryresource)){

			$admincontent .= '<table width="70%">';
			$admincontent .= '<tr><td>Firstname:</td><td>'.$item['f_firstname'].'</td></tr>';
			$admincontent .= '<tr><td>Lastname:</td><td>'.$item['f_lastname'].'</td></tr>';
			$admincontent .= '<tr><td>Email:</td><td>'.$item['f_email'].'</td></tr>';
			$admincontent .= '<tr><td>Password:</td><td>'.$item['f_password'].'</td></tr>';
			$admincontent .= '<tr><td>Confirmed:</td><td>'.$item['f_dateconfirmed'].'</td></tr>';
			$admincontent .= '<tr><td>Signed up:</td><td>'.$item['f_datesignedup'].'</td></tr>';
			$admincontent .= '<tr><td>Country:</td><td>'.$item['f_country'].'</td></tr>';
			$mstatus = 'free';
			if ($item['f_status']=='1'){
				$mstatus = 'premium';
			}
			$admincontent .= '<tr><td>Status:</td><td>'.$mstatus.'</td></tr>';
			$admincontent .= '<tr><td>IP:</td><td>'.$item['f_ip'].'</td></tr>';
			$admincontent .= '</table>';

			$admincontent .= '<br /><br />';
			$admincontent .= '<form method="post" action="removemember.php?fid='.$_GET['fid'].'">';
			$admincontent .= '<input type="submit" name="submit" value="delete" />';
			$admincontent .= '</form>';
		} else {
			$admincontent = '';
			$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';	
			$admincontent .= '<div style="color: #cc0000; padding: 10px; ">Member does not exist</div>';
		}
}

/*
f_email   	 f_firstname   	 f_lastname   	 f_password   	 f_parent   	 f_dateconfirmed   	 f_datesignedup   	 confirmed   	 f_ip   	 f_club   	 f_cityortown   	 f_country   	 f_status
*/


include_once 'admin_cp_template.php';
?>