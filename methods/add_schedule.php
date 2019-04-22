<?php

require('../db/db.php');
session_start();

if (isset($_GET['s'])) {
  // ID of logged in user
  $user_id = $_SESSION['id'];

  // GET schedule of the selected base schedule
  $schedule_id = $mysqli->escape_string($_GET['s']);
  $result = $mysqli->query("SELECT * FROM schedule WHERE id = '$schedule_id'") or die($mysqli->error);
  $schedule = $result->fetch_assoc();
  $schedule_base = $schedule['schedule'];
  $schedule_section = $schedule['section_number'];

  // Create a new editable schedule copied from base schedule
  $result = $mysqli->query("INSERT INTO `schedule` (`schedule`, `section_number`) VALUES ('$schedule_base', '$schedule_section')") or die($mysqli->error);

  // Get ID of the created schedule
  $result = $mysqli->query("SELECT LAST_INSERT_ID(); ");
  $result = $result->fetch_assoc();
  $schedule_id = $result['LAST_INSERT_ID()'];
  $_SESSION['schedule'] = $schedule_id;

  // Update the schedule id for the user in the database
  $result = $mysqli->query("UPDATE `user` SET `schedule_id` = '$schedule_id' WHERE `user`.`id` = '$user_id'") or die($mysqli->error);
  header("Location: ../index.php");
} else {
  // Redirect to index page, didn't set the schedule id
  header("Location: ../index.php");
}


?>
