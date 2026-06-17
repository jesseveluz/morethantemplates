<?php
session_start();
include_once '../inc/general_settings.php';

if (isset($_COOKIE[md5("membername".__SECRET_WORD__)])){
	header("location: ".MEMBER_DIR."/cp/");
	exit;
}

include_once '../meta_header.php';
?>

<title>Your title here</title>
<meta name="description" content="your site description here" />
<meta name="keywords" content="your keywords here" />
<meta name="robots" content="index" />
<meta name="robots" content="follow" />

</head>

<body>

<div class="mainwrapper"><!-- MAINWRAPPER -->

	<?php include_once '../header.php'; ?>
	
	<?php include_once '../topmenu.php'; ?>
	

	
	<div class="contentwrapper"> <!-- CONTENTWRAPPER -->
	
		<h1>Registration</h1>

		<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>
		
		<div align="center" style="background-color: #f2f2f2; border: 1px dotted #333; width: 450px; padding: 10px; margin: auto;">
			<h2>Register As Member</h2>
						<form method="post" action="<?php print $program_url; ?>/member/step2.php" accept-charset="<?PHP print $charset_; ?>">
							<table>
								<tr><td>Your Email:</td><td><input name="email" /></td></tr>
								<tr><td>First Name:</td><td><input name="firstname" /></td></tr>
								<tr><td>Last Name:</td><td><input name="lastname" /></td></tr>
								<tr><td>Country</td><td><input name="country" /></td></tr>
								<tr valign="bottom"><td>Enter code:</td><td><img src="../securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>"><br /><input name="code" value="<?php print $_POST['code']; ?>" /></td></tr>
								<tr><td></td><td><input type="submit" name="submit" value="Submit" /></td></tr>
							</table>
						</form>
			<p align="left" style="font-size: 9pt; color: #222; font-style: italic;">Your information is totally private and will not be shared with anyone else. We hate Spam as much as you do!</p>
			<p align="left" style="font-size: 9pt; color: #222; font-style: italic;"><span style="color: #cc0000;">Please note:</span> Check your bulk mail folder if you do not receive confirmation of your registration in the next 10 minutes!</p>
      </div>
	
		<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>
		
		<br />
		<br />
		<br />
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once '../footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>