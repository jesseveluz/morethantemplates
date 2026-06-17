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
	
	header('location: trafficstatsearch.php?word='.strtolower(trim($_POST['word2search'])));
	exit;
}	



$admincontent = '';
$message = '';
$programtitle = 'Site Traffic';

// add the calendarDateInput.js
$headinsert = addcalendarjs();

// global member search form
$searchform = trafficstatsearchform();


if (isset($_GET['msg'])){
	$message = urldecode($_GET['msg']);
}

$_GET['act'] = (!isset($_GET['act'])) ? 'getlist' : $_GET['act'];
$_GET['orderby'] =  (!isset($_GET['orderby'])) ? 'f_date' : $_GET['orderby'];
$_GET['sortorder'] = (!isset($_GET['sortorder'])) ? 'DESC' : $_GET['sortorder'];


if (isset($_POST['submitlist'])){
	$_SESSION['startdate'] = $_POST['startdate'];
	$_SESSION['endingdate'] = $_POST['endingdate'];
} else {
	if (!isset($_SESSION['startdate'])){
		$_SESSION['startdate'] = '2010-01-01'; //date('Y-m-d',time());
		$_SESSION['endingdate'] = date('Y-m-d',time());
	}
}




// date range
$daterange = daterangeform();

$exportcsv = '<a href="?act=exportcsv">Export CSV</a> &nbsp; ';

	
//$exportcsv;
$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';
$admincontent .= '<div style="margin: 0px; font: normal 14px verdana;  width:100%"><table width="100%"><tr><td>'.$daterange.'</td><td align="left">'.$exportcsv.'</td></tr></table></div>';




if ($_GET['act']=='exportcsv'){
	$query = querylist();
	$csvfilename = 'sitetraffic_from_'.$_SESSION['startdate'].'_to_'.$_SESSION['endingdate'];
	CSVExport($csvfilename,$query['csvquery']);
}


if ($_GET['act']=='getlist'){

	if (!isset($_GET['dbnavoffset'])){
		$_GET['dbnavoffset'] = 0;
		$_GET['dbnavipp'] = 10;
	}
	
	if (!isset($_SESSION['orderbythis'])){
		$_SESSION['orderbythis']='f_date';
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
		$message .= '<font color="red">No available data</font>';
	}
	
	$queryresource = @mysql_query($query['query'], CONNECTION);
	
	$nav = setdbnavigator('dbnav',$rowcount,'');
	
	// NOW ONTO CREATING A TABLE
	$table = starttablecreator();
	// header part
	$rowdata['col1'] = '<a href="?act='.$_GET['act'].'&orderby=f_date&sortorder='.$sortorder.'">Date</a>';
	$rowdata['col2'] = '<a href="?act='.$_GET['act'].'&orderby=f_referrer&sortorder='.$sortorder.'">Referrer</a>';
	$rowdata['col3'] = '<a href="?act='.$_GET['act'].'&orderby=f_page&sortorder='.$sortorder.'">Page</a>';
	$rowdata['col4'] = '<a href="?act='.$_GET['act'].'&orderby=f_ip&sortorder='.$sortorder.'">Visitors IP</a>';
	$table = settabheader($table,$rowdata);
	

	// data part
	$table = setstarttablebody($table);
	while ($item=@mysql_fetch_assoc($queryresource)){
		$rowdata['col1'] = ucwords($item['f_date']);
		$rowdata['col2'] = ucwords($item['f_referrer']);
		$rowdata['col3'] = $item['f_page'];
		$rowdata['col4'] = $item['f_ip'];
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
	
	$query = 'SELECT  date_format( f_date, "%M %e, %Y" ) AS f_date,f_referrer,f_ip,f_page from '.$dbprefix_.'trafficstat
WHERE f_date between \''.$_SESSION['startdate'].' 00:00:00\' AND \''.$_SESSION['endingdate'].' 23:59:59\' and f_external !=1 and f_referrer like \'%'.$_GET['word'].'%\'   
'.$order;


	
	$csvquery = 'SELECT  date_format( f_date, "%M %e, %Y" ) AS f_date,f_referrer,f_ip,f_page from '.$dbprefix_.'trafficstat
WHERE f_date between \''.$_SESSION['startdate'].' 00:00:00\' AND \''.$_SESSION['endingdate'].' 23:59:59\' and f_external !=1  and f_referrer like \'%'.$_GET['word'].'%\' 
';
	
	$countquery = 'SELECT  f_date from '.$dbprefix_.'trafficstat
WHERE f_date between \''.$_SESSION['startdate'].' 00:00:00\' AND \''.$_SESSION['endingdate'].' 23:59:59\' and f_external !=1  and f_referrer like \'%'.$_GET['word'].'%\' 
';
	
	$resquery = array();
	$resquery['query'] = $query;
	$resquery['countquery'] = $countquery;
	$resquery['csvquery'] = $csvquery;
	return $resquery;
}





include_once 'admin_cp_template.php';
?>