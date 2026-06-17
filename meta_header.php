<?php
include_once 'inc/general_settings.php';
include_once 'inc/functions.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php print $program_url; ?>/style.css" rel="stylesheet" type="text/css" />

<link href="<?php print $program_url; ?>/inc/table.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php print $program_url; ?>/jshelper.js"></script>


<?php
include_once 'additional_header.php';
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php print $program_url; ?>/inc/imagewarp/imagewarp.js">
/***********************************************
* jQuery imageWarp script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
 $('a>img:first').imageWarp() //apply warp effect to images that are hyperlinked
})
</script>