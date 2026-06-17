<?php
if (!DEFINED(VARSET)) {
	exit;
}

// make connections
$connection = mysql_connect($dbhost_,$dbuser_,$dbpass_) or die ('unable to connect');
mysql_select_db($dbname_) or die ('unable to select database');
define ('CONNECTION',$connection);

?>