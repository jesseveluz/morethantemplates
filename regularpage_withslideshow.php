<?php
include_once 'meta_header.php';
?>

<title>Your title here</title>
<meta name="description" content="your site description here" />
<meta name="keywords" content="your keywords here" />
<meta name="robots" content="index" />
<meta name="robots" content="follow" />

<script type="text/javascript">

var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [590, 156], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["http://247resourcecenter.com/templates/slideshow/regularpage_slideshow1.jpg", "", "", ""],
		["http://247resourcecenter.com/templates/slideshow/regularpage_slideshow2.jpg", "", "", ""],
		["http://247resourcecenter.com/templates/slideshow/regularpage_slideshow3.jpg", "", "", ""] // no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:5000, cycles:0, wraparound:false, randomize:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 1500, //transition duration (milliseconds)
	descreveal: "",
	togglerid: ""
})

</script>

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
			
				<div id="fadeshow1"></div>
				<noscript><img alt="do business" src="slideshow/regularpage_slideshow1.jpg" /></noscript>
				<h1>Regular Page With Slideshow</h1>
				
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
