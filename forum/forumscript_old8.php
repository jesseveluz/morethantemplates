<?php
/*
 *	MORETHANTEMPLATE Version 1.0.0.0
 * (c) Jesse Veluz, 2010
 * http://webmarketing411.com
 *
 */
include_once 'inc/general_settings.php';
include_once 'inc/functions.php';
include_once 'inc/tablecreator/tablecreator.php';
include_once 'inc/go_dbconnect.php';
include_once 'inc/authenticateadmin.php';
include_once 'inc/authenticatemember.php';

// initialization
$forumoutput = '';
$msg = '';


if (isset($_GET['act'])){
	if ($_GET['act']=='starttopic'){
		
		$memberid = decryptstr($_COOKIE[md5("memberid".__SECRET_WORD__)],__SECRET_WORD__);
	
		if (isset($_POST['submit'])){
			
			$post_status = 'pending';
			if ($auto_approve_post){
				$post_status = 'published';
			}
			
			if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $_POST['codechecker']==$memberid){
				$post_status = 'published';
			}
			
			if (empty($_POST['title']) && empty($_POST['content'])){
				$msg .= '<div class="errorbox">Cannot submit empty fields</div>';
				header('location: ?t='.$_GET['t'].'&pg='.$_GET['pg'].'&act=starttopic&msg='.urlencode($msg).'');
				exit;
			}
		
			$query = "insert into ".$dbprefix_."forumposts values('null','".$memberid."','".@mysql_real_escape_string($_POST['title'])."','".@mysql_real_escape_string($_POST['content'])."','0','".$_GET['t']."',NOW(),NOW(),'','','".$post_status."','no') ";
			
			if ($queryresource = @mysql_query($query, CONNECTION)){
				$msg .= '<div class="successbox">Topic submitted</div>';
				
				if ($post_status=='published'){
					$query = "select f_topics from ".$dbprefix_."forumsections where f_ID=".$_GET['t']."";
					$queryresource = @mysql_query($query, CONNECTION);
					$item = @mysql_fetch_assoc($queryresource);
					$topics = $item['f_topics'];
					$topics++;
					$query = "update ".$dbprefix_."forumsections set f_topics='".$topics."' where f_ID=".$_GET['t']." ";
					$queryresource = @mysql_query($query, CONNECTION);
				}
				$query = "select f_posts,f_topics from ".$dbprefix_."members where f_ID=".$memberid."";
				$queryresource = @mysql_query($query, CONNECTION);
				$item = @mysql_fetch_assoc($queryresource);
				$numposts = $item['f_posts'];
				$numtopics = $item['f_topics'];
				$numposts++;
				$numtopics++;
				$query = "update ".$dbprefix_."members set f_posts='".$numposts."', f_topics='".$numtopics."' where f_ID=".$memberid." ";
				$queryresource = @mysql_query($query, CONNECTION);
				header('location: ?t='.$_GET['t'].'&pg=1&msg='.urlencode($msg).'');
				exit;
			} else {
				$forumoutput .= '<div class="errorbox">Post not submitting, please contact the webmaster</div>';
			}
		} else {
			$query = "select f_sectionname,f_moderatorID from ".$dbprefix_."forumsections where f_ID='".$_GET['t']."' ";
			$queryresource = @mysql_query($query, CONNECTION);
			$item = @mysql_fetch_assoc($queryresource);
			
			$moderatorID = $item['f_moderatorID'];
			$sectionName = $item['f_sectionname'];
			
			$forumoutput .= '<div><a href="">Forum</a> &gt; <a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'">'.ucwords($sectionName).'</a><br /><br /></div>';
			
			if (isset($_GET['msg'])){
				$forumoutput .= urldecode($_GET['msg']);
				$forumoutput .= '<br />';
			}
			
			$forumoutput .= '<div><form method="post" accept-charset="'.$charset_.'">TITLE &nbsp; <input name="title" size="50" /><br /><textarea name="content" rows="5" style="width: 100%" /></textarea><br /><input type="hidden" name="codechecker" value="'.$moderatorID.'" /><input type="submit" name="submit" value="submit" /></form></div>';
		}
	
		/*
	f_postID  	int(10)  
	f_postauthorID 	int(10) 	
	f_posttitle 	varchar(250) 
	f_postcontent 	text 	
	f_postreplyto 	int(10) 
	f_postforumID 	int(10) 
	f_postdatestarted 	datetime 
	f_postlastreplied 	datetime 
	f_postreplies 	int(10) 
	f_postviews 	int(10) 
	f_poststatus 	varchar(10)
	f_poststicky
	*/
	
		
		
		
	} else if ($_GET['act']=='publish'){
		if (md5($_GET['rid'])==$_GET['cd']){
			$query = "update ".$dbprefix_."forumposts set f_poststatus='published' where f_postID='".$_GET['rid']."' ";
			$queryresource=@mysql_query($query, CONNECTION);
			$query = "update ".$dbprefix_."forumposts set f_postlastreplied=NOW() where f_postID='".$_GET['p']."' ";
			$queryresource=@mysql_query($query, CONNECTION);
			
			// get the number of replies
			$query = "select f_postreplies from ".$dbprefix_."forumposts where f_postID=".$_GET['p']."";
			$queryresource = @mysql_query($query, CONNECTION);
			$item = @mysql_fetch_assoc($queryresource);
			$replies = $item['f_postreplies'];
			$replies++;
			$query = "update ".$dbprefix_."forumposts set f_postreplies='".$replies."' where f_postID=".$_GET['p']." ";
			$queryresource=@mysql_query($query, CONNECTION);
			header('location: ?t='.$_GET['t'].'&p='.$_GET['p'].'');
			exit;
		} else {
			// do nothing
		}
	} else if ($_GET['act']=='remove') {
		if (md5($_GET['rid'])==$_GET['cd']){
			$query = "update ".$dbprefix_."forumposts set f_poststatus='deleted' where f_postID='".$_GET['rid']."' ";
			$queryresource=@mysql_query($query, CONNECTION);
			
			if ($_GET['pstat']=='published'){
				// minus the number of replies
				$query = "select f_postreplies from ".$dbprefix_."forumposts where f_postID=".$_GET['p']."";
				$queryresource = @mysql_query($query, CONNECTION);
				$item = @mysql_fetch_assoc($queryresource);
				$replies = $item['f_postreplies'];
				$replies--;
				$query = "update ".$dbprefix_."forumposts set f_postreplies='".$replies."' where f_postID=".$_GET['p']." ";
				$queryresource=@mysql_query($query, CONNECTION);
			}
			header('location: ?t='.$_GET['t'].'&p='.$_GET['p'].'');
			exit;
		} else {
			// do nothing
		}
	} else if ($_GET['act']=='publishtopic'){
		if (md5($_GET['p'])==$_GET['cd']){
			$query = "update ".$dbprefix_."forumposts set f_poststatus='published' where f_postID='".$_GET['p']."' ";
			$queryresource=@mysql_query($query, CONNECTION);
			
			// get the number of topics in forumsections
			$query = "select f_topics from ".$dbprefix_."forumsections where f_ID=".$_GET['t']."";
			$queryresource = @mysql_query($query, CONNECTION);
			$item = @mysql_fetch_assoc($queryresource);
			$topicsnum = $item['f_topics'];
			$topicsnum++;
			$query = "update ".$dbprefix_."forumsections set f_topics='".$topicsnum."' where f_ID=".$_GET['t']." ";
			$queryresource=@mysql_query($query, CONNECTION);
			header('location: ?t='.$_GET['t'].'&pg='.$_GET['pg'].'');
			exit;
		} else {
			// do nothing
		}
		
	} else if ($_GET['act']=='removetopic'){
		if (md5($_GET['p'])==$_GET['cd']){
			$query = "update ".$dbprefix_."forumposts set f_poststatus='deleted' where f_postID='".$_GET['p']."' ";
			$queryresource=@mysql_query($query, CONNECTION);
			
			if ($_GET['pstat']=='published'){
				// get the number of replies
				$query = "select f_topics from ".$dbprefix_."forumsections where f_ID=".$_GET['t']."";
				$queryresource = @mysql_query($query, CONNECTION);
				$item = @mysql_fetch_assoc($queryresource);
				$topicsnum = $item['f_topics'];
				$topicsnum--;
				$query = "update ".$dbprefix_."forumsections set f_topics='".$topicsnum."' where f_ID=".$_GET['t']." ";
				$queryresource=@mysql_query($query, CONNECTION);
			}
			header('location: ?t='.$_GET['t'].'&pg='.$_GET['pg'].'');
			exit;
		} else {
			// do nothing
		}
		
	} else {
	}
}


