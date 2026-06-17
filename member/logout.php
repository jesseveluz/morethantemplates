<?php
include_once '../inc/general_settings.php';

setcookie(md5("membername".__SECRET_WORD__),'',time(),"/",DOMAIN,0);
setcookie(md5("memberemail".__SECRET_WORD__),'',time(),"/",DOMAIN,0);
setcookie(md5("memberparent".__SECRET_WORD__),'',time(),"/",DOMAIN,0);
setcookie(md5("memberid".__SECRET_WORD__),'',time(),"/",DOMAIN,0);

header('location: '.MEMBER_DIR.'/login.php');
exit;
?>