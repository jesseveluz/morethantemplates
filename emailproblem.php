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

<div class="mainwrapper">
	<?php include_once 'header.php'; ?>

	<div class="whitewrapper">

	<?php require 'topmenu.php'; ?>
	<hr />
			
	<!-- MAIN BODY CONTENT START -->
	<table width="880" border="0" align="center">
		<tr>
		
		<td width="100%">
			<h1><img alt="" src="<?php print $site_url; ?>/images/h1arrow.jpg" /> Contact Form</h1>
			<p>We have problem sending your message to the admin, please notify the webmaster about this problem.</p>
		<p><br /><br /><br /><br /><br /></p>
		</td>
		
		</tr>
	</table>
	<!-- MAIN BODY CONTENT END -->

	<hr />
	<?php require 'footer.php'; ?>
	</div>
	
<?php require 'copyright.php'; ?>
</div>


</body>

</html>