if (!isset($_GET['t'])){
	$query = "select * from ".$dbprefix_."forumsections";
	$queryresource = @mysql_query($query, CONNECTION);
	$forumtable = starttablecreator();
	$rowdata['col1'] = 'Sections';
	$rowdata['col2'] = 'Topics';
	$forumtable = settabheader($forumtable,$rowdata);
	$forumtable = setstarttablebody($forumtable);
	while ($item=@mysql_fetch_assoc($queryresource)){
		$rowdata['col1'] = '<h3><a href="?t='.$item['f_ID'].'&pg=1">'.$item['f_sectionname'].'</a></h3><p>'.$item['f_description'].'</p>';
		$rowdata['col2'] = '<div align="center">'.$item['f_topics'].'</div>';	
		$forumtable = settabrow($forumtable,$rowdata);
	}
	$forumtable = setendtablebody($forumtable);
	$forumoutput .= endTableCreator($forumtable);
} 



// $topics_per_page
if (isset($_GET['t']) && isset($_GET['pg']) && !isset($_GET['p']) && !isset($_GET['act'])){
		
		$memberid = decryptstr($_COOKIE[md5("memberid".__SECRET_WORD__)],__SECRET_WORD__);
		
		$query = "select f_sectionname,f_moderatorID from ".$dbprefix_."forumsections where f_ID='".$_GET['t']."' ";
		$queryresource = @mysql_query($query, CONNECTION);
		$item = @mysql_fetch_assoc($queryresource);
		
		$moderatorID = $item['f_moderatorID'];
		$sectionName = $item['f_sectionname'];
		
		$page = 2;
		if (empty($_GET['pg'])){
			// use the default page 2
		} else {
			$page = $_GET['pg'];
			$startpage = $page - 1;
			$thispage = $startpage * $topics_per_page;
		}
		
		
		$nextpg = $page + 1;
		$prevpg = $page - 1;
		
		
		if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
			$query = "select f_postID from ".$dbprefix_."forumposts where f_postforumID=".$_GET['t']." and f_postreplyto='0' ";
		} else if (isset($_COOKIE[md5("memberid".__SECRET_WORD__)])) {
			$query = "select f_postID from ".$dbprefix_."forumposts where f_postforumID=".$_GET['t']." and f_postreplyto='0' and (f_poststatus='published' or (f_postauthorID='".$memberid."' and f_poststatus!='deleted')) ";
		} else {
			$query = "select f_postID from ".$dbprefix_."forumposts where f_postforumID=".$_GET['t']." and f_postreplyto='0' and f_poststatus='published'  ";
		}
		

		$queryresource = @mysql_query($query, CONNECTION);
		$totalposts = @mysql_num_rows($queryresource);		
		$remainder = $totalposts%$topics_per_page;
		
		//print 'query=>'.$query.'<br /><br />';
		//print 'totalposts=>'.$totalposts;
		//print 'remainder=>'.$remainder;
		
		$totalpages = intval($totalposts / $topics_per_page);
		if ($remainder>0){
			$totalpages++;
		} 
		
		//print 'totalpages'.$totalpages;
		
		if ($page >= $totalpages){
			$nextpage = '';
		} else {
			$nextpage = '<a href="?t='.$_GET['t'].'&pg='.$nextpg.'">Next Page &gt;&gt;</a>';
			$lastpage = ' | <a href="?t='.$_GET['t'].'&pg='.$totalpages.'">Last Page &gt;&gt;</a>';
		}
		
		if ($prevpg == 0){
			$firstpage = '';
			$previouspage = '';
		} else {
			$firstpage = '<a href="?t='.$_GET['t'].'&pg=1">&lt;&lt; First Page</a> | ';
			$previouspage = '<a href="?t='.$_GET['t'].'&pg='.$prevpg.'">&lt;&lt; Previous Page</a>';
		}
		
		$msg = '';
		$message = '';
	
	if (isset($_GET['msg'])){
		$forumoutput .= urldecode($_GET['msg']);
	}
	
	$forumoutput .= '<div><a href="?">Forum</a> &gt; '.ucwords($sectionName).'</div>';
	
	if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
		$query = "select f_postID,f_postauthorID,f_posttitle,f_postcontent,f_postreplyto,f_postforumID,date_format(f_postdatestarted,'%M %e, %Y') as f_postdatestarted,f_postlastreplied,f_postreplies,f_postviews,f_poststatus,f_poststicky,
