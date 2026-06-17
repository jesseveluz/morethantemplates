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
	
	header('location: forumsectionsearch.php?word='.strtolower(trim($_POST['word2search'])));
	exit;
}	



$admincontent = '';
$message = '';
$programtitle = 'Forum Manager';

// add the calendarDateInput.js
$headinsert = addcalendarjs();

// global member search form
$searchform = forumsearchform();


if (isset($_GET['msg'])){
	$message = urldecode($_GET['msg']);
}

$_GET['act'] = (!isset($_GET['act'])) ? 'getlist' : $_GET['act'];
$_GET['orderby'] =  (!isset($_GET['orderby'])) ? 'f_ID' : $_GET['orderby'];
$_GET['sortorder'] = (!isset($_GET['sortorder'])) ? 'ASC' : $_GET['sortorder'];


$exportcsv = '<a href="?act=exportcsv">Export CSV</a> &nbsp; ';

	
//$exportcsv;
$admincontent .= '<table width="100%" bgcolor="#f2f2f2"><tr><td align="left" width="30%"><span style="font: bold 24px Sans;">'.$programtitle.':</span></td><td align="right"  width="70%">'.$searchform.'</td></tr></table>';
$admincontent .= '<div style="margin: 0px; font: normal 14px verdana; background-color: #FFF; width:100%"><table width="100%"><tr><td><a href="'.$program_url.'/admin/cp/forumsectionadd.php"><div class="adminsubmenu">Add Forum Section</div></a></td></tr></table></div>';




if ($_GET['act']=='exportcsv'){
	$query = querylist();
	$csvfilename = 'forumsections_data_'.date('m_d_y',time());
	CSVExport($csvfilename,$query['csvquery']);
}


if ($_GET['act']=='getlist'){

	if (!isset($_GET['dbnavoffset'])){
		$_GET['dbnavoffset'] = 0;
		$_GET['dbnavipp'] = 10;
	}
	
	if (!isset($_SESSION['orderbythis'])){
		$_SESSION['orderbythis']='f_ID';
		$_SESSION['sortorderby'] = 'ASC';
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
		$message .= '<font color="red">Not found</font>';
	}
	
	$queryresource = @mysql_query($query['query'], CONNECTION);
	
	$nav = setdbnavigator('dbnav',$rowcount,'');
	
	// NOW ONTO CREATING A TABLE
	$table = starttablecreator();
	// header part
	$rowdata['col1'] = '<a href="?act='.$_GET['act'].'&orderby=f_sectionname&sortorder='.$sortorder.'">Section Name</a>';
	$rowdata['col2'] = '<a href="?act='.$_GET['act'].'&orderby=f_description&sortorder='.$sortorder.'">Description</a>';
	$rowdata['col3'] = '<a href="?act='.$_GET['act'].'&orderby=f_moderatorID&sortorder='.$sortorder.'">Moderator</a>';
	$rowdata['col4'] = '<a href="?act='.$_GET['act'].'&orderby=f_status&sortorder='.$sortorder.'">Status</a>';
	$rowdata['col5'] = '<a href="?act='.$_GET['act'].'&orderby=f_topics&sortorder='.$sortorder.'">Topics</a>';
	$rowdata['col6'] = 'Action';
	$table = settabheader($table,$rowdata);
	

	// data part
	$table = setstarttablebody($table);
	while ($item=@mysql_fetch_assoc($queryresource)){
		$rowdata['col1'] = ucwords($item['f_sectionname']);
		$rowdata['col2'] = $item['f_description'];
		$rowdata['col3'] = $item['f_firstname'].' '.$item['f_lastname'].' (ID:'.$item['f_moderatorID'].')';
		$rowdata['col4'] = $item['f_status'];
		$rowdata['col5'] = $item['f_topics'];
		$rowdata['col6'] = '<a href="forumsectionedit.php?fid='.$item['f_ID'].'">Edit</a>';
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
	
	$query = 'SELECT  t1.f_ID,f_sectionname,f_description,f_topics,f_moderatorID,t2.f_firstname,t2.f_lastname,t1.f_status from '.$dbprefix_.'forumsections as t1 left outer join '.$dbprefix_.'members as t2 on t1.f_moderatorID=t2.f_ID where f_sectionname like \'%'.$_GET['word'].'%\' or f_description like \'%'.$_GET['word'].'%\' 
 '.$order;


	
	$csvquery = 'SELECT  f_ID,f_sectionname,f_description,f_topics,f_moderatorID,f_status from '.$dbprefix_.'forumsections as t1 left outer join '.$dbprefix_.'members as t2 on t1.f_moderatorID=t2.f_ID where f_sectionname like \'%'.$_GET['word'].'%\'  or f_description like \'%'.$_GET['word'].'%\'  ';
	
	$countquery = 'SELECT  f_ID from '.$dbprefix_.'forumsections where f_sectionname like \'%'.$_GET['word'].'%\'  or f_description like \'%'.$_GET['word'].'%\' ';
	
	$resquery = array();
	$resquery['query'] = $query;
	$resquery['countquery'] = $countquery;
	$resquery['csvquery'] = $csvquery;
	return $resquery;
}





include_once 'admin_cp_template.php';
?>