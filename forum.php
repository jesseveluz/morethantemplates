<?php
include_once 'forum/forumscript.php'; 
?>
<?php
include_once 'meta_header.php';
?>


<title>Forum | <?php print DOMAIN; ?></title>
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
	
					<div style="background:#ffffcc; width: 100%;border:1px solid #ccc;padding:10px;">Please setup your forum in your admin area and remove this notice when you're done.</div>
					
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td>
				<h1>Forum</h1>
				
				<?php print $forumoutput; ?>
			
			</td>
		</tr>
		</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once 'footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>
