<?php

include_once 'general_settings.php';
include_once 'go_dbconnect.php';
include_once 'functions.php';

if (DOMAIN==''){
} else {
	$traffic_source = 'direct';
	$site_referrer = 0; // direct traffic
	if (isset($_SERVER['HTTP_REFERER'])) {
		$traffic_source = $_SERVER['HTTP_REFERER'];
		if (strstr($_SERVER['HTTP_REFERER'],DOMAIN)){
			$site_referrer = 1; // internal traffic
		} else {
			$site_referrer = 2; // meaning that traffic is coming from external domain
		}
	}

	$trafficstat_connect = mysql_connect($dbhost_,$dbuser_,$dbpass_) or die ('unable to connect');
	mysql_select_db($dbname_) or die ('unable to select database');

	$query = 'insert into '.$dbprefix_.'trafficstat values (NOW(),\''.$traffic_source.'\',\''.get_client_ip().'\',\''.$_SERVER['REQUEST_URI'].'\',\''.$site_referrer.'\')';

	$queryresource = mysql_query($query, $trafficstat_connect);
	@mysql_free_result($queryresource);
}

?>