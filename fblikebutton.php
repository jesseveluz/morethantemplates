<?php
// FaceBook Like Button
// initialize options:

// values are all in small letters
$fbshowfaces	= true; // true or false if you don't want to show faces
$fbwidth	= "400";
$fbfont		= "lucida grande";  // trebuchet ms, arial, tahoma, verdana
$fbstyle 	= "standard";  // 'standard' or 'button_count' or 'box_count'
$fbverb		= "like";  // 'recommend' or 'like'
$fbcolorscheme = "light";	 // 'light' or 'dark' 



function fblikebutton(){
	global $fbshowfaces,$fbwidth,$fbfont,$fbstyle,$fbverb,$fbcolorscheme;

	$fburl	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	/*if ($fbstyle=='button_count' || $fbstyle=='box_count'){
		echo '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="'.$fburl.'" layout="'.$style.'" show_faces="'.$fbshowfaces.'" width="'.$fbwidth.'" action="'.$fbverb.'" font="'.$fbfont.'" colorscheme="'.$fbcolorscheme.'"></fb:like>';
	} else {
		// default to standard
		echo '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="'.$fburl.'" show_faces="'.$fbshowfaces.'" width="'.$fbwidth.'" font="'.$fbfont.'"></fb:like>';
	}*/

	echo '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="'.$fburl.'" layout="'.$fbstyle.'" show_faces="'.$fbshowfaces.'" width="'.$fbwidth.'" action="'.$fbverb.'" font="'.$fbfont.'" colorscheme="'.$fbcolorscheme.'"></fb:like>';

}


fblikebutton();
?>