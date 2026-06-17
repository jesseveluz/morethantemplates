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

$programtitle = 'Forum Manager > Add Section';

// global member search form
$searchform = forumsearchform();

$errormessage = '<div class="errorbox"><p>Oops! please check the following:</p><ul>';
$witherror = false;
if (isset($_POST['submit'])){
	if ($_POST['submit']=='Create'){
		
		// check for empty fields
		if (empty($_POST['moderatorID']) || empty($_POST['sectionname']) || empty($_POST['description'])){
			$witherror = true;
			$errormessage .= '<li>All fields are required</li>';
		} else {
			// ok to proceed
		}
		
		// check if moderatorID exists
		$query = "select f_ID from ".$dbprefix_."members where f_ID='".$_POST['moderatorID']."' ";
		$queryresource = @mysql_query($query, CONNECTION);
		if (@mysql_num_rows($queryresource)){
		} else {
			$witherror = true;
			$errormessage .= '<li>ModeratorID does not exists</li>';
		}
		unset($queryresource);
		
		// check if description is within 255 characters
		if (strlen($_POST['description'])>255){
			$witherror = true;
			$errormessage .= '<li>Description should be 255 characters only</li>';
		} else {
			// description is OK
		}
		
		
		// done all checking
		$errormessage .= '</ul></div>';
		
		if ($witherror){
			$admincontent = addsectionform($errormessage);
		} else {
			$query = "insert into ".$dbprefix_."forumsections values('','".mysql_real_escape_string(ucwords($_POST['sectionname']))."','".mysql_real_escape_string($_POST['description'])."','','".mysql_real_escape_string($_POST['moderatorID'])."','".mysql_real_escape_string($_POST['status'])."') ";
			$queryresource = @mysql_query($query, CONNECTION);

			if ($queryresource){
				$pagemessage = '<div class="successbox">Section created successfully</div>';
			} else {
				$pagemessage = '<div class="errorbox">Oops! there was error creating section.  Please notify the webmaster.</div>';
			}
			$admincontent = addsectionform($pagemessage);
		}
		
	} else	if ($_POST['submit']=='Go Back To Forum Manager'){
		header('location: forumsections.php');
		exit;
	} 
} else {
	$admincontent = addsectionform();
}


function addsectionform($pagemessage=''){
	global $searchform,$programtitle;
	$htmloutput = '';

	$htmloutput .= '<table width="100%" bgcolor="#f2f2f2" border="0"><tr><td align="left"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right">'.$searchform.'</td></tr></table>';
	$htmloutput .= '<br /><br />';
	$htmloutput .= $pagemessage;
	$htmloutput .= '<form method="post">';
	$htmloutput .= '<table width="100%">';
	$htmloutput .= '<tr valign="top"><td width="15%">Section Name:</td><td><input size="50" name="sectionname" value="'.$_POST['sectionname'].'" /></td></tr>';
	$htmloutput .= '<tr valign="top"><td>Description:</td><td><textarea cols="50%" name="description">'.$_POST['description'].'</textarea></td></tr>';
	$htmloutput .= '<tr valign="top"><td>Moderator ID:</td><td><input name="moderatorID" value="'.$_POST['moderatorID'].'" /></td></tr>';
	$htmloutput .= '<tr valign="top"><td>Status:</td><td><select name="status"><option value="open">open</option><option value="closed" selected="selected">closed</option></select></td></tr>';
	$htmloutput .= '<tr valign="top"><td><hr /></td><td><hr /></td></tr>';
	$htmloutput .= '<tr valign="top"><td></td><td><input type="submit" name="submit" value="Go Back To Forum Manager" /> &nbsp; &nbsp; <input type="submit" name="submit" value="Create" /></td></tr>';
	$htmloutput .= '</table>';
	$htmloutput .= '</form>';
	
	return $htmloutput;
}

include_once 'admin_cp_template.php';
?>