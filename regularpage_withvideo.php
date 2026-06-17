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
			
				<h1>This Is the Regular Page With Video</h1>
				
				<div style="float:right;">
				<script type="text/javascript">
				document.write('<span class="style1"><a class="colorbox1" href="sample_video.php" title="Philippine Golf Tours"><img src="images/becky_video.jpg" border="0" alt="" /></a></span>');
				</script>
				<noscript><span class="style1"><a href="nojs_sample_video.php" title="Philippine Golf Tours">
				<img src="images/becky_video.jpg" border="0" alt="" /></a></span></noscript>
				
				</div>
				
				
				<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

				<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>
				
				<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

				<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>
			
			</td>
		</tr>
		</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once 'footer.php'; ?>

</div><!-- END MAINWRAPPER -->

<?php include_once 'bottomincludes.php'; ?>
</body>

</html>
