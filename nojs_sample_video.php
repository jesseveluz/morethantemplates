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
				<h1>Regular Page With Video For Browser With Disabled Javascript</h1>
				
				<p>
				<object width="640" height="505"><param name="movie" value="http://www.youtube.com/v/0h93oWyuh5o&hl=en_US&fs=1&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/0h93oWyuh5o&hl=en_US&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object>
				</p>
				
				<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

			
			</td>
		</tr>
		</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once 'footer.php'; ?>


</div><!-- END MAINWRAPPER -->

</body>

</html>
