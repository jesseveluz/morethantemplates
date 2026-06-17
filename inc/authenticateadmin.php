<?php

if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)])){
	$adminname = decryptstr($_COOKIE[md5("adminname".__SECRET_WORD__)],__SECRET_WORD__);
	$admintype = decryptstr($_COOKIE[md5("admintype".__SECRET_WORD__)],__SECRET_WORD__);
	setcookie(md5("adminname".__SECRET_WORD__),encryptstr($adminname,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
	setcookie(md5("admintype".__SECRET_WORD__),encryptstr($admintype,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
	
	$Adminname = ucwords($adminname); // take note the capital A and the small a
}
?>