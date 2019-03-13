<?php
  require('./db.php');
  session_start();

  if (isset($_POST['activityName'])) {
    $user_id = $_SESSION['id'];
    $activity_name = $mysqli->escape_string($_POST['activityName']);

    header('Content-Type: application/json');
    try {
      $mysqli->query("INSERT INTO `class` (`name`, `type`, `user_id`, `color`) VALUES ('$activity_name', '1', '$user_id', '')") or die($mysqli->error);

      // Get id of new class
      $result = $mysqli->query("SELECT LAST_INSERT_ID(); ");
      $result = $result->fetch_assoc();
      $class_id = $result['LAST_INSERT_ID()'];
      echo json_encode(array(
        'class' => array(
          'id' => $class_id,
          'name' => $activity_name,
          'color' => '',
        ),
      ));
    } catch (Exception $e) {
      echo json_encode(array(
        'error' => array(
          'msg' => $e->getMessage(),
        ),
      ));
    }
  } else {
    // Accessed page from url -> redirect user to home page
    header('Location: index.php');
  }
?>
