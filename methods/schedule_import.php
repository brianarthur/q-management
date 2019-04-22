<?php

require('../db/db.php');

if(!empty($_FILES['file'])){
	//print_r($_FILES);
	foreach($_FILES['file']['name'] as $key => $name){
		if($_FILES['file']['error'][$key] == 0 && move_uploaded_file($_FILES['file']['tmp_name'][$key], "../uploads/{$name}")) {
			$uploaded[] = $name;
		}
	}
	foreach ($uploaded as $file) {
		uploadFileToDatabase($file);
	}
	header('Content-Type: application/json');
	echo json_encode(array(
		'success' => true));
}

function uploadFileToDatabase($file){
	global $mysqli, $pdo;
	// HARD CODED TO THIS FILE NAME TYPE
	$section = $file[7].$file[8];

	$mysqli->query("DELETE FROM `schedule` WHERE `type` = '0' AND `section_number` = $section") or die($mysqli->error);

	$classes = array();
	if ($query = $pdo->prepare("SELECT `id`, `name` FROM `class` WHERE `type` = '0'")) {
			$query->execute();
			$counter = 0;
			while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
				$classes[$counter]['id'] = $result['id'];
				$classes[$counter]['name'] = $result['name'];
				$counter++;
			}
			//print_r($classes);
	}
	else {
			$error = $query->errorInfo();
			echo "My SQL Error: " . $error;
			return false;
	}


	// If you need to parse XLS files, include php-excel-reader
	require('../spreadsheet-reader/php-excel-reader/excel_reader2.php');
	require('../spreadsheet-reader/SpreadsheetReader.php');

	$schedule = array(
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
		array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),
	);

	$file = '../uploads/'.$file;
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	if ($ext != "xlsx") {
		throw new Exception("Invalid file type.");
	}

	$Reader = new SpreadsheetReader($file);
	$day=0;
	$timeStart=0;
	$timeEnd=0;
	$length=0;
	$course=0;
	foreach ($Reader as $num => $Row)
	{
		if ($num != 0) {
			if($Row[0] == 'Mon'){
				$day = 1;
			}else if($Row[0] == 'Tue'){
				$day = 2;
			}else if($Row[0] == 'Wed'){
				$day = 3;
			}else if($Row[0] == 'Thu'){
				$day = 4;
			}else if($Row[0] == 'Fri'){
				$day = 5;
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
			}elseif ($Row[1] == '8:30'){
				$timeStart = 13;
			}elseif ($Row[1] == '9:30'){
				$timeStart = 14;
			}elseif ($Row[1] == '10:30'){
				$timeStart = 15;
			}elseif ($Row[1] == '11:30'){
				$timeStart = 16;
			}

			if ($Row[2] == '9:30'){
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
			}elseif ($Row[2] == '9:30'){
				$timeEnd = 14;
			}elseif ($Row[2] == '10:30'){
				$timeEnd = 15;
			}elseif ($Row[2] == '11:30'){
				$timeEnd = 16;
			}elseif ($Row[2] == '12:30'){
				$timeEnd = 17;
			}

			if ($Row[3] == 'APSC 100' && $Row[4] == 'LAB') { $name = "APSC 100-B"; }
			elseif ($Row[3] == 'APSC 100' && ($Row[4] == 'LECT' || $Row[4] == 'STUDIO')) { $name = "APSC 100-A"; }
			else { $name = $Row[3]; }

			if ($name) {
				$course = 0;
				foreach ($classes as $class) {
					if ($class['name'] == $name) {
						$course = $class['id'];
					}
				}
				if ($course == 0) {
					$course = addCourseName($name);
				}

				$schedule [$day][$timeStart] = $course;
				$i = $timeStart;
				while ($i < $timeEnd) {
					$schedule[$day][$i] = $course;
					$i++;
				}
			}
		}
	}
	$jsonSchedule = json_encode($schedule);
		if($query=$pdo->prepare("INSERT INTO `schedule` (
			`schedule`, `section_number`, `type`) VALUES
			('$jsonSchedule', '$section', '0');"
			)) {
			$query->execute();
		}
}

function addCourseName ($name) {
	global $mysqli;
	$mysqli->query("INSERT INTO `class` (`name`, `type`, `user_id`, `color`) VALUES ('$name', '0', '0', '');");

	$result = $mysqli->query("SELECT LAST_INSERT_ID();");
	$result = $result->fetch_assoc();
	$id = $result['LAST_INSERT_ID()'];

	$mysqli->query("INSERT INTO `class` (`name`, `type`, `user_id`, `color`) VALUES ('$name', '1', '0', '');");

	return $id;
}
?>
