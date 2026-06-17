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
			
				<h1>This Is a Sample of Photo Gallery</h1>
				
				<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>
				
				<table class="photogallery" border="0">
				<tr>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
				</tr>
				<tr>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
					<td><a class='colorbox1 gradualfader' href="images/sampleimage.jpg" title="sample image">
				<img src="images/samplethumbnail.jpg" border="0" alt="" /></a></td>
				</tr>
				</table>

			</td>
		</tr>
		</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once 'footer.php'; ?>

</div><!-- END MAINWRAPPER -->

<?php include_once 'bottomincludes.php'; ?>

</body>

</html>
