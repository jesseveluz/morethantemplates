<?php
include_once '../meta_header.php';
?>

<title><?php print $pagetitle; ?></title>
<meta name="description" content="<?php print $pagedescription; ?>" />
<meta name="keywords" content="<?php print $pagekeywords; ?>" />
<meta name="robots" content="<?php print $pagerobotindex; ?>" />
<meta name="robots" content="<?php print $pagerobotfollow; ?>" />

</head>

<body>

<div class="mainwrapper"><!-- MAINWRAPPER -->

	<?php include_once '../header.php'; ?>
	
	<?php include_once '../topmenu.php'; ?>
	

	
	<div class="contentwrapper"> <!-- CONTENTWRAPPER -->
	
		<?php
		
		if ($current_step == 'loginpage'){
		?>
			<h1 align="center">Admin Login</h1>

			<?php set_loginform($errormsg); ?>

		<?php
		}
		?>
		
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once '../footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>