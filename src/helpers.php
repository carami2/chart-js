<?php

/**
 * openCSV
 *
 * returns array from any certain csv file
 *
 * @param (file) ($file)
 * @return (array) ($result)
 */
function openCSV($file) {
    $result = array();

	if (($handle = fopen($file, "r")) !== FALSE) {

	    $column_headers = fgetcsv($handle); // read the row.
	    foreach($column_headers as $header) {
	        $result[$header] = array();
	    }

	    while (($data = fgetcsv($handle)) !== FALSE ) {
	        $i = 0;
		    foreach($result as &$column) {
		    	if($i == 0)
	            	$column[] = $data[$i++];
	            else
	            	$column[] = str_replace(',', '', $data[$i++]);
		    }

	    }
	    fclose($handle);
	}

	return $result;
}
?>