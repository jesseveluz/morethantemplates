<?php
// copyright (c) 2007 Jesse Veluz
// http://webmarketing411.com
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
$file = 'dbnavigator.php'; 
define ('___EXTENSION_DBNAVIGATOR___', true);

function setdbnavigator($uid,$ROWCOUNT,$querystring='',$itemperpage=10,$showlistperpage=true){

	if (!empty($querystring)){
		$qstrng = $querystring;
	} else {	
		// set extra string outside sqlnavigator.  We will add this string later to keep 
		//other query strings not related to sqlnavigator still functional
		$qstrng = $_SERVER['QUERY_STRING'];
	}

	$qstr_array = explode($uid.'offset=',$qstrng);
	$qstring = (empty($qstr_array[0])) ? '' : $qstr_array[0].'&';
	$qstring = str_replace('&&','&',$qstring);
	
	if (!isset($_GET[$uid.'offset'])){
		$OFFSET = 0;
		$IPP = 10;
	} else {
		$OFFSET = $_GET[$uid.'offset'];
		$IPP = $_GET[$uid.'ipp'];	
	}
	
	//
	if ($OFFSET<1){
		$OFFSET = 0;
	}
	

	$LIMIT = ($OFFSET+$IPP)-1;
	if ($LIMIT>$ROWCOUNT){
		$LIMIT = $ROWCOUNT;
	}
	
	if ($LIMIT==($ROWCOUNT-1)){
		$LIMIT = $ROWCOUNT;
	}
	
	
	if ($showlistperpage){
		// list 10
		$list10 = '';
		if ($ROWCOUNT > 9){
			$list10 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=10\">10</a>";
		}
		
		// list 20
		$list20 = '';
		if ($ROWCOUNT > 10){
			$list20 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=20\">20</a>";
		}
		
		// list 30
		$list30 = '';
		if ($ROWCOUNT > 20){
			$list30 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=30\">30</a>";
		}
		
		// list 50
		$list50 = '';
		if ($ROWCOUNT > 49){
			$list50 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=50\">50</a>";
		}
		
		// list 100
		$list100 = '';
		if ($ROWCOUNT > 99){
			$list100 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=100\">100</a>";	
		}
	}
	
	// list next
	if ($LIMIT>=$ROWCOUNT){
		$listnext = '';			
	} else {
		$next = $LIMIT+1;
		$listnext = "| <a href=\"?".$qstring.$uid."offset=".$next."&".$uid."ipp=".$IPP."\">Next</a>";	
	}
	
	// list prev
	if ($OFFSET<1){
		$listprev = '';
	} else {
		$prev = $OFFSET-$IPP;
		$listprev = "<a href=\"?".$qstring.$uid."offset=".$prev."&".$uid."ipp=".$IPP."\">Prev</a> |";	
	}
	
	// list first
	if ($OFFSET==0){
		$listfirst = '';
	} else {
		$listfirst = "<a href=\"?".$qstring.$uid."offset=0&".$uid."ipp=".$IPP."\">First</a> |";	
	}
	
	// list last
	if ($LIMIT==$ROWCOUNT){
		$listlast = '';
	} else {
		// determine the last record
		$remrec = $ROWCOUNT%$IPP;  // remaining records
		// determine the last records according to $IPP minus the remaining records
		if ($remrec==0){
			$lastrec = (($ROWCOUNT/$IPP)*$IPP)-$IPP;
		} else {
			$lastrec = (($ROWCOUNT/$IPP)*$IPP)-$remrec;
		}
		$last = $lastrec;
		$listlast = "| <a href=\"?".$qstring.$uid."offset=".$last."&".$uid."ipp=".$IPP."\">Last</a>";	
	}

	
	
	$dbnav = array();
	$dbnav['first'] = $listfirst;
	$dbnav['last'] = $listlast;
	$dbnav['prev'] = $listprev;
	$dbnav['next'] = $listnext;
	$dbnav['offset'] = $OFFSET;
	$dbnav['limit'] = $IPP;
	$OFFSET++;
	$LIMIT++;
	if ($ROWCOUNT==0) $OFFSET=0;
	IF ($LIMIT>$ROWCOUNT) $LIMIT=$ROWCOUNT;
	$dbnav['records'] = 'Items '.$OFFSET.' to '.$LIMIT.' of '.$ROWCOUNT;
	if ($showlistperpage){
		if (!empty($list10)){
			$dbnav['list'] = 'Show '.$list10.$list20.$list30.$list50.$list100.'| per page';
		} else {
			$dbnav['list'] = '';
		}
	} else {
		$dbnav['list'] = '';
	}

		
	return $dbnav;
}


