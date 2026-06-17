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


$pagemessage = '';


// first check if there is section being searched
if (isset($_POST['word2search']) && !empty($_POST['word2search'])){
	
	header('location: forumsectionsearch.php?word='.strtolower(trim($_POST['word2search'])));
	exit;
}	

$programtitle = 'Forum Manager > Section Editing';

// global member search form
$searchform = forumsearchform();


if (isset($_POST['submit'])){
	if ($_POST['submit']=='Update'){
		$query = 'update '.$dbprefix_.'forumsections set f_sectionname=\''.$_POST['sectionname'].'\', f_description=\''.$_POST['description'].'\', f_moderatorID=\''.$_POST['moderatorid'].'\', f_status=\''.$_POST['status'].'\' where f_ID=\''.$_GET['fid'].'\' ';
$queryresource = @mysql_query($query, CONNECTION);
		if ($queryresource){
			$pagemessage = '<div style="background: #ffffcc; padding: 10px;">Section updated successfully</div>';
		} else {
			$pagemessage = '<div style="background: #ffcccc; padding: 10px;">Oops! No change</div>';
		}
	} else	if ($_POST['submit']=='Remove'){
		header('location: forumsectionremove.php?fid='.$_GET['fid'].'');
		exit;
	} else	if ($_POST['submit']=='Go Back To Forum Manager'){
		header('location: forumsections.php');
		exit;
	} else {
	}
}


$query = 'select * from '.$dbprefix_.'forumsections where f_ID=\''.$_GET['fid'].'\' ';
$queryresource = @mysql_query($query, CONNECTION);
$item = @mysql_fetch_assoc($queryresource);

$statusopen = '';
$statusclosed = '';
if ($item['f_status']=='open'){
	$statusopen = ' selected="selected"';
} else {
	$statusclosed = ' selected="selected"';
}

if (@mysql_num_rows($queryresource)){
	$admincontent = '';

	$admincontent .= '<table width="100%" bgcolor="#f2f2f2" border="0"><tr><td align="left"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right">'.$searchform.'</td></tr></table>';
	$admincontent .= '<br /><br />';
	$admincontent .= $pagemessage;
	$admincontent .= '<form method="post">';
	$admincontent .= '<table width="100%">';
	$admincontent .= '<tr valign="top"><td width="15%">Section ID:</td><td><input name="sectionid" value="'.$item['f_ID'].'" readonly="readonly" /></td></tr>';
	$admincontent .= '<tr valign="top"><td>Section Name:</td><td><input name="sectionname" value="'.$item['f_sectionname'].'" /></td></tr>';
	$admincontent .= '<tr valign="top"><td>Description:</td><td><input name="description" value="'.$item['f_description'].'" /></td></tr>';
	$admincontent .= '<tr valign="top"><td>Topics:</td><td><input name="topics" value="'.$item['f_topics'].'" readonly="readonly" /></td></tr>';
	$admincontent .= '<tr valign="top"><td>Moderator ID:</td><td><input name="moderatorid" value="'.$item['f_moderatorID'].'" /></td></tr>';
	$admincontent .= '<tr valign="top"><td>Status:</td><td><select name="status"><option value="open"'.$statusopen.'>open</option><option value="closed"'.$statusclosed.'>closed</option></select></td></tr>';
	$admincontent .= '<tr valign="top"><td><hr /></td><td><hr /></td></tr>';
	$admincontent .= '<tr valign="top"><td></td><td><input type="submit" name="submit" value="Go Back To Forum Manager" /> &nbsp; &nbsp; <input type="submit" name="submit" value="Update" /> &nbsp; &nbsp; <input type="submit" name="submit" value="Remove" /></td></tr>';
	$admincontent .= '</table>';
	$admincontent .= '</form>';
} else {
	$admincontent = '';
	$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';	
	$admincontent .= '<div style="color: #cc0000; padding: 10px; ">Section does not exist</div>';
}

/*
f_email   	 f_firstname   	 f_lastname   	 f_password   	 f_parent   	 f_dateconfirmed   	 f_datesignedup   	 confirmed   	 f_ip   	 f_club   	 f_cityortown   	 f_country   	 f_status
*/


include_once 'admin_cp_template.php';
?>