<?php
	// If you need to parse XLS files, include php-excel-reader
	require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');

	require('spreadsheet-reader-master/SpreadsheetReader.php');
	$schedule = array(
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
	); 
	$Reader = new SpreadsheetReader('Section01Timetable.xlsx');
	$day=0;
	$timeStart=0;
	$timeEnd=0;
	$length=0;
	$course=0;
	foreach ($Reader as $Row)
	{
		 //print_r($Row);
		if($Row[0] == 'Mon'){
			$day =0;
		}else if($Row[0] == 'Tue'){
			$day = 1;
		}else if($Row[0] == 'Wed'){
			$day = 2;
		}else if($Row[0] == 'Thu'){
			$day = 3;
		}else{
			$day = 4;
		}
		if($Row[1] == '8:30'){
			$timeStart = 1;
		}elseif ($Row[1] == '9:30'){
			$timeStart = 2;
		}elseif ($Row[1] == '10:30'){
			$timeStart = 3;
		}elseif ($Row[1] == '11:30'){
			$timeStart = 4;
		}elseif ($Row[1] == '12:30'){
			$timeStart = 5;
		}elseif ($Row[1] == '1:30'){
			$timeStart = 6;
		}elseif ($Row[1] == '2:30'){
			$timeStart = 7;
		}elseif ($Row[1] == '3:30'){
			$timeStart = 8;
		}elseif ($Row[1] == '4:30'){
			$timeStart = 9;
		}elseif ($Row[1] == '5:30'){
			$timeStart = 10;
		}elseif ($Row[1] == '6:30'){
			$timeStart = 11;
		}elseif ($Row[1] == '7:30'){
			$timeStart = 12;
		}
		if($Row[2] == '9:30'){
			$timeEnd = 2;
		}elseif ($Row[2] == '10:30'){
			$timeEnd = 3;
		}elseif ($Row[2] == '11:30'){
			$timeEnd = 4;
		}elseif ($Row[2] == '12:30'){
			$timeEnd = 5;
		}elseif ($Row[2] == '1:30'){
			$timeEnd = 6;
		}elseif ($Row[2] == '2:30'){
			$timeEnd = 7;
		}elseif ($Row[2] == '3:30'){
			$timeEnd = 8;
		}elseif ($Row[2] == '4:30'){
			$timeEnd = 9;
		}elseif ($Row[2] == '5:30'){
			$timeEnd = 10;
		}elseif ($Row[2] == '6:30'){
			$timeEnd = 11;
		}elseif ($Row[2] == '7:30'){
			$timeEnd = 12;
		}elseif ($Row[2] == '8:30'){
			$timeEnd = 13;
		}
		if($Row[3]== 'APSC 111'){
			$course = 2;
		}elseif($Row[3]== 'APSC 171'){
			$course = 6;
		}elseif($Row[3]== 'APSC 131'){
			$course = 3;
		}elseif($Row[3]== 'APSC 143'){
			$course = 4;
		}elseif($Row[3]== 'APSC 100'){
			if($Row[4]== 'LAB'){
				$course = 8;
			}else{
				$course = 7;
			}
		}elseif($Row[3]== 'APSC 151'){
			$course = 5;
		}
		$schedule [$day][$timeStart] = $course;
		$i = $timeStart;
		while ($i < $timeEnd){
			$schedule[$day][$i] = $course;
			$i++;
		}	

	}
?>