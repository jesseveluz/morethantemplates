<?php
include_once '../inc/general_settings.php';

setcookie(md5("adminname".__SECRET_WORD__),'',time(),"/",DOMAIN,0);
setcookie(md5("admintype".__SECRET_WORD__),'',time(),"/",DOMAIN,0);

header('location: '.ADMIN_DIR.'/index.php');
exit;
?>