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
	
	header('location: membersearch.php?word='.strtolower(trim($_POST['word2search'])));
	exit;
}	



$admincontent = '';
$message = '';
$programtitle = 'Members';

// add the calendarDateInput.js
$headinsert = addcalendarjs();

// global member search form
$searchform = searchform();


if (isset($_GET['msg'])){
	$message = urldecode($_GET['msg']);
}

$_GET['act'] = (!isset($_GET['act'])) ? 'getlist' : $_GET['act'];
$_GET['orderby'] =  (!isset($_GET['orderby'])) ? 'f_dateconfirmed' : $_GET['orderby'];
$_GET['sortorder'] = (!isset($_GET['sortorder'])) ? 'DESC' : $_GET['sortorder'];


if (isset($_POST['submitlist'])){
	$_SESSION['startdate'] = $_POST['startdate'];
	$_SESSION['endingdate'] = $_POST['endingdate'];
} else {
	if (!isset($_SESSION['startdate'])){
		$_SESSION['startdate'] = date('Y-m-d',time());
		$_SESSION['endingdate'] = date('Y-m-d',strtotime("+1 days"));
	}
}




// date range
$daterange = daterangeform();

$exportcsv = '<a href="?act=exportcsv">Export CSV</a> &nbsp; ';

	
//$exportcsv;
$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';
$admincontent .= '<div style="margin: 0px; font: normal 14px verdana; width:100%"><table width="100%"><tr><td>'.$daterange.'</td><td align="left">'.$exportcsv.'</td></tr></table></div>';




if ($_GET['act']=='exportcsv'){
	$query = querylist();
	$csvfilename = 'member_signups_from_'.$_SESSION['startdate'].'_to_'.$_SESSION['endingdate'];
	CSVExport($csvfilename,$query['csvquery']);
}


