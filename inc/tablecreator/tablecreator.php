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
$file = 'tablecreator.php'; 
define ('___EXTENSION_TABLECREATOR___', true);

// adding tableruller
// this script uses the javascript tableruler found in ndmframe.js


// $tableID='ndmftable'
function starttablecreator($tableID='tablecreator'){
	$table = array();
	$table[] = "<table id=\"".$tableID."\" class=\"ruler\">";
	return $table;
}

function endtablecreator($table){
	array_push($table,'</table>');
	$newtable = '';
	foreach ($table as $val){
		$newtable .= $val;
	}
	return $newtable;
}

function settableheader($table,$rowdata,$headID='tableheader',$widthdata=''){
	$row = "\n<thead><tr>";
	$ctr=1;
	$colID = '';
	if (!empty($headID)){
		$colID = ' class="'.$headID.'"';
	}

	foreach ($rowdata as $val){
		$col_id = 'col'.$ctr;
		$coldata = $rowdata[$col_id][0];
		if (!empty($widthdata)){
			$row .= '<td'.$colID.' width="'.$widthdata[$col_id].'">';
		} else {
			$row .= '<td'.$colID.'>';
		}
		$row .= $coldata;
		$row .= "</td>\n";
		$ctr++;
	}
	$row .= "</tr></thead>\n";
	
	array_push($table,$row);
	return $table;
}



function settabheader($table,$rowdata,$headID='tableheader',$widthdata=''){
	$row = "\n<thead><tr>";
	$ctr=1;
	$colID = '';
	if (!empty($headID)){
		$colID = ' class="'.$headID.'"';
	}	
	foreach ($rowdata as $val){
		$col_id = 'col'.$ctr;
		$col_widthID = 'col'.$ctr;
		if (empty($widthdata)){
			$row .= '<td'.$colID.'>';
		} else {
			$row .= '<td'.$colID.' width="'.$widthdata[$col_widthID].'">';
		}
		$row .=  $rowdata[$col_id];
		$row .= "</td>\n";
		$ctr++;
	}
	$row .= "</tr></thead>\n";
	
	array_push($table,$row);
	return $table;
}




function settablefooter($table,$rowdata,$footID=''){
	$row = "\n<tfoot><tr>";
	$ctr=1;
	$colID = '';
	if (!empty($footID)){
		$colID = ' class="'.$footID.'"';
	}	
	foreach ($rowdata as $val){
		$col_id = 'col'.$ctr;
		if (!empty($rowdata[$col_id][1])){
			$coldata = '<a href="'.$rowdata[$col_id][1].'">'.$rowdata[$col_id][0].'</a>';
		} else {
			$coldata = $rowdata[$col_id][0];
		}
		$row .= '<td'.$colID.'>';
		$row .= $coldata;
		$row .= "</td>\n";
		$ctr++;
	}
	$row .= "</tr></tfoot>\n";
	
	array_push($table,$row);
	return $table;
}


function settabfooter($table,$rowdata,$footID=''){
	$row = "\n<tfoot><tr>";
	$ctr=1;
	$colID = '';
	if (!empty($footID)){
		$colID = ' class="'.$footID.'"';
	}	
	foreach ($rowdata as $val){
		$col_id = 'col'.$ctr;
		$row .= '<td'.$colID.'>';
		$row .= $rowdata[$col_id];
		$row .= "</td>\n";
		$ctr++;
	}
	$row .= "</tr></tfoot>\n";
	
	array_push($table,$row);
	return $table;
}



function setstarttablebody($table){
	array_push($table,'<tbody>');
	return $table;
}

function setendtablebody($table){
	array_push($table,'</tbody>');
	return $table;
}



function settablerow($table,$rowdata,$highlightedID=''){
	$row = "\n<tr>";
	$ctr=1;
	$colID = '';
	if (!empty($highlightedID)){
		$colID = ' class="'.$highlightedID.'"';
	}
	foreach ($rowdata as $val){
		$col_id = 'col'.$ctr;
		if (!empty($rowdata[$col_id][1])){
			$coldata = '<a href="'.$rowdata[$col_id][1].'">'.$rowdata[$col_id][0].'</a>';
		} else {
			$coldata = $rowdata[$col_id][0];
		}
		$row .= '<td'.$colID.'>';
		$row .= $coldata;
		$row .= "</td>\n";
		$ctr++;
	}
	$row .= "</tr>\n";
	
	array_push($table,$row);
	return $table;
}



function settabrow($table,$rowdata,$highlightedID=''){
	$row = "\n<tr>";
	$ctr=1;
	$colID = '';
	if (!empty($highlightedID)){
		$colID = ' class="'.$highlightedID.'"';
	}
	foreach ($rowdata as $val){
		$col_id = 'col'.$ctr;
		$row .= '<td'.$colID.'>';
		$row .= $rowdata[$col_id];
		$row .= "</td>\n";
		$ctr++;
	}
	$row .= "</tr>\n";
	
	array_push($table,$row);
	return $table;
}

?>
