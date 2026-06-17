<?php
include_once '../../inc/general_settings.php';
include_once 'authentication.php';
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
include_once '../../menu/dropmenu.php';
include_once '../../additional_header.php';
?>

</head>

<body>

<div class="mainwrapper"><!-- MAINWRAPPER -->

	<?php include_once '../../header.php'; ?>
	
	<?php include_once '../../topmenu.php'; ?>
	
	<div class="accountsection">
	<a href="myaccount.php">My Account</a> | <a href="<?php print $logoutlink; ?>">Logout</a>
	</div>
	
	<div class="contentwrapper"> <!-- CONTENTWRAPPER -->

	<table width="100%">
	<tr valign="top">
		<td>
		
		<?php print $content; ?>
		
		</td>
		<td width="1%"></td>
		<td width="30%">
			<div class="membersidemenu">
				<?php include_once 'sidemenu.php'; ?>
			</div>
		</td>
	</tr>
	</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once '../../footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>