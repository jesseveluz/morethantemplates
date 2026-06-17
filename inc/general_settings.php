<?php
/*
 * MORETHANTEMPLATE Version 1.0.0.0
 * (c) Jesse Veluz, 2010
 * www.jesseveluz.com
 *


/* SETTINGS */
$program_url = 'https://example.com/mtt';  // no trailing slash
$programfolder = '/mtt'; // use '' if in the root

$domain_name_ = 'example.com';   // without 'www'
$secretwords_ = '8j40se$d';  // change this for your protection
$charset_ = 'UTF-8';

/* ADMIN EMAIL */
$admin_email = 'example@example.com';

/* DATABASE */
$dbname_ = 'k7yuj33_example';
$dbuser_ = 'k7yuj33_example_user';
$dbpass_ = 'example_c223K&%SmV';
$dbhost_ = 'localhost';
$dbprefix_ = 'example_demo_';  // Used for naming tables. It's very important to change this for site security purpose (example: jny_ or ybc_ or dcc_)



/* AFFILIATE PROGRAM */
$defaultparentid = '';  // you can use WealthTraders ID, or Clickbank ID or any ID provided to you by your affiliate manager.

/* ADMIN CONTROL PANEL AREA ACCESS */
/* superadmin is someone who can do anything such as remove, delete, update
 * admin is someone who can view details and edit record
 * staff is someone who can view details only
 *
 * VERY IMPORTANT FOR SECURITY PURPOSES
 *	
 * YOU NEED TO CHANGE THE USERS AND THE PASSWORDS
 * YES YOU NEED TO CHANGE THEM ALL!
 * 
 * YOU WILL NOT BE ABLE TO ACCESS YOUR SITE UNLESS YOU CHANGE THE USERS
 * AND THE PASSWORDS BELOW.
 */

$administrator[0]['name'] = 'superadminname_';  
$administrator[0]['type'] = 'superadmin';  // superadmin has all privileges
$administrator[0]['password'] = 'superadminpassword_';

$administrator[1]['name'] = 'adminname_';
$administrator[1]['type'] = 'admin';  // admin has limited privileges
$administrator[1]['password'] = 'adminnamepassword_';

// here's how to add another user
$administrator[2]['name'] = 'staffname_';
$administrator[2]['type'] = 'staff';  // staff has very limited privileges
$administrator[2]['password'] = 'staffnamepassword_';



// emails to use for contact form
$contact_form_fromheader = 'Example Name';
$contact_form_fromemail = 'example@example.com';  // what email to show to tell signing members where the message is coming from.  You can even use a NO-REPLY email account.


/* 
 * MESSAGES 
 ****************************************
*/

// Use this message to tell new member to confirm their email address
$step2_content = '<div style="font: normal 10pt Verdana; width: 90%; margin: auto;">

<br /><br />

<p>Thank you for your registration.</p>

<p>An email has been sent to you from '.$admin_email.'</p>

<p>This email includes a confirmation link which you need to click on in order to activate your registration.</p>

<p>Please check your email and confirm your registration.   Sometimes email messages went to spam folder so you may need to check your email there.</p>

<p>To your success,<br />
Your Company Name</p>
<br /><br />
';


// emails to use for registration purposes
$fromheader = 'Example';
$fromemail = 'example@example.com';  // what email to show to tell signing members where the message is coming from.  You can even use a NO-REPLY email account.

/*
 * CONFIRMATION EMAIL
 */
$confirm_email = 'Hello #FIRSTNAME#,

Thank you for your registration with _____________

In order to proceed, we require you to click on the following 
confirmation link:- 

#CONFIRM_LINK#

After you have clicked on this link, a window will open in your 
browser requesting you to nominate a Password. Once you have 
done that, you will have automatic access to the members area. 

To your success,

Your Company Name Support Team';
$confirm_email_subject = "#FIRSTNAME#, Please confirm your email";


/*
 * PASSWORD REQUEST EMAIL
 */
$forgot_email = 'Hi #FIRSTNAME#,

Here\'s your login details:
Email: #EMAIL#
Password: #PASSWORD#

Login here:
'.$program_url.'/member/login.php

You can change your password in your member area.

To your success,
Your Company Name Support Team
'; 
$forgot_email_subject = "#FIRSTNAME#, Your Password Request";



/*
 * Welcome EMAIL
 */
$welcome_email = 'Hello #FIRSTNAME#,

Welcome to ___name of your program____

Here are your login details:

Login here:
'.$program_url.'/member/login.php

Username: #EMAIL#
Password: #PASSWORD#

You can change your password at any time within your
Member Area.

You have ongoing access to ___name of your program___ member area so please feel 
free to login at any time. 

We will notify you of additions to the member area. 

To your success,

Your Company Name Support Team
'; 
$welcome_email_subject = "#FIRSTNAME#, Welcome To __name of your program____";


/*
 ACCOUNT SETTINGS
 ********************
 */
$maximum_photo_profile_size = 15000;  



/*
 * FORUM
 ******************
 */
$auto_approve_post = true;   
// use "false" if you want new posts to be pending prior to publication so you can check for quality of content.
// setting to "true" will make new posts to be published immediately.  Moderators however have the chance to remove inappropriate posts at any time.
$topics_per_page = 3;



/* 
 * FaceBook Like Button
 **********************
 * for more information about Facebook Like button
 * Read this: http://developers.facebook.com/docs/reference/plugins/like
 */
// values are all in small letters
$fbshowfaces	= true; // true or false if you don't want to show faces
$fbwidth	= "100";
$fbfont		= "lucida grande";  // trebuchet ms, arial, tahoma, verdana
$fbstyle 	= "box_count";  // 'standard' or 'button_count' or 'box_count'
$fbverb		= "recommend";  // 'recommend' or 'like'
$fbcolorscheme = "light";	 // 'light' or 'dark' 

/*
 * ADVANCED
 * FaceBook Like Button
 **********************
 * Set the following variables if you want to
 * use the Open Graph protocol of Facebook as describe
 * in this page: http://http://developers.facebook.com/docs/opengraph#types
 * You need to have a facebook account
 *
 * IMPORTANT:
 * If you are not sure if you want to use the Open Graph protocol (OG), then
 * Do not use it.  Just set $usefb_open_graph to false
 *
 * Read this first: http://http://developers.facebook.com/docs/opengraph#types
 */
$usefb_open_graph = false;  // set to false if you are not sure what this is
$ogtitle = '';
$ogtype = '';
$ogimage = '';
$ogurl = ''; 
$ogsitename = '';
$ogadmins = '';




define ('MEMBER_DIR',$program_url.'/member');
define ('ADMIN_DIR',$program_url.'/admin');
define ('__SECRET_WORD__',$secretwords_);  
define ('ALLOWED_SESSION_LENGTH',60*24);
define ('DOMAIN',$domain_name_); 
define ('VARSET','true');
define ('USE_FB_OPEN_GRAPH',$usefb_open_graph);

?>