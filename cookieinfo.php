<?php
include_once 'inc/general_settings.php';
define ('ALLOWED_COOKIE_TIME',60*60*24*3650);  // sets the cookie to 10 years;




		print "AFFILIATE==>".decryptstr($_COOKIE[md5("subscrbrparentID".__SECRET_WORD__)],__SECRET_WORD__);
			
		
function encryptstr($str, $ky = '') {
    if ($ky == '') return $str;
    $ky = str_replace(chr(32), '', $ky);
    if (strlen($ky) < 8) exit('key error');
    $kl = strlen($ky) < 32 ? strlen($ky) : 32;
    $k = array();
    for ($i = 0; $i < $kl; $i++) {
        $k[$i] = ord($ky[$i]) & 0x1F;
    }
    $j = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $e = ord($str[$i]);
        $str[$i] = $e & 0xE0 ? chr($e ^ $k[$j]) : chr($e);
        $j++;
        $j = $j == $kl ? 0 : $j;
    }
    return base64_encode(urlencode($str));
}

function decryptstr($strr, $ky = '') {
    $str = urldecode(base64_decode($strr));
    if ($ky == '') return $str;
    $ky = str_replace(chr(32), '', $ky);
    if (strlen($ky) < 8) exit('key error');
    $kl = strlen($ky) < 32 ? strlen($ky) : 32;
    $k = array();
    for ($i = 0; $i < $kl; $i++) {
        $k[$i] = ord($ky[$i]) & 0x1F;
    }
    $j = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $e = ord($str[$i]);
        $str[$i] = $e & 0xE0 ? chr($e ^ $k[$j]) : chr($e);
        $j++;
        $j = $j == $kl ? 0 : $j;
    }
    return $str;
}





?>