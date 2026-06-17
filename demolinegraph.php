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
				<h1>Demo Line Graph</h1>
				
				<p>Sed facilisis turpis in elit. Nunc purus augue, ornare sed, bibendum vieLoremipsum dolor sit amet, consectetuer adipiscing elit. Cras sit amet neque a mauris semper sagittis. Sed facilisis turpis in elit. Nunc</p>

				<!-- graph code begins here-->
				<script type="text/javascript" src="inc/wz_jsgraphics.js"></script>
				<script type="text/javascript" src="inc/line.js">

				<!-- Line Graph script-By Balamurugan S http://www.sbmkpm.com/ //-->
				<!-- Script featured/ available at Dynamic Drive code: http://www.dynamicdrive.com //-->

				</script>

				<div id="lineCanvas" style="overflow: auto; position:relative;height:300px;width:400px;"></div>

				<script type="text/javascript">
				var g = new line_graph();
				g.add('1', 145);
				g.add('2', 0);
				g.add('3', 175);
				g.add('4', 130);
				g.add('5', 150);
				g.add('6', 175);
				g.add('7', 205);
				g.add('8', 125);
				g.add('9', 125);
				g.add('10', 135);
				g.add('11', 125);

				g.render("lineCanvas", "Line Graph");
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
