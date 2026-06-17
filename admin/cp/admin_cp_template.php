<?php
include_once '../../inc/general_settings.php';
include_once 'admin_authentication.php';
?>
<?php
include_once '../../meta_header.php';
?>

<title><?php print $pagetitle; ?></title>
<meta name="description" content="<?php print $pagedescription; ?>" />
<meta name="keywords" content="<?php print $pagekeywords; ?>" />
<meta name="robots" content="<?php print $pagerobotindex; ?>" />
<meta name="robots" content="<?php print $pagerobotfollow; ?>" />

<?php
print $extra_meta;
?>

<?php print $headinsert; ?>
</head>

<body>

<div class="mainwrapper"><!-- MAINWRAPPER -->

	<?php include_once '../../header.php'; ?>
	
	<?php include_once '../../topmenu.php'; ?>
	

	
	<div class="contentwrapper"> <!-- CONTENTWRAPPER -->
	

		<div align="right" style="padding-top: 10px;">Hello <strong><?php print $Adminname; ?></strong> | You are logged as <strong><?php print $admintype; ?></strong> <strong>[<a href="<?php print $logoutlink; ?>">Logout</a>]</strong></div>
		
		<div><?php include_once 'admin_top_menu.php'; ?></div>
		

			
			<?php print $admincontent; ?>
			
			
			<br />
			<br />
			<br />
			
			<?php
		
			// TIME ZONE REFERENCE
			$timereference = "<strong>Server Time: </strong> ".date('(e \G\M\T O) M d, Y h:i:s A',time());
			date_default_timezone_set('UTC');
			$timereference .= "<br /><strong>UTC/GMT Date/Time:</strong> ".date('e (\G\M\T O) M d, Y h:i:s A',time());
			$timereference .= '<br /><br />';
			print $timereference;

			?>

				
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once '../../footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>