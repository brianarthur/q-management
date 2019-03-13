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
		user_id int(11) NOT NULL DEFAULT '0' COMMENT 'Linked to user table, 0 is a global class',
		color varchar(255) NOT NULL,
		PRIMARY KEY (id));")) {
	$query->execute();
}
if($query=$pdo->prepare("CREATE TABLE schedule (
			id int(11) NOT NULL AUTO_INCREMENT,
			schedule varchar(1027) NOT NULL COMMENT 'Schedule in array of days',
			type int(11) NOT NULL DEFAULT '1' COMMENT 'Type of schedule: 0 is original schedule, 1 is edited user schedule',
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
		`name`, `type`, `user_id`, `color`) VALUES
			('Block', '1', '0', '000000'),
			('APSC 111', '0', '0', 'f4425c'),
			('APSC 131', '0', '0', 'ef81df'),
			('APSC 143', '0', '0', 'e27c8b'),
			('APSC 151', '0', '0', 'd89d1c'),
			('APSC 171', '0', '0', 'efb534'),
			('APSC 100-A', '0', '0', 'efb534'),
			('APSC 100-B', '0', '0', 'efb534'),
			('Sleep', '1', '0', 'aa44dd'),
			('Gym', '1', '0', '75d863'),
			('APSC 171', '1', '0', '123eff'),
			('APSC 172', '1', '0', '1278ac');"
		)) {
	$query->execute();
}

for ($x = 0; $x <= 18; $x++) {
if($query=$pdo->prepare("INSERT INTO `schedule` (
		`schedule`, `section_number`, `type`) VALUES
			('[[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1],[1,4,1,1,1,2,3,1,1,2,5,1,7,1,1,1,1,1],[1,1,1,1,6,6,1,3,4,1,1,1,1,1,1,1,1,1],[1,8,8,8,1,1,1,7,2,5,1,1,1,1,1,1,1,1],[1,5,5,1,6,1,1,3,4,4,1,1,1,1,1,1,1,1],[1,1,1,1,1,1,6,2,5,3,1,1,1,1,1,1,1,1],[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]]', '$x', '0');"
		)) {
	$query->execute();
}
}

?>

DONE

see in PHPMyAdmin:
<a href="http://localhost/phpMyAdmin/?lang=en">click here</a>