function rawdbnavigator($uid,$ROWCOUNT,$basepath='',$itemperpage=10,$showlistperpage=true,$encrypted=''){
	// set extra string outside sqlnavigator.  We will add this string later to keep other query strings not related to sqlnavigator still functional
	$qstrng = $_SERVER['QUERY_STRING'];
	if ($encrypted){
		$qstr_array = explode($uid.'=',$qstrng);
	} else {
		$qstr_array = explode($uid.'offset=',$qstrng);
	}
	$qstring = (empty($qstr_array[0])) ? '' : $qstr_array[0].'&';
	$qstring = str_replace('&&','&',$qstring);
	
	if ($encrypted){
		if (!isset($_GET[$uid])){
			$OFFSET = 0;
			$IPP = $itemperpage;			
		} else {
			// then we convert encrypted query string into array
			global $FGET_;
			urldecrypt($_GET[$uid]);
			$OFFSET = $FGET_['offset'];
			$IPP = $FGET_['ipp'];
		}
	} else {
		if (!isset($_GET[$uid.'offset'])){
			$OFFSET = 0;
			$IPP = 10;
		} else {
			$OFFSET = $_GET[$uid.'offset'];
			$IPP = $_GET[$uid.'ipp'];	
		}
	}
	
	//
	if ($OFFSET<1){
		$OFFSET = 0;
	}
	

	$LIMIT = ($OFFSET+$IPP)-1;
	if ($LIMIT>$ROWCOUNT){
		$LIMIT = $ROWCOUNT;
	}
	
	if ($LIMIT==($ROWCOUNT-1)){
		$LIMIT = $ROWCOUNT;
	}
	
	
	if ($showlistperpage){
		// list 10
		$list10 = '';
		if ($ROWCOUNT > 9){
			if ($encrypted){
				$encryptedqry = $uid."=".urlencrypt("offset=".$OFFSET."&ipp=10");
				$list10 = "|<a href=\"?".$qstring.$encryptedqry."\">10</a>";		
			} else {
				if (!empty($basepath)){
					$list10 = "|<a href=\"".$basepath.'/'.$OFFSET."/10/page.html\">10</a>";
				} else {
					$list10 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=10\">10</a>";
				}
			}
		}
		
		// list 20
		$list20 = '';
		if ($ROWCOUNT > 10){
			if ($encrypted){
				$encryptedqry = $uid."=".urlencrypt("offset=".$OFFSET."&ipp=20");
				$list20 = "|<a href=\"?".$qstring.$encryptedqry."\">20</a>";		
			} else {
				if (!empty($basepath)){
					$list20 = "|<a href=\"".$basepath.'/'.$OFFSET."/20/page.html\">20</a>";
				} else {
					$list20 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=20\">20</a>";
				}
			}
		}
		
		// list 30
		$list30 = '';
		if ($ROWCOUNT > 20){
			if ($encrypted){
				$encryptedqry = $uid."=".urlencrypt("offset=".$OFFSET."&ipp=30");
				$list30 = "|<a href=\"?".$qstring.$encryptedqry."\">30</a>";		
			} else {	
				if (!empty($basepath)){
					$list30 = "|<a href=\"".$basepath.'/'.$OFFSET."/30/page.html\">30</a>";
				} else {
					$list30 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=30\">30</a>";
				}
			}
		}
		
		// list 50
		$list50 = '';
		if ($ROWCOUNT > 49){
			if ($encrypted){
				$encryptedqry = $uid."=".urlencrypt("offset=".$OFFSET."&ipp=50");
				$list50 = "|<a href=\"?".$qstring.$encryptedqry."\">50</a>";		
			} else {
				if (!empty($basepath)){
					$list50 = "|<a href=\"".$basepath.'/'.$OFFSET."/50/page.html\">50</a>";
				} else {
					$list50 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=50\">50</a>";
				}
			}
		}
		
		// list 100
		$list100 = '';
		if ($ROWCOUNT > 99){
			if ($encrypted){
				$encryptedqry = $uid."=".urlencrypt("offset=".$OFFSET."&ipp=100");
				$list100 = "|<a href=\"?".$qstring.$encryptedqry."\">100</a>";		
			} else {	
				if (!empty($basepath)){
					$list100 = "|<a href=\"".$basepath.'/'.$OFFSET."/100/page.html\">100</a>";	
				} else {
					$list100 = "|<a href=\"?".$qstring.$uid."offset=".$OFFSET."&".$uid."ipp=100\">100</a>";	
				}
			}
		}
	}
	
	// list next
	if ($LIMIT>=$ROWCOUNT){
		$listnext = '';			
	} else {
		$next = $LIMIT+1;
		if ($encrypted){
			$encryptedqry = $uid."=".urlencrypt("offset=".$next."&ipp=".$IPP);
			$listnext = "| <a href=\"?".$qstring.$encryptedqry."\">Next</a>";					
		} else {
			if (!empty($basepath)){
				$listnext = "| <a href=\"".$basepath.'/'.$next."/".$IPP."/page.html\">Next</a>";	
			} else {
				$listnext = "| <a href=\"?".$qstring.$uid."offset=".$next."&".$uid."ipp=".$IPP."\">Next</a>";	
			}
		}
	}
	
	// list prev
	if ($OFFSET<1){
		$listprev = '';
	} else {
		$prev = $OFFSET-$IPP;
		if ($encrypted){
			$encryptedqry = $uid."=".urlencrypt("offset=".$prev."&ipp=".$IPP);
			$listprev = "<a href=\"?".$qstring.$encryptedqry."\">Prev</a> |";				
		} else {
			if (!empty($basepath)){
				$listprev = "<a href=\"".$basepath.'/'.$prev."/".$IPP."/page.html\">Prev</a> |";	
			} else {
				$listprev = "<a href=\"?".$qstring.$uid."offset=".$prev."&".$uid."ipp=".$IPP."\">Prev</a> |";	
			}
		}
	}
	
	// list first
	if ($OFFSET==0){
		$listfirst = '';
	} else {
		if ($encrypted){
			$encryptedqry = $uid."=".urlencrypt("offset=0&ipp=".$IPP);			
			$listfirst = "<a href=\"?".$qstring.$encryptedqry."\">First</a> |";	
		} else {
			if (!empty($basepath)){
				$listfirst = "<a href=\"".$basepath.'/0/'.$IPP."/page.html\">First</a> |";	
			} else {
				$listfirst = "<a href=\"?".$qstring.$uid."offset=0&".$uid."ipp=".$IPP."\">First</a> |";	
			}
		}
	}
	
	// list last
	if ($LIMIT==$ROWCOUNT){
		$listlast = '';
	} else {
		// determine the last record
		$remrec = $ROWCOUNT%$IPP;  // remaining records
		// determine the last records according to $IPP minus the remaining records
		if ($remrec==0){
			$lastrec = (($ROWCOUNT/$IPP)*$IPP)-$IPP;
		} else {
			$lastrec = (($ROWCOUNT/$IPP)*$IPP)-$remrec;
		}
		$last = $lastrec;
		if ($encrypted){
			$encryptedqry = $uid."=".urlencrypt("offset=".$last."&ipp=".$IPP);				
			$listlast = "| <a href=\"?".$qstring.$encryptedqry."\">Last</a>";				
		} else {
			if (!empty($basepath)){
				$listlast = "| <a href=\"".$basepath.'/'.$last."/".$IPP."/page.html\">Last</a>";	
			} else {
				$listlast = "| <a href=\"?".$qstring.$uid."offset=".$last."&".$uid."ipp=".$IPP."\">Last</a>";	
			}
		}
	}

	
	
	$dbnav = array();
	$dbnav['first'] = $listfirst;
	$dbnav['last'] = $listlast;
	$dbnav['prev'] = $listprev;
	$dbnav['next'] = $listnext;
	$dbnav['offset'] = $OFFSET;
	$dbnav['limit'] = $IPP;
	$OFFSET++;
	$LIMIT++;
	if ($ROWCOUNT==0) $OFFSET=0;
	IF ($LIMIT>$ROWCOUNT) $LIMIT=$ROWCOUNT;
	$dbnav['records'] = 'Items '.$OFFSET.' to '.$LIMIT.' of '.$ROWCOUNT;
	if ($showlistperpage){
		if (!empty($list10)){
			$dbnav['list'] = 'Show '.$list10.$list20.$list30.$list50.$list100.'| per page';
		} else {
			$dbnav['list'] = '';
		}
	} else {
		$dbnav['list'] = '';
	}

		
	return $dbnav;
}



function dbnavigator($dbnav,$mainID,$dbnavstatusID,$listID){
	$navigator = "<div id=".$mainID.">";
	$navigator .= "<div class=".$dbnavstatusID.">".$dbnav['first']." ".$dbnav['prev']." ".$dbnav['records']." ".$dbnav['next']." ".$dbnav['last']."</div>";
	$navigator .= "<span class=".$listID.">".$dbnav['list']."</span>";
	$navigator .= "</div>";
	return $navigator;
}




?>