f_ID,	f_email,	f_firstname,	f_lastname,	f_password,	f_parent,	f_dateconfirmed,	f_datesignedup,	f_confirmed,	f_ip,	f_country,	f_status,	f_photo,	f_posts,	f_topics from ".$dbprefix_."forumposts as t1 left outer join ".$dbprefix_."members as t2 on t1.f_postauthorID=t2.f_ID where f_postforumID='".$_GET['t']."' and f_postreplyto='0' order by f_postlastreplied DESC limit ".$thispage.",".$topics_per_page." ";
	} else if (isset($_COOKIE[md5("memberid".__SECRET_WORD__)])) {
		$query = "select f_postID,f_postauthorID,f_posttitle,f_postcontent,f_postreplyto,f_postforumID,date_format(f_postdatestarted,'%M %e, %Y') as f_postdatestarted,f_postlastreplied,f_postreplies,f_postviews,f_poststatus,f_poststicky,
f_ID,	f_email,	f_firstname,	f_lastname,	f_password,	f_parent,	f_dateconfirmed,	f_datesignedup,	f_confirmed,	f_ip,	f_country,	f_status,	f_photo,	f_posts,	f_topics from ".$dbprefix_."forumposts as t1 left outer join ".$dbprefix_."members as t2 on t1.f_postauthorID=t2.f_ID where f_postforumID='".$_GET['t']."' and f_postreplyto='0' and (f_poststatus='published' or (f_postauthorID='".$memberid."'  and f_poststatus!='deleted')) order by f_postlastreplied DESC limit ".$thispage.",".$topics_per_page." ";
	} else {
		$query = "select f_postID,f_postauthorID,f_posttitle,f_postcontent,f_postreplyto,f_postforumID,date_format(f_postdatestarted,'%M %e, %Y') as f_postdatestarted,f_postlastreplied,f_postreplies,f_postviews,f_poststatus,f_poststicky,
f_ID,	f_email,	f_firstname,	f_lastname,	f_password,	f_parent,	f_dateconfirmed,	f_datesignedup,	f_confirmed,	f_ip,	f_country,	f_status,	f_photo,	f_posts,	f_topics from ".$dbprefix_."forumposts as t1 left outer join ".$dbprefix_."members as t2 on t1.f_postauthorID=t2.f_ID where f_postforumID='".$_GET['t']."' and f_postreplyto='0' and f_poststatus='published' order by f_postlastreplied DESC limit ".$thispage.",".$topics_per_page." ";
	}

	$queryresource = @mysql_query($query, CONNECTION);
	$forumtable = starttablecreator();
	$rowdata['col1'] = 'Title'; 		$widthdata['col1'] = '';
	$rowdata['col2'] = 'Started By'; $widthdata['col2'] = '15%';
	$rowdata['col3'] = 'Views'; 		$widthdata['col3'] = '5%';
	$rowdata['col4'] = 'Replies'; 	$widthdata['col4'] = '5%';
	$forumtable = settabheader($forumtable,$rowdata,"tableheader",$widthdata);
	$forumtable = setstarttablebody($forumtable);
	while ($item=@mysql_fetch_assoc($queryresource)){
		if ($item['f_poststatus']=='pending'){
			if ($item['f_postauthorID']==$memberid){
				$rowdata['col1'] = '<h3><a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'">'.cleanuptext($item['f_posttitle']).'</a></h3>';
				$rowdata['col1'] .= '<div style="padding: 10px; background: #ffffcc;"><strong>PENDING: Awaiting moderator\'s approval</strong></div>';
				$rowdata['col2'] = '<div align="left">'.$item['f_firstname'].' '.$item['f_lastname'].'<br /><span style="font-size: 8pt;">'.$item['f_postdatestarted'].'</span></div>';
				$rowdata['col3'] = '<div align="center">'.$item['f_postviews'].'</div>';	
				$rowdata['col4'] = '<div align="center">'.$item['f_postreplies'].'</div>';	
				$forumtable = settabrow($forumtable,$rowdata);
			} else {
				if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
					// show remove and publish button
					$rowdata['col1'] = '<h3><a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'">'.cleanuptext($item['f_posttitle']).'</a></h3>';
					$rowdata['col1'] .= '<div style="padding: 10px; background: #ffffcc;"><strong>PENDING:</strong> &nbsp; <a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'&act=publishtopic&cd='.md5($item['f_postID']).'">Publish</a> &nbsp; | &nbsp; <a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'&act=removetopic&pstat=pending&cd='.md5($item['f_postID']).'">Remove</a></div>';
					
					$rowdata['col2'] = '<div align="left">'.$item['f_firstname'].' '.$item['f_lastname'].'<br /><span style="font-size: 8pt;">'.$item['f_postdatestarted'].'</span></div>';
					$rowdata['col3'] = '<div align="center">'.$item['f_postviews'].'</div>';	
					$rowdata['col4'] = '<div align="center">'.$item['f_postreplies'].'</div>';	
					$forumtable = settabrow($forumtable,$rowdata);
				} else {
					// show nothing
				}
			}

		} else if ($item['f_poststatus']=='deleted'){
			
				if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
					$rowdata['col1'] = '<h3><a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'">'.cleanuptext($item['f_posttitle']).'</a></h3>';
					$rowdata['col1'] .= '<div style="padding: 10px; background: #ffffcc;"><strong>This has been removed:</strong> &nbsp; <a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'&act=publishtopic&cd='.md5($item['f_postID']).'">Republish</a> &nbsp; | &nbsp; <a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'&act=removetopic&pstat=pending&cd='.md5($item['f_postID']).'">Remove</a></div>';
					
					$rowdata['col2'] = '<div align="left">'.$item['f_firstname'].' '.$item['f_lastname'].'<br /><span style="font-size: 8pt;">'.$item['f_postdatestarted'].'</span></div>';
					$rowdata['col3'] = '<div align="center">'.$item['f_postviews'].'</div>';	
					$rowdata['col4'] = '<div align="center">'.$item['f_postreplies'].'</div>';	
					$forumtable = settabrow($forumtable,$rowdata);
				} else {
					// show nothing
				}
			
		} else {
			$rowdata['col1'] = '<h3><a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'">'.cleanuptext($item['f_posttitle']).'</a></h3>';
			
			if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
				// show remove
				$rowdata['col1'] .= '<div style="padding: 10px; background: #ffffcc;"><strong>PUBLISHED:</strong> &nbsp; <a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$item['f_postID'].'&act=removetopic&pstat=published&cd='.md5($item['f_postID']).'">Remove</a></div>';
				
				$rowdata['col2'] = '<div align="left">'.$item['f_firstname'].' '.$item['f_lastname'].'<br /><span style="font-size: 8pt;">'.$item['f_postdatestarted'].'</span></div>';
				$rowdata['col3'] = '<div align="center">'.$item['f_postviews'].'</div>';	
				$rowdata['col4'] = '<div align="center">'.$item['f_postreplies'].'</div>';	
				$forumtable = settabrow($forumtable,$rowdata);
			} else {
				$rowdata['col2'] = '<div align="left">'.$item['f_firstname'].' '.$item['f_lastname'].'<br /><span style="font-size: 8pt;">'.$item['f_postdatestarted'].'</span></div>';
				$rowdata['col3'] = '<div align="center">'.$item['f_postviews'].'</div>';	
				$rowdata['col4'] = '<div align="center">'.$item['f_postreplies'].'</div>';	
				$forumtable = settabrow($forumtable,$rowdata);
			}
		}
	}
	$forumtable = setendtablebody($forumtable);
	$forumoutput .= endTableCreator($forumtable);
	
	// page navigation
	$forumoutput .= '<table width="100%"><tr><td>'.$firstpage.$previouspage.'</td><td><div align="right">'.$nextpage.$lastpage.'</div></td></tr></table>';
	
	if ( isset($_COOKIE[md5("memberid".__SECRET_WORD__)]) ){
		$forumoutput .= '<h3><a href="?t='.$_GET['t'].'&pg='.$_GET['pg'].'&act=starttopic">Start A New Topic</a></h3>';
		//$forumoutput .= '<div><form method="post" accept-charset="'.$charset_.'">TITLE &nbsp; <input name="title" size="50" /><br /><textarea name="content" rows="5" style="width: 100%" /></textarea><br /><input type="hidden" name="codechecker" value="'.$moderatorID.'" /><input type="submit" name="submit" value="submit" /></form></div>';
	} else {
		$forumoutput .= '<h3><a href="'.$program_url.'/member/login.php">Please login to post new topic</a></h3>';
	}
}



