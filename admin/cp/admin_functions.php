<?php

function addcalendarjs(){
	ob_start();
	?>
			<script type="text/javascript" src="calendarDateinput.js">

	/***********************************************
			* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
			* Script featured on and available at http://www.dynamicdrive.com
			* Keep this notice intact for use.
	***********************************************/

			</script>
			<?php
			$output = ob_get_contents();
	ob_end_clean();
	return $output;
}



function daterangeform(){
	if (isset($_SESSION['startdate'])){
		$_POST['startdate'] = $_SESSION['startdate'];
	}
	
	if (isset($_SESSION['endingdate'])){
		$_POST['endingdate'] = $_SESSION['endingdate'];
	}

	$output = '<table><tr><td>From:</td><td><form name="daterangeform" method="post" style="margin: 0 0 0 0px;">';
	$output .= "<script>DateInput('startdate', false, 'YYYY-MM-DD','".$_POST['startdate']."')</script>";
	$output .= '</td>';
	$output .= '<td>';
	$output .= "To:</td><td><script>DateInput('endingdate', false, 'YYYY-MM-DD','".$_POST['endingdate']."')</script>";
	$output .= '</td>';
	$output .= '<td><input name="submitlist" type="submit" value="Refresh List" />';
	$output .= '</form></span>';
	$output .= '</td></tr>';
	$output .= '</table>';
	return $output;
}



function searchform(){
	$output = '<span style="margin: 0px; font: normal 11px verdana;"><form name="searchform" method="post" style="margin: 0 0 0 0px;">';
	$output .= 'Search member: <input name="word2search" size="10" />';
	$output .= '<input name="submit" type="submit" value="Search" />';
	$output .= '</form></span>';
	return $output;
}



function trafficstatsearchform() {
	$output = '<span style="margin: 0px; font: normal 11px verdana;"><form name="searchform" method="post" style="margin: 0 0 0 0px;">';
	$output .= 'Search referrer: <input name="word2search" size="10" />';
	$output .= '<input name="submit" type="submit" value="Search" />';
	$output .= '</form></span>';
	return $output;
}

function forumsearchform() {
	$output = '<span style="margin: 0px; font: normal 11px verdana;"><form name="searchform" method="post" style="margin: 0 0 0 0px;">';
	$output .= 'Search topic section: <input name="word2search" size="10" />';
	$output .= '<input name="submit" type="submit" value="Search" />';
	$output .= '</form></span>';
	return $output;
}




function addcollapsible($collapsible,$divID,$option){
	$coll2add = "animatedcollapse.addDiv('".$divID."', '".$option."')\n";
	$coll2add .= "<#addcollapsiblehere#>\n";
	$output = str_replace('<#addcollapsiblehere#>',$coll2add,$collapsible);
	return $output;
}


function begincollapsible(){
	ob_start();
	?>
	<script>
	/***********************************************
	* Animated Collapsible DIV v2.0- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
	* This notice MUST stay intact for legal use
	* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
	***********************************************/
	</script>

	<script type="text/javascript">
	<#addcollapsiblehere#>
	animatedcollapse.init()
	</script>
	<?php
	$_output = ob_get_contents();
	ob_end_clean();
	return $_output;
}


function endcollapsible($collapsible){
	$output = str_replace('<#addcollapsiblehere#>','',$collapsible);
	return $output;	
}


?>