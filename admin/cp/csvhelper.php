<?php
//Get the result of the query as a CSV stream.
//http://www.bin-co.com/php/scripts/csv_import_export/
function CSVExport($filename,$query) {
    	$sql_csv = mysql_query($query, CONNECTION) or die("Error: " . mysql_error()); 
	//Replace this line with what is appropriate for your DB abstraction layer
    
    	header("Content-type:text/octect-stream");
    	header("Content-Disposition:attachment;filename=".strtolower(trim($filename)).".csv");
    	while($row = mysql_fetch_row($sql_csv)) {
        	print '"' . stripslashes(implode('","',$row)) . "\"\n";
	}
    	exit;
}

//Import the contents of a CSV file after uploading it
//http://www.bin-co.com/php/scripts/csv_import_export/
//Aruguments : $table - The name of the table the data must be imported to
//                $fields - An array of fields that will be used
//                $csv_fieldname - The name of the CSV file field
function CSVImport($table, $fields, $csv_fieldname='csv') {
	print $_FILES[$csv_fieldname]['name'];
	if(!$_FILES[$csv_fieldname]['name']) return;
	
	$handle = fopen($_FILES[$csv_fieldname]['tmp_name'],'r');
	if(!$handle) die('Cannot open uploaded file.');
	
	$row_count = 0;
	$sql_query = "INSERT INTO $table(". implode(',',$fields) .") VALUES(";
	
	$rows = array();

	//Read the file as csv
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$row_count++;
		foreach($data as $key=>$value) {
			$data[$key] = "'" . addslashes($value) . "'";
		}
		$rows[] = implode(",",$data);
	}
	$sql_query .= implode("),(", $rows);
	$sql_query .= ")";
	fclose($handle);

    	if(count($rows)) { //If some recores  were found,
		//Replace these line with what is appropriate for your DB abstraction layer
		mysql_query("TRUNCATE TABLE $table") or die("MySQL Error: " . mysql_error()); //Delete the existing records
		mysql_query($sql_query) or die("MySQL Error: " . mysql_error()); // and insert the new ones.
	
		print 'Successfully imported '.$row_count.' record(s)';
	} else {
		print 'Cannot import data - no records found.';
	}
} 