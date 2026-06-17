<?php
include_once '../inc/general_settings.php';
include_once '../inc/go_dbconnect.php';


$query_members = "CREATE TABLE IF NOT EXISTS `".$dbprefix_."members` (
  `f_ID` int(10) unsigned NOT NULL auto_increment,
  `f_email` varchar(250) NOT NULL,
  `f_firstname` varchar(100) NOT NULL,
  `f_lastname` varchar(100) NOT NULL,
  `f_password` varchar(50) NOT NULL,
  `f_parent` varchar(50) NOT NULL,
  `f_dateconfirmed` datetime NOT NULL,
  `f_datesignedup` datetime NOT NULL,
  `f_confirmed` char(1) NOT NULL,
  `f_ip` varchar(20) NOT NULL,
  `f_country` varchar(100) NOT NULL,
  `f_status` varchar(100) NOT NULL,
  `f_photo` varchar(37) NOT NULL,
  `f_posts` int(10) unsigned NOT NULL,
  `f_topics` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`f_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";




$query_trafficstat = "CREATE TABLE IF NOT EXISTS `".$dbprefix_."trafficstat` (
  `f_date` datetime NOT NULL,
  `f_referrer` text CHARACTER SET utf8 NOT NULL,
  `f_ip` varchar(100) CHARACTER SET utf8 NOT NULL,
  `f_page` varchar(250) CHARACTER SET utf8 NOT NULL,
  `f_external` tinyint(1) NOT NULL,
  PRIMARY KEY (`f_date`),
  KEY `f_page` (`f_page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


$query_forumsections = "CREATE TABLE IF NOT EXISTS `".$dbprefix_."forumsections` (
  `f_ID` int(10) unsigned NOT NULL auto_increment,
  `f_sectionname` tinytext NOT NULL,
  `f_description` tinytext NOT NULL,
  `f_topics` int(11) NOT NULL,
  `f_moderatorID` int(11) NOT NULL,
  `f_status` char(6) NOT NULL COMMENT 'value could be \"open\" or \"closed\"',
  PRIMARY KEY  (`f_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ";



$query_forumposts = "CREATE TABLE IF NOT EXISTS `".$dbprefix_."forumposts` (
  `f_postID` int(10) unsigned NOT NULL auto_increment,
  `f_postauthorID` int(10) unsigned NOT NULL,
  `f_posttitle` varchar(250) NOT NULL,
  `f_postcontent` text NOT NULL,
  `f_postreplyto` int(10) unsigned NOT NULL,
  `f_postforumID` int(10) unsigned NOT NULL,
  `f_postdatestarted` datetime NOT NULL,
  `f_postlastreplied` datetime NOT NULL COMMENT 'date of the last reply',
  `f_postreplies` int(10) unsigned NOT NULL,
  `f_postviews` int(10) unsigned NOT NULL,
  `f_poststatus` varchar(10) NOT NULL COMMENT 'deleted, published, pending',
  `f_poststicky` char(3) NOT NULL COMMENT 'yes or no',
  PRIMARY KEY  (`f_postID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";





@mysql_query($query_members, CONNECTION);

@mysql_query($query_trafficstat, CONNECTION);

@mysql_query($query_forumsections, CONNECTION);

@mysql_query($query_forumposts, CONNECTION);


// create the photos directory and chmod it to 777


print '<div align="center">';
print '<div>Installation is completed</div>';
print '<div style="padding: 10px; background: #ffffcc; font-weight: bold">IMPORTANT: delete [install] directory in your server after running once.  This is for the security of your website.</div>';
print '</div>';

?>