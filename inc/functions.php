<?php
function fblikebutton(){
	global $fbshowfaces,$fbwidth,$fbfont,$fbstyle,$fbverb,$fbcolorscheme;

	$fburl	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	echo '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="'.$fburl.'" layout="'.$fbstyle.'" show_faces="'.$fbshowfaces.'" width="'.$fbwidth.'" action="'.$fbverb.'" font="'.$fbfont.'" colorscheme="'.$fbcolorscheme.'"></fb:like>';

}



function admin_button(){
	if (isset($_COOKIE[md5("adminname".__SECRET_WORD__)])){
		print '<li><a href="'.ADMIN_DIR.'">Admin</a></li>';
	}
}


function check_email($email){
	$email_validator = new EmailAddressValidator;
	if ($email_validator->check_email_address(trim($email))) {
		return true;
	} else {
		return false;
	}
}

function check_name($name){
	if (empty($name)){
		return false;
	} else {
		/*
		 * other option would be ^([ \u00c0-\u01ffa-zA-Z'\-])+$
		 * source: http://stackoverflow.com/questions/275160/regex-for-names
		 */
		$pattern = '([[:digit:]]|[~`!@#$%^&*()_=+{}|:;<>"/?,]|[|]|-)+';
		$name = stripslashes($name);
		if (ereg($pattern,$name)) {
			return false;
		} else {
			return true;
		}
	}
}

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


function check_isemailnew($thisemail){
	global $dbprefix_;
	$query = "select f_email from ".$dbprefix_."members where f_email='".$thisemail."' ";
	$queryresource = @mysql_query($query, CONNECTION);
	if (@mysql_num_rows($queryresource)){
		return false;
	} else {
		return true;
	}
}


		
//Function to get user ip
function get_client_ip(){
	if (getenv("HTTP_X_CLUSTER_CLIENT_IP")){
		return getenv("HTTP_X_CLUSTER_CLIENT_IP");
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$pipaddress = getenv("HTTP_X_FORWARDED_FOR");
			$ipaddress = getenv("REMOTE_ADDR");
			return $pipaddress."(via ".$ipaddress.")";
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}
}


function check_isreciprocallinknew($thislink){
	global $dbprefix_;
	$query = "select f_reciprocallink from ".$dbprefix_."bottomads where f_reciprocallink='".$thislink."' ";
	$queryresource = @mysql_query($query, CONNECTION);
	if (@mysql_num_rows($queryresource)){
		return false;
	} else {
		return true;
	}
}





/*

EmailAddressValidator Class
http://code.google.com/p/php-email-address-validation/

Released under New BSD license
http://www.opensource.org/licenses/bsd-license.php

Sample Code
----------------
$validator = new EmailAddressValidator;
if ($validator->check_email_address('test@example.org')) {
	// Email address is technically valid
}

*/

class EmailAddressValidator {

        /**
	* Check email address validity
	* @param   strEmailAddress     Email address to be checked
	* @return  True if email is valid, false if not
	*/
	public function check_email_address($strEmailAddress) {
            
            // If magic quotes is "on", email addresses with quote marks will
            // fail validation because of added escape characters. Uncommenting
            // the next three lines will allow for this issue.
            //if (get_magic_quotes_gpc()) { 
            //    $strEmailAddress = stripslashes($strEmailAddress); 
            //}

            // Control characters are not allowed
			    if (preg_match('/[\x00-\x1F\x7F-\xFF]/', $strEmailAddress)) {
		    return false;
			    }

            // Split it into sections using last instance of "@"
			    $intAtSymbol = strrpos($strEmailAddress, '@');
	    if ($intAtSymbol === false) {
                // No "@" symbol in email.
				return false;
	    }
	    $arrEmailAddress[0] = substr($strEmailAddress, 0, $intAtSymbol);
	    $arrEmailAddress[1] = substr($strEmailAddress, $intAtSymbol + 1);

            // Count the "@" symbols. Only one is allowed, except where 
            // contained in quote marks in the local part. Quickest way to
            // check this is to remove anything in quotes.
			    $arrTempAddress[0] = preg_replace('/"[^"]+"/'
			    ,''
			    ,$arrEmailAddress[0]);
	    $arrTempAddress[1] = $arrEmailAddress[1];
	    $strTempAddress = $arrTempAddress[0] . $arrTempAddress[1];
            // Then check - should be no "@" symbols.
			    if (strrpos($strTempAddress, '@') !== false) {
                // "@" symbol found
				return false;
			    }

            // Check local portion
			    if (!$this->check_local_portion($arrEmailAddress[0])) {
		    return false;
			    }

            // Check domain portion
			    if (!$this->check_domain_portion($arrEmailAddress[1])) {
		    return false;
			    }

            // If we're still here, all checks above passed. Email is valid.
			    return true;

	}