if (isset($_GET['p'])){
	
	$msg = '';
	$message = '';
	
	if (isset($_GET['msg'])){
		$msg = '<div class="successbox">'.urldecode($_GET['msg']).'</div>';
	}
	$memberid = decryptstr($_COOKIE[md5("memberid".__SECRET_WORD__)],__SECRET_WORD__);
	
	
	if (isset($_POST['submit'])){
		$post_status = 'pending';
		if ($auto_approve_post){
			$post_status = 'published';
		}
		
		if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $_POST['codechecker']==$memberid){
			$post_status = 'published';
		}
		
		$query = "insert into ".$dbprefix_."forumposts values('null','".$memberid."','','".@mysql_real_escape_string($_POST['reply'])."','".$_GET['p']."','".$_GET['t']."',NOW(),'','','','".$post_status."','no') ";
		if ($queryresource = @mysql_query($query, CONNECTION)){
			$msg .= '<div class="successbox">Reply submitted</div>';

			if ($post_status=='published'){
				$query = "select f_postreplies from ".$dbprefix_."forumposts where f_postID=".$_GET['p']."";
				$queryresource = @mysql_query($query, CONNECTION);
				$item = @mysql_fetch_assoc($queryresource);
				$replies = $item['f_postreplies'];
				$replies++;
				$query = "update ".$dbprefix_."forumposts set f_postreplies='".$replies."', f_postlastreplied=NOW() where f_postID=".$_GET['p']." ";
			} else {
				//$query = "update ".$dbprefix_."forumposts set f_postreplies='".$replies."' where f_postID=".$_GET['p']." ";
			}
			$queryresource = @mysql_query($query, CONNECTION);
			$query = "select f_posts from ".$dbprefix_."members where f_ID=".$memberid."";
			$queryresource = @mysql_query($query, CONNECTION);
			$item = @mysql_fetch_assoc($queryresource);
			$numposts = $item['f_posts'];
			$numposts++;
			$query = "update ".$dbprefix_."members set f_posts='".$numposts."' where f_ID=".$memberid." ";
			$queryresource = @mysql_query($query, CONNECTION);
				header('location: ?t='.$_GET['t'].'&pg='.$_GET['pg'].'&p='.$_GET['p'].'&msg='.urlencode('Your reply has been submitted.').'&noupdate=1');
				exit;
		} else {
			$msg .= '<div class="errorbox">Reply not submitting, please contact the webmaster</div>';
		}
	} else {
		// update views
		if (isset($_GET['noupdate'])){
			// do nothing
		} else {
			$query = "select f_postviews from ".$dbprefix_."forumposts where f_postID=".$_GET['p']."";
			$queryresource = @mysql_query($query, CONNECTION);
			$item = @mysql_fetch_assoc($queryresource);
			$views = $item['f_postviews'];
			$views++;
			$query = "update ".$dbprefix_."forumposts set f_postviews='".$views."' where f_postID=".$_GET['p']." ";
			$queryresource = @mysql_query($query, CONNECTION);
		}
	}
	/*
	f_postID  	int(10)  
	f_postauthorID 	int(10) 	
	f_posttitle 	varchar(250) 
	f_postcontent 	text 	
	f_postreplyto 	int(10) 
	f_postforumID 	int(10) 
	f_postdatestarted 	datetime 
	f_postlastreplied 	datetime 
	f_postreplies 	int(10) 
	f_postviews 	int(10) 
	f_poststatus 	varchar(10)
	f_poststicky

	date_format( f_dateconfirmed, "%M %e, %Y" ) AS f_dateconfirmed
	*/
	
	$forumoutput .= $msg;
	$query = "select * from ".$dbprefix_."forumsections where f_ID='".$_GET['t']."' ";
	$queryresource = @mysql_query($query, CONNECTION);
	$item = @mysql_fetch_assoc($queryresource);
	$moderatorID = $item['f_moderatorID'];
	$forumoutput .= '<div><a href="?">Forum</a> &gt; <a href="?t='.$_GET['t'].'&pg=1">'.ucwords($item['f_sectionname']).'</a>';
	$query = "select f_postID,f_postauthorID,f_posttitle,f_postcontent,f_postreplyto,f_postforumID,date_format(f_postdatestarted,'%M %e, %Y') as f_postdatestarted,f_postlastreplied,f_postreplies,f_postviews,f_poststatus,f_poststicky,
