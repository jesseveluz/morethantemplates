<?php
include_once 'meta_header.php';
?>

<title>Your title here</title>
<meta name="description" content="your site description here" />
<meta name="keywords" content="your keywords here" />
<meta name="robots" content="index" />
<meta name="robots" content="follow" />

</head>

<body>

<div class="mainwrapper"><!-- MAINWRAPPER -->

<?php include_once 'header.php'; ?>
	
<?php include_once 'topmenu.php'; ?>
	

	
	<div class="contentwrapper"> <!-- CONTENTWRAPPER -->
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td width="30%">
			
				<?php include_once 'sidemenu.php'; ?>
			
			</td>
			<td width="50">
				<img alt="devider" src="images/side_page_shadow.jpg" />
			</td>
			<td>
				<h1>Acknowledgement</h1>
				
				<div style="float:right;margin:10px;background:#fff;"><?php fblikebutton(); ?></div>

				<p>Thanks to the following people whose works have been fully implemented on this template</p>
				
				<p><a href="http://colorpowered.com/colorbox/">ColorBox v1.3.6</a> - a full featured, light-weight, customizable lightbox based on jQuery 1.3<br />
(c) 2009 Jack Moore</p>

				<p><a href="http://www.phpcaptcha.org/">Securimage Captcha</a> - an open-source free PHP CAPTCHA script for generating complex images and CAPTCHA codes to protect forms from spam and abuse.<br />
				(c) 2007 Drew Phillips</p>
				
				<p><a href="http://www.dynamicdrive.com/dynamicindex14/fadeinslideshow.htm">Ultimate Fade-in slideshow (v2.1)</a>- a robust and a cross browser fade in slideshow script<br />
				Author: Dynamic Drive</p>
				
				<p><a href="http://webmarketing411.com/">TableCreator</a> - An include file for PHP script to help create table within MySql loop.<br />
(c) 2008 Jesse Veluz</p>

				<p><a href="http://jquery.com/">jQuery JavaScript Library</a> - a fast and concise JavaScript Library that simplifies HTML document traversing, event handling, animating, and Ajax interactions for rapid web development.<br />
				Copyright (c) 2009 John Resig</p>
				
				<p><a href="http://code.google.com/p/php-email-address-validation/">php-email-address-validation</a> - A PHP class for validating email addresses according to the official specifications.<br />
				Author: Dave Child</p>
				
				<p><a href="http://webmarketing411.com/">DbNavigator</a> - An include file for PHP script to help generate pages for MySql records.<br />
(c) 2008 Jesse Veluz</p>

				<p><a href="http://www.dynamicdrive.com/">Smooth Navigational Menu</a>- A smooth drop down menu system using jQuery library<br />
				Author: Dynamic Drive</p>
				
				<p><a href="http://www.sbmkpm.com/">Line Graph Script - By Balamurugan S</a> <br />
Script featured at Dynamic Drive: http://www.dynamicdrive.com</p>

				<p><a href="http://www.sbmkpm.com/">Pie Graph Script - By Balamurugan S</a><br />
Script featured at Dynamic Drive: http://www.dynamicdrive.com</p>

				<p><a href="http://www.dynamicdrive.com/">Gradual Element Fader</a><br />
(c) Dynamic Drive DHTML code library</p>
				
				
			
			</td>
		</tr>
		</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once 'footer.php'; ?>

</div><!-- END MAINWRAPPER -->

<?php include_once 'bottomincludes.php'; ?>
</body>

</html>
