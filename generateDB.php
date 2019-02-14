<?php
include('db.php');
if($query=$pdo->prepare("DROP TABLE IF EXISTS class, schedule, user;"))
{
	$query->execute();
}
if($query=$pdo->prepare("CREATE TABLE class (
		id int(11) NOT NULL AUTO_INCREMENT,
		name varchar(255) NOT NULL,
		type int(11) NOT NULL COMMENT 'Type of class: 0 is scheduled class, 1 is extras',
		color varchar(255) NOT NULL,
		PRIMARY KEY (id));")) {
	$query->execute();
}
if($query=$pdo->prepare("CREATE TABLE schedule (
			id int(11) NOT NULL AUTO_INCREMENT,
			schedule varchar(255) NOT NULL COMMENT 'Schedule in array of days',
			type int(11) NOT NULL DEFAULT '1' COMMENT 'Type of schedule: 0 is default, 1 is edited user schedule',
			section_number int(11) NOT NULL,
			PRIMARY KEY(id) );"
			)) {
	$query->execute();
}
if($query=$pdo->prepare("CREATE TABLE user (
			id int(11) NOT NULL AUTO_INCREMENT,
			firstName varchar(255) NOT NULL,
			lastName varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			password varchar(255) NOT NULL,
			hash varchar(255) NOT NULL,
			active tinyint NOT NULL DEFAULT '0',
			schedule_id int(11) NOT NULL DEFAULT '0',
			PRIMARY KEY(id) );"
			)) {
	$query->execute();
}


// ADD HARD CODED DATA INTO DATABASE (TEMP)
if($query=$pdo->prepare("INSERT INTO `class` (
		`name`, `type`, `color`) VALUES
			('Block', '1', '000000'),
			('APSC 172', '0', 'f4425c'),
			('APSC 171', '0', 'ef81df'),
			('APSC 174', '0', 'e27c8b'),
			('APSC 111', '0', 'd89d1c'),
			('APSC 112', '0', 'efb534'),
			('Sleep', '1', 'aa44dd'),
			('Gym', '1', '75d863');"
		)) {
	$query->execute();
}

for ($x = 0; $x <= 18; $x++) {
if($query=$pdo->prepare("INSERT INTO `schedule` (
		`schedule`, `section_number`, `type`) VALUES
			('[[1,1,1,1,1,1],[1,4,5,1,3,1],[1,6,1,4,3,1],[1,3,4,1,6,1],[1,3,4,1,5,1],[1,5,3,1,4,1],[1,1,1,1,1,1]]', '$x', '0');"
		)) {
	$query->execute();
}
}

?>

DONE

see in PHPMyAdmin:
<a href="http://localhost/phpMyAdmin/?lang=en">click here</a>