f_ID,	f_email,	f_firstname,	f_lastname,	f_password,	f_parent,	f_dateconfirmed,	f_datesignedup,	f_confirmed,	f_ip,	f_country,	f_status,	f_photo,	f_posts,	f_topics from ".$dbprefix_."forumposts  as t1 left outer join ".$dbprefix_."members as t2 on t1.f_postauthorID=t2.f_ID where f_postID='".$_GET['p']."' ";
	$queryresource = @mysql_query($query, CONNECTION);
	$item = @mysql_fetch_assoc($queryresource);
	$forumoutput .= ' &gt; '.cleanuptext($item['f_posttitle']).'</div>';

	$forumtable = starttablecreator();
	$rowdata['col1'] = '&nbsp;'; 		$widthdata['col1'] = '';
	$rowdata['col2'] = '<div align="center">Member</div>'; 		$widthdata['col2'] = '20%';
	$forumtable = settabheader($forumtable,$rowdata,"tableheader",$widthdata);
	$forumtable = setstarttablebody($forumtable);
	$position = '';
	if ($item['f_postauthorID']==$moderatorID){
		$position = '<span style="font-size: 8pt; font-weight: bold">[moderator]</span><br />';
	}
	
	// the start of thread first
	$rowdata['col1'] = '<div align="right">'.$item['f_postdatestarted'].'</div><h3>'.cleanuptext($item['f_posttitle']).'</h3>'.cleanuptext($item['f_postcontent']).'';
	$rowdata['col2'] = '<div align="left">';
	
	$photoquery = "select f_photo from ".$dbprefix_."forumposts where f_ID='".$item['f_postauthorID']."' ";
	$photoqueryresource = @mysql_query($photoquery,CONNECTION);
	$authorphoto = @mysql_fetch_assoc($photoqueryresource);
	if (file_exists(getcwd().'/member/photos/'.$authorphoto)){
		$rowdata['col2'] .= '<img src="'.$program_url.'/member/photos/'.$item['f_postauthorID'].'" width="80" border="0"><br />';
	} 
	$rowdata['col2'] .= $item['f_firstname'].' '.$item['f_lastname'].'<br />'.$position.'Topic Started: '.$item['f_topics'].'<br />Total Posts: '.$item['f_posts'].'<br /><br /></div>';
	
	$forumtable = settabrow($forumtable,$rowdata);
	
	/*
	f_postID  	int(10)  
	f_postauthorID 	int(10) 	
	f_posttitle 	varchar(250) 
	f_postcontent 	text 	
	f_postreplyto 	int(10) 
	f_postforumID 	int(10) 
	f_postdatestarted 	datetime 
	f_postlastreplied 	datetime 
	f_postreplies 	int(10) 
	f_postviews 	int(10) 
	f_poststatus 	varchar(10)
	f_poststicky

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
	f_status 	varchar(100) 
	f_photo 	varchar(37) 
	f_posts 	int(10) 	
	f_topics

	date_format( f_dateconfirmed, "%M %e, %Y" ) AS f_dateconfirmed
*/
	
	$query = "select f_postID,f_postauthorID,f_posttitle,f_postcontent,f_postreplyto,f_postforumID,date_format(f_postdatestarted,'%M %e, %Y') as f_postdatestarted,f_postlastreplied,f_postreplies,f_postviews,f_poststatus,f_poststicky,