if ($_GET['act']=='getlist'){

	if (!isset($_GET['dbnavoffset'])){
		$_GET['dbnavoffset'] = 0;
		$_GET['dbnavipp'] = 10;
	}
	
	if (!isset($_SESSION['orderbythis'])){
		$_SESSION['orderbythis']='f_dateconfirmed';
		$_SESSION['sortorderby'] = 'DESC';
	}
	
	if (isset($_GET['orderby'])){
		if ($_SESSION['orderbythis']!=$_GET['orderby']) $_SESSION['orderbythis'] = $_GET['orderby'];
	}
	
	if (isset($_GET['sortorder'])){
		if ($_SESSION['sortorderby']!=$_GET['sortorder']) $_SESSION['sortorderby'] = $_GET['sortorder'];
	}
		
		
	if ($_SESSION['sortorderby']=='ASC'){
		$sortorder = 'DESC';
	} else { 
		$sortorder = 'ASC';
	}
	
	$limitoffset = $_GET['dbnavoffset'];
	$limititems = $_GET['dbnavipp'];
	
	// this is to prevent negative value on offset
	if ($_GET['dbnavoffset']<1){
		$limitoffset = 0;
	}
	
	$query = querylist($_GET['orderby'],$limitoffset,$limititems);	
	
	// GET TOTAL COUNT OF MATCHES
	$result = @mysql_query($query['countquery'],CONNECTION) ;
	$rowcount =  @mysql_num_rows($result);
	@mysql_free_result($result);
	
	if (!$rowcount){
		$message .= '<font color="red">No available data.</font>';
	}
	
	$queryresource = @mysql_query($query['query'], CONNECTION);
	
	$nav = setdbnavigator('dbnav',$rowcount,'');
	
	// NOW ONTO CREATING A TABLE
	$table = starttablecreator();
	// header part
	$rowdata['col1'] = '<a href="?act='.$_GET['act'].'&orderby=f_ID&sortorder='.$sortorder.'">ID</a>';
	$rowdata['col2'] = '<a href="?act='.$_GET['act'].'&orderby=f_firstname&sortorder='.$sortorder.'">Firstname</a>';
	$rowdata['col3'] = '<a href="?act='.$_GET['act'].'&orderby=f_lastname&sortorder='.$sortorder.'">Lastname</a>';
	$rowdata['col4'] = '<a href="?act='.$_GET['act'].'&orderby=f_email&sortorder='.$sortorder.'">Email</a>';
	$rowdata['col5'] = '<a href="?act='.$_GET['act'].'&orderby=f_dateconfirmed&sortorder='.$sortorder.'">Confirmed</a>';
	$rowdata['col6'] = '<a href="?act='.$_GET['act'].'&orderby=f_password&sortorder='.$sortorder.'">Password</a>';
	$rowdata['col7'] = '<a href="?act='.$_GET['act'].'&orderby=f_country&sortorder='.$sortorder.'">Country</a>';
	$rowdata['col8'] = '<a href="?act='.$_GET['act'].'&orderby=f_status&sortorder='.$sortorder.'">Status</a>';
	$rowdata['col9'] = 'Action';
	$table = settabheader($table,$rowdata);
	

	// data part
	$table = setstarttablebody($table);
	while ($item=@mysql_fetch_assoc($queryresource)){
		$rowdata['col1'] = ucwords($item['f_ID']);
		$rowdata['col2'] = ucwords($item['f_firstname']);
		$rowdata['col3'] = ucwords($item['f_lastname']);
		$rowdata['col4'] = $item['f_email'];
		$rowdata['col5'] = $item['f_dateconfirmed'];
		$rowdata['col6'] = $item['f_password'];
		$rowdata['col7'] = $item['f_country'];
		$rowdata['col8'] = $item['f_status'];
		$rowdata['col9'] = '<a href="memberdetails.php?fid='.$item['f_ID'].'">Details</a> | <a href="removemember.php?fid='.$item['f_ID'].'">Remove</a>';
		$table = settabrow($table,$rowdata);
	}
	
	$table = setendtablebody($table);
	$admincontent .= endTableCreator($table);
	
	// display navigator
	$admincontent .= dbnavigator($nav,"dbnavigator","navstatus","listperitem");
	$admincontent .= $message;
	$admincontent .= '<br /><br />';
}




function querylist($orderby='',$offset=0,$items=10){
	global $dbprefix_;
	if (empty($orderby)){
		$order = ' limit '.$offset.','.$items;
	} else {
		$order = ' order by '.$orderby.' '.$_GET['sortorder'].' limit '.$offset.','.$items;
	}
	
	$query = 'SELECT  f_ID,f_firstname,f_lastname,f_email,f_password,date_format( f_dateconfirmed, "%M %e, %Y" ) AS f_dateconfirmed,f_country,f_status from '.$dbprefix_.'members
WHERE f_dateconfirmed between \''.$_SESSION['startdate'].' 00:00:00\' AND \''.$_SESSION['endingdate'].' 23:59:59\' 
AND f_confirmed = \'Y\' '.$order;


	
	$csvquery = 'SELECT  f_ID,f_email,f_firstname,f_lastname,f_password,f_parent,f_dateconfirmed,f_datesignedup,confirmed,f_ip,f_country,f_status from '.$dbprefix_.'members
WHERE f_dateconfirmed between \''.$_SESSION['startdate'].' 00:00:00\' AND \''.$_SESSION['endingdate'].' 23:59:59\' 
AND f_confirmed = \'Y\' ';
	
	$countquery = 'SELECT  f_email from '.$dbprefix_.'members WHERE f_dateconfirmed between \''.$_SESSION['startdate'].' 00:00:00\' AND \''.$_SESSION['endingdate'].' 23:59:59\' AND f_confirmed = \'Y\' ';
	
	$resquery = array();
	$resquery['query'] = $query;
	$resquery['countquery'] = $countquery;
	$resquery['csvquery'] = $csvquery;
	return $resquery;
}





include_once 'admin_cp_template.php';
?>