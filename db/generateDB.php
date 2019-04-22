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
		recommended_hours int(11) NULL,
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
			user_type int(11) NOT NULL DEFAULT '2' COMMENT 'Type of user: 1 is admin user, 2 is student user',
			PRIMARY KEY(id) );"
			)) {
	$query->execute();
}


// ADD HARD CODED DATA INTO DATABASE (TEMP)
if($query=$pdo->prepare("INSERT INTO `class` (
		`name`, `type`, `user_id`, `recommended_hours`, `color`) VALUES
			('Block', '1', '0', NULL, '000000'),
			('APSC 111', '0', '0', NULL, 'f4425c'),
			('APSC 131', '0', '0', NULL, 'e27c8b'),
			('APSC 143', '0', '0', NULL, 'efb534'),
			('APSC 151', '0', '0', NULL, 'd89d1c'),
			('APSC 171', '0', '0', NULL, 'bff92a'),
			('APSC 100-A', '0', '0', NULL, '59ce1e'),
			('APSC 100-B', '0', '0', NULL, '1ece73'),
			('APSC 111', '1', '0', '5', 'f4425c'),
			('APSC 131', '1', '0', '3', 'e27c8b'),
			('APSC 143', '1', '0', '3', 'efb534'),
			('APSC 151', '1', '0', '2', 'd89d1c'),
			('APSC 171', '1', '0', '5', 'bff92a'),
			('APSC 100-A', '1', '0', '4', '59ce1e'),
			('APSC 100-B', '1', '0', '2', '1ece73'),
			('Sleep', '1', '0', NULL, 'aa44dd'),
			('Meal Time', '1', '0', NULL, 'da9fb3'),
			('Morning Prep', '1', '0', NULL, 'a8a8e8');"
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

$admin_password = "$2y$10\$WM2qAtV53n8yaWdXeXE9I.c4Qt6M9caTbC5HWitnT1a8WVj7g0Lbm";
if($query=$pdo->prepare("INSERT INTO `user` (
		`firstName`, `lastName`, `email`, `password`, `hash`, `active`, `schedule_id`, `user_type`) VALUES
			('Admin', 'Admin', 'admin@queensu.ca', '$admin_password', '', '1', '0', '1');"
		)) {
	$query->execute();
}

?>

DONE

see in PHPMyAdmin:
<a href="http://localhost/phpMyAdmin/?lang=en">click here</a>