        /**
	* Checks email section before "@" symbol for validity
	* @param   strLocalPortion     Text to be checked
	* @return  True if local portion is valid, false if not
	*/
	protected function check_local_portion($strLocalPortion) {
            // Local portion can only be from 1 to 64 characters, inclusive.
            // Please note that servers are encouraged to accept longer local
            // parts than 64 characters.
			    if (!$this->check_text_length($strLocalPortion, 1, 64)) {
		    return false;
			    }
            // Local portion must be:
            // 1) a dot-atom (strings separated by periods)
            // 2) a quoted string
            // 3) an obsolete format string (combination of the above)
			    $arrLocalPortion = explode('.', $strLocalPortion);
	    for ($i = 0, $max = sizeof($arrLocalPortion); $i < $max; $i++) {
		    if (!preg_match('.^('
				      .    '([A-Za-z0-9!#$%&\'*+/=?^_`{|}~-]' 
				      .    '[A-Za-z0-9!#$%&\'*+/=?^_`{|}~-]{0,63})'
				      .'|'
				      .    '("[^\\\"]{0,62}")'
				      .')$.'
				      ,$arrLocalPortion[$i])) {
			    return false;
				      }
	    }
	    return true;
	}

        /**
	* Checks email section after "@" symbol for validity
	* @param   strDomainPortion     Text to be checked
	* @return  True if domain portion is valid, false if not
	*/
	protected function check_domain_portion($strDomainPortion) {
            // Total domain can only be from 1 to 255 characters, inclusive
			    if (!$this->check_text_length($strDomainPortion, 1, 255)) {
		    return false;
			    }
            // Check if domain is IP, possibly enclosed in square brackets.
			    if (preg_match('/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])'
			    .'(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])){3}$/'
			    ,$strDomainPortion) || 
			    preg_match('/^\[(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])'
					    .'(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])){3}\]$/'
					    ,$strDomainPortion)) {
				    return true;
					    } else {
						    $arrDomainPortion = explode('.', $strDomainPortion);
						    if (sizeof($arrDomainPortion) < 2) {
							    return false; // Not enough parts to domain
						    }
						    for ($i = 0, $max = sizeof($arrDomainPortion); $i < $max; $i++) {
                    // Each portion must be between 1 and 63 characters, inclusive
				    if (!$this->check_text_length($arrDomainPortion[$i], 1, 63)) {
			    return false;
				    }
				    if (!preg_match('/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|'
								    .'([A-Za-z0-9]+))$/', $arrDomainPortion[$i])) {
					    return false;
								    }
						    }
					    }
					    return true;
	}

        /**
	* Check given text length is between defined bounds
	* @param   strText     Text to be checked
	* @param   intMinimum  Minimum acceptable length
	* @param   intMaximum  Maximum acceptable length
	* @return  True if string is within bounds (inclusive), false if not
	*/
	protected function check_text_length($strText, $intMinimum, $intMaximum) {
            // Minimum and maximum are both inclusive
			    $intTextLength = strlen($strText);
	    if (($intTextLength < $intMinimum) || ($intTextLength > $intMaximum)) {
		    return false;
	    } else {
		    return true;
	    }
	}

}
?>