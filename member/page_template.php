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
		if ($current_step=="step2"){
			print $content;
		}
		
		if ($current_step == 'step3') {
			
			if ($previouslyconfirmed){
			?>
				<p align="center">This account was confirmed on <?php print $date_confirmed; ?></p>
			<?php
			} else {
			?>
				<p align="center">Your registration has been successfully confirmed.</p>
				<p align="center">Please nominate a Password for your exclusive access to your ___programname____ Member Area. </p>
			  <p align="center">Once completed, you will be automatically logged into your Member Area. </p>
				<?php set_passwordcreationform(); ?>
			<?php
			}
			
		}
		
		if ($current_step == 'step4'){
			if ($password_isvalid){
			} else {
			?>
					<div align="center">
					<p>Oops! Please re-enter your password so it has  <strong>at least 6 characters</strong>.</p>

			<?php print set_passwordcreationform(); 
			}
		}
		
		if ($current_step == 'forgotpassword'){
		?>
				<h3 align="center">Password Retrieval System</h3>
				<p align="center">Please enter your email and we will send you the password you have registered</p>

				<div align="center"><?php set_forgotpasswordform($errormsg); ?></div>

				<p align="center">Not yet a member?  <a href="<?php print MEMBER_DIR; ?>/">Register here</a></p>
		<?php
		}
		
		if ($current_step == 'loginpage'){
		?>

		
			<h1 align="center">Login</h1>
			<p align="center">Please login below to gain access to your member area... </p>

			<?php set_loginform($errormsg); ?>

			<p align="center">Not yet a member?  <a href="<?php print MEMBER_DIR?>/">Register here</a></p>
			<p align="center">Forgot your password?  <a href="<?php print MEMBER_DIR?>/forgot.php">Click here</a></p>
		<?php
		}
		?>
		
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once '../footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>
