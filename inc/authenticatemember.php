<?php

if (isset($_COOKIE[md5("membername".__SECRET_WORD__)])){
	$firstname = decryptstr($_COOKIE[md5("membername".__SECRET_WORD__)],__SECRET_WORD__);
	$memberemail = decryptstr($_COOKIE[md5("memberemail".__SECRET_WORD__)],__SECRET_WORD__);
	$parentid = decryptstr($_COOKIE[md5("memberparent".__SECRET_WORD__)],__SECRET_WORD__);
	$memberid = decryptstr($_COOKIE[md5("memberid".__SECRET_WORD__)],__SECRET_WORD__);
	
	setcookie(md5("memberid".__SECRET_WORD__),encryptstr($memberid,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
	setcookie(md5("memberparent".__SECRET_WORD__),encryptstr($parentid,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
	setcookie(md5("memberemail".__SECRET_WORD__),encryptstr($memberemail,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
	setcookie(md5("membername".__SECRET_WORD__),encryptstr($firstname,__SECRET_WORD__),time()+ALLOWED_SESSION_LENGTH,"/",DOMAIN,0);
	
	$Firstname = ucwords($firstname);
}

?>