<?php
// only export if button was clicked
if ($_GET['click'] == 'export') {
    header('Content-type: text/calendar');
    header('Content-Disposition: inline; filename=calendar.ics');
    require('./db.php');
    session_start();

    //TODO remove hardcoded values
    $start_date = "20190414";
    $end_date = "20191225";
    $start_hour = 7;
    $start_min = 30;
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
        } else {
            throw new Exception('Error 3 exporting schedule.');
        }

        /** building ics file from schedule **/

        //file header
        echo "BEGIN:VCALENDAR";
        echo "\nPRODID:-//Queens University/q-management//EN";
        echo "\nVERSION:2.0";
        echo "\nCALSCALE:GREGORIAN";
        echo "\nX-WR-CALNAME:calendar";
        echo "\nX-WR-TIMEZONE:America/Toronto";
        echo "\nBEGIN:VTIMEZONE";
        echo "\nTZID:America/Toronto";
        echo "\nTZURL:http://tzurl.org/zoneinfo-outlook/America/Toronto";
        echo "\nX-LIC-LOCATION:America/Toronto";
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
        echo "\nEND:VTIMEZONE";

        //iterate through each day of schedule
        $date = date_create($start_date);
        foreach ($schedule as $day) {
            date_time_set($date, $start_hour, $start_min, 00); // set first schedule block
            //iterate through each hour of day
            foreach ($day as $activity_id) {
                if ($activity_id != 1) { // if not empty time block, create event entry
                    echo "\nBEGIN:VEVENT";
                    echo "\nDTSTART;TZID=America/Toronto:" . date_format($date, "Ymd") . "T" . date_format($date, "His");
                    date_modify($date, '+1 hour'); // add time interval but maintain datetime object
                    echo "\nDTEND;TZID=America/Toronto:" . date_format($date, "Ymd") . "T" . date_format($date, "His");
                    date_modify($date, '-1 hour');
                    echo "\nDTSTAMP:" . date("Ymd") . "T" . date("His") . "Z";  
                    echo "\nUID:" . date("YmdHis") . rand() . "@q-management.com";
                    echo "\nRRULE:FREQ=WEEKLY;UNTIL=" . $end_date . "T000000Z";
                    //echo "\nDESCRIPTION:" . $activity_list[$activity_id]['Teacher']; //TODO add teacher and class location to db
                    //echo "\nLOCATION:" . $activity_list[$activity_id]['Location'];
                    echo "\nSEQUENCE:0";
                    echo "\nSTATUS:CONFIRMED";
                    echo "\nSUMMARY:" . $activity_list[$activity_id]['name'];
                    echo "\nTRANSP:OPAQUE";
                    echo "\nEND:VEVENT";
                }
                date_modify($date, '+1 hour');
            }
            date_time_set($date, 00, 00, 00);
        }
        //file footer
        echo "\nEND:VCALENDAR";

    } catch (Exception $e) {
        echo('error in main');
        echo json_encode(array(
            'error' => array(
                'msg' => $e->getMessage(),
            ),
        ));
    }
} else {
    header('Location: index.php');
}
?>
