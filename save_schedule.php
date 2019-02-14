<?php
  require('./db.php');
  session_start();

  if (isset($_POST['schedule'])) {
    $user_id = $_SESSION['id'];
    $schedule = json_encode($_POST['schedule']);

    header('Content-Type: application/json');
    try {
      $result = $mysqli->query("SELECT `schedule_id` FROM `user` WHERE `id` = '$user_id'") or die($mysqli->error);
      if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $schedule_id = $user['schedule_id'];
        $mysqli->query("UPDATE `schedule` SET `schedule`='$schedule' WHERE id = '$schedule_id'") or die($mysqli->error);
      } else {
        throw new Exception('Error saving new schedule.');
      }
    } catch (Exception $e) {
      echo json_encode(array(
        'error' => array(
          'msg' => $e->getMessage(),
        ),
      ));
    }
  } else {
    // Accessed page from url -> redirect user to home ldap_control_paged_result
    header('Location: index.php');
  }
?>
