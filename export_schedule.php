<?php
  header('Content-type: text/calendar');
  header('Content-Disposition: inline; filename=calendar.ics');
  require('./db.php');
  session_start();

    $start_date = "20190310";
    $start = 730;
    $inc = 100; //1 hour //potential bug lol
	$user_id = $_SESSION['id'];

    try {
      // query schedule id of current user
      $result = $mysqli->query("SELECT `schedule_id` FROM `user` WHERE `id` = '$user_id'") or die($mysqli->error);
      if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $schedule_id = $user['schedule_id'];
      } else {
        throw new Exception('Error 1 exporting schedule.');
      }
      // use schedule id to query full schedule in array format
      $result = $mysqli->query("SELECT `schedule` FROM `schedule` WHERE `id` = '$schedule_id'") or die($mysqli->error);
      if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $schedule = json_decode($user['schedule']);
      } else {
        throw new Exception('Error 2 exporting schedule.');
      }
      // read in all defined activities from class table
      if ($query = $pdo->prepare("SELECT `id`, `name`, `type` FROM `class`")) {
        $query->execute();
        while ($result = $query->fetch(PDO::FETCH_ASSOC)) { //while result is not null,
          // use activity id as index in array
          $activity_list [$result['id']]['name'] = $result['name'];
          $activity_list [$result['id']]['type'] = $result['type'];

        }
        //print_r($activity_list);
      }
      else {
        //$error = $query->errorInfo();
        //echo "My SQL Error: " . $error;
        throw new Exception('Error 3 exporting schedule.');
      }
      echo "BEGIN:VCALENDAR";
      echo "\nPRODID:-//Queens University/q-management//EN";
      echo "\nVERSION:2.0";
      echo "\nCALSCALE:GREGORIAN";
      echo "\nX-WR-CALNAME:calendar";
      echo "\nX-WR-TIMEZONE:America/Toronto";
      /*echo "\nBEGIN:VTIMEZONE";
      echo "\nTZID:America/New_York";
      echo "\nTZURL:http://tzurl.org/zoneinfo-outlook/America/New_York";
      echo "\nX-LIC-LOCATION:America/New_York";
      echo "\nBEGIN:DAYLIGHT";
      echo "\nTZOFFSETFROM:-0500";
      echo "\nTZOFFSETTO:-0400";
      echo "\nTZNAME:EDT";
      echo "\nDTSTART:19700308T020000";
      echo "\nRRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU";
      echo "\nEND:DAYLIGHT";
      echo "\nBEGIN:STANDARD";
      echo "\nTZOFFSETFROM:-0400";
      echo "\nTZOFFSETTO:-0500";
      echo "\nTZNAME:EST";
      echo "\nDTSTART:19701101T020000";
      echo "\nRRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU";
      echo "\nEND:STANDARD";
      echo "\nEND:VTIMEZONE";*/

      $date = date_create($start_date);
      foreach ( $schedule as $day){
        $hour = 0;
        foreach ($day as $id){
          if ($id != 1){
            echo "\nBEGIN:VEVENT";
            echo "\nDTSTART:". date_format($date, "Ymd") ."T" . ($start+$hour*$inc). "00Z";
            echo "\nDTEND:" . date_format($date, "Ymd") ."T" . ($start+$hour*$inc + 100) . "00Z"; //sus af
            echo "\nDTSTAMP:".date("Ymd")."T".date("His")."Z";
            echo "\nUID:".date("YmdHis").$hour."@q-management.com";
            echo "\nCREATED:".date("Ymd")."T".date("His")."Z";
            //echo "\nDESCRIPTION:".$activity_list[$id]['Teacher'];
            //echo "\nLOCATION:".$activity_list[$id]['Location'];
            echo "\nSEQUENCE:0";
            echo "\nSTATUS:CONFIRMED";
            echo "\nSUMMARY:".$activity_list[$id]['name'];
            echo "\nTRANSP:OPAQUE";
            echo "\nEND:VEVENT";
          }
          $hour++;
        }
        date_add($date, new DateInterval('P1D'));
      }
      echo "\nEND:VCALENDAR";
    } catch (Exception $e) {
        echo ('error in main');
        echo json_encode(array(
            'error' => array(
                'msg' => $e->getMessage(),
            ),
        ));
    }
?>
