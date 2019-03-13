<?php
	// If you need to parse XLS files, include php-excel-reader
	require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');

	require('spreadsheet-reader-master/SpreadsheetReader.php');

	$Reader = new SpreadsheetReader('Section01Timetable.xlsx');
	foreach ($Reader as $Row)
	{
		//print_r($Row);
		$schedule = array(
			array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
			array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
			array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
			array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
			array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
		);
		
	}
?>