f_ID,	f_email,	f_firstname,	f_lastname,	f_password,	f_parent,	f_dateconfirmed,	f_datesignedup,	f_confirmed,	f_ip,	f_country,	f_status,	f_photo,	f_posts,	f_topics from ".$dbprefix_."forumposts  as t1 left outer join ".$dbprefix_."members as t2 on t1.f_postauthorID=t2.f_ID where f_postreplyto='".$_GET['p']."' and f_poststatus != 'removed' ";
	$queryresource = @mysql_query($query, CONNECTION);	
	while ($item=@mysql_fetch_assoc($queryresource)){
		$position = '';
		if ($item['f_postauthorID']==$moderatorID){
			$position = '<span style="font-size: 8pt; font-weight: bold">[moderator]</span><br />';
		}
		if ($item['f_poststatus']=='pending'){
			if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
				$rowdata['col1'] = '<div align="right">'.$item['f_postdatestarted'].'</div><br />'.cleanuptext($item['f_postcontent']).'<br /><br /><div style="padding: 10px; background: #ffffcc;"><strong>PENDING:</strong> &nbsp; <a href="?t='.$_GET['t'].'&p='.$_GET['p'].'&rid='.$item['f_postID'].'&act=publish&cd='.md5($item['f_postID']).'">Publish</a> &nbsp; | &nbsp; <a href="?t='.$_GET['t'].'&p='.$_GET['p'].'&rid='.$item['f_postID'].'&act=remove&pstat=pending&cd='.md5($item['f_postID']).'">Remove</a></div>';
				$rowdata['col2'] = '<div align="center"><img src="'.$program_url.'/member/photos/'.$item['f_postauthorID'].'.jpg" height="70" border="0"><br />'.$item['f_firstname'].' '.$item['f_lastname'].'<br />'.$position.'Topic Started: '.$item['f_topics'].'<br />Total Posts: '.$item['f_posts'].'<br /><br /></div>';
				$forumtable = settabrow($forumtable,$rowdata);
			} else {
				if ($item['f_postauthorID']==$memberid){
					$rowdata['col1'] = '<div align="right">'.$item['f_postdatestarted'].'</div><br />'.cleanuptext($item['f_postcontent']).'<br /><br /><div style="padding: 10px; background: #ffffcc;"><strong>PENDING: Awaiting moderator\'s approval</strong></div>';
					$rowdata['col2'] = '<div align="center"><img src="'.$program_url.'/member/photos/'.$item['f_postauthorID'].'.jpg" height="70" border="0"><br />'.$item['f_firstname'].' '.$item['f_lastname'].'<br />'.$position.'Topic Started: '.$item['f_topics'].'<br />Total Posts: '.$item['f_posts'].'<br /><br /></div>';
					$forumtable = settabrow($forumtable,$rowdata);
				} else {
					// do nothing
				}
			}
		} else if ($item['f_poststatus']=='deleted'){
			$rowdata['col1'] = '<div align="right">'.$item['f_postdatestarted'].'</div><br />'.cleanuptext($item['f_postcontent']).'';
			if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
				$rowdata['col1'] .= '<br /><br /><div style="padding: 10px; background: #ffffcc;">This post has been removed: &nbsp; <a href="?t='.$_GET['t'].'&p='.$_GET['p'].'&rid='.$item['f_postID'].'&act=publish&pstat=deleted&cd='.md5($item['f_postID']).'">Republish</a></div>';
			}
			$rowdata['col2'] = '<div align="center"><img src="'.$program_url.'/member/photos/'.$item['f_postauthorID'].'.jpg" height="70" border="0"><br />'.$item['f_firstname'].' '.$item['f_lastname'].'<br />'.$position.'Topic Started: '.$item['f_topics'].'<br />Total Posts: '.$item['f_posts'].'<br /><br /></div>';
			$forumtable = settabrow($forumtable,$rowdata);
		} else {
			$rowdata['col1'] = '<div align="right">'.$item['f_postdatestarted'].'</div><br />'.cleanuptext($item['f_postcontent']).'';
			if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)]) || $moderatorID==$memberid){
				$rowdata['col1'] .= '<br /><br /><div style="padding: 10px; background: #ffffcc;"> &nbsp; <a href="?t='.$_GET['t'].'&p='.$_GET['p'].'&rid='.$item['f_postID'].'&act=remove&pstat=published&cd='.md5($item['f_postID']).'">Remove</a></div>';
			}
			$rowdata['col2'] = '<div align="center"><img src="'.$program_url.'/member/photos/'.$item['f_postauthorID'].'.jpg" height="70" border="0"><br />'.$item['f_firstname'].' '.$item['f_lastname'].'<br />'.$position.'Topic Started: '.$item['f_topics'].'<br />Total Posts: '.$item['f_posts'].'<br /><br /></div>';
			$forumtable = settabrow($forumtable,$rowdata);
		}
		
	}
	$forumtable = setendtablebody($forumtable);
	$forumoutput .= endTableCreator($forumtable);
	
	if (isset($_COOKIE[md5("memberid".__SECRET_WORD__)])){
		$forumoutput .= '<h3>Your Reply:</h3>';
		$forumoutput .= '<div><form method="post" accept-charset="'.$charset_.'"><textarea name="reply" rows="5" style="width: 100%" /></textarea><br /><input type="submit" name="submit" value="submit" /><input type="hidden" name="codechecker" value="'.$moderatorID.'" /></form></div>';
	} else {
		$forumoutput .= '<h3><a href="'.$program_url.'/member/login.php">Please login to reply</a></h3>';
	}
	$forumoutput .= '<ul><li>Use [quote][/quote] to quote a text</li><li>Use [code][/code] for code script</li></ul>';
}


function cleanuptext($text) {
	$newtext = htmlspecialchars($text);
	$newtext = str_replace('[quote]','<div class="quoted">&quot;',$newtext);
	$newtext = str_replace('[/quote]','&quot;</div>',$newtext);
	$newtext = str_replace('[code]','<div class="codetext">',$newtext);
	$newtext = str_replace('[/code]','</div>',$newtext);
	$newtext = wrap($newtext, 50, " ");
	return nl2br(stripslashes($newtext));
}

function wrap($str, $width=75, $break="\n") {
  return preg_replace('#(\S{'.$width.',})#e', "chunk_split('$1', ".$width.", '".$break."')", $str);
} 

?>