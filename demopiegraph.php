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
				<h1>Demo Pie Graph</h1>
				
				<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

				<!-- graph code begins here-->
				<script type="text/javascript" src="inc/wz_jsgraphics.js"></script>
				<script type="text/javascript" src="inc/pie.js">
				<!-- Pie Graph script-By Balamurugan S http://www.sbmkpm.com/ //-->
				<!-- Script featured/ available at Dynamic Drive code: http://www.dynamicdrive.com //-->
				</script>

				<div id="pieCanvas" style="overflow: auto; position:relative;height:350px;width:380px;"></div>

				<script type="text/javascript">
				var p = new pie();
				p.add("Jan",100);
				p.add("Feb",200);
				p.add("Mar",150);
				p.add("Apr",120);
				p.add("May",315);
				p.add("Jun",415);
				p.add("Jul",315);
				p.render("pieCanvas", "Pie Graph")

				</script>
				<!-- graph code ends here-->

			<p>Lorem Ipsum Dolor Sit Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vie Loremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>
				
			
			</td>
		</tr>
		</table>
	
	</div><!-- END CONTENTWRAPPER -->
	
	
<?php include_once 'footer.php'; ?>

</div><!-- END MAINWRAPPER -->

</body>

</html>
