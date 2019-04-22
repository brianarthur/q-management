<?php
require_once('./db.php');

if(!empty($_POST['method'])) {
  if ($_POST['method'] == "printSchedule") {
    $schedule = getSchedules($_POST['section']);
    $classes = getClasses(0);
    printSchedule($schedule, $classes);
  }
  elseif ($_POST['method'] == "startDate" || $_POST['method'] == "endDate") {
    $date = strtotime($_POST['date']);
    $json = file_get_contents("config.json");
    $config = json_decode($json, true);
    $config[$_POST['method']] = date('Ymd', $date);
    file_put_contents("config.json", json_encode($config));
  }
}

function getClasses($user_id) {
  global $pdo;
  $class_list = array();

  if ($query = $pdo->prepare("SELECT * FROM `class` WHERE `user_id` = '0' OR `user_id` = '$user_id'")) {
      $query->execute();
      $counter=0;
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
          $class_list [$counter]['id'] = $result['id'];
          $class_list [$counter]['name'] = $result['name'];
          $class_list [$counter]['type'] = $result['type'];
          $class_list [$counter]['color'] = $result['color'];
          $counter++;
      }
      // print_r($class_list);
      return $class_list;
  }
  else {
      $error = $query->errorInfo();
      echo "My SQL Error: " . $error;
      return false;
  }
}

function getSchedules($schedule_id) {
  global $pdo;
  $schedule = array();

  if ($query = $pdo->prepare("SELECT `schedule` FROM `schedule` WHERE `id` = $schedule_id")) {
      $query->execute();
    	while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    		$schedule = json_decode($result['schedule']);
    	}
    	//print_r($schedule);
      return $schedule;
    }
  else {
    	$error = $query->errorInfo();
    	echo "My SQL Error: " . $error;
    	return false;
  }
}

function getScheduleSections() {
  global $pdo;
  $schedules = array();

  if ($query = $pdo->prepare("SELECT * FROM `schedule` WHERE `type` = '0' ORDER BY `section_number` ASC")) {
      $query->execute();
      $counter = 0;
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
        $schedules[$counter]['id'] = $result['id'];
        $schedules[$counter]['section_number'] = $result['section_number'];
        $counter++;
      }
      return $schedules;
  }
  else {
      $error = $query->errorInfo();
      echo "My SQL Error: " . $error;
      return false;
  }
}

function printSidebar($classes) {
  echo "<div id='sidebar' class='sidebar'>";
    echo "<div class='class-list'>";
      echo "<div class='sidebar-header'>";
        echo "<h3>Activity</h3>";
      echo "</div>";
      echo "<div id='study-block'>";
        foreach ($classes as $class) {
          if ($class['type'] == '1') {
            echo "<div class='schedule-input original-block' style='background-color: #";
              if ($class['color']) {
                echo $class['color'];
              } else {
                echo $constantColour;
              }
              echo ";' data-schedule=".$class['id'].">";
              echo $class['name'];
            echo "</div>\n";
          }
        }
      echo "</div>";
    echo "</div>";

    echo "<div class='class-stats'>";
      echo "<div class='sidebar-header'>";
        echo "<h3>Recommended Hours Remaining</h3>";
      echo "</div>";
      echo "<div id='statistics'>";
        echo "<div class='schedule-input' style='opacity: 0;'></div>";
        echo "<div class='schedule-input' ><p id='hourCount0'>0</p></div>";
        echo "<div class='schedule-input' ><p id='hourCount1'>0</p></div>";
        echo "<div class='schedule-input'><p id='hourCount2'>0</p></div>";
        echo "<div class='schedule-input'><p id='hourCount3'>0</p></div>";
        echo "<div class='schedule-input'><p id='hourCount4'>0</p></div>";
        echo "<div class='schedule-input'><p id='hourCount5'>0</p></div>";
        echo "<div class='schedule-input'><p id='hourCount6'>0</p></div>";
      echo "</div>";
    echo "</div>";
  echo "</div>";
}

function printSchedule($schedule, $classes) {
  echo '<div class="drag-container">';
      echo '<ul class="drag-list">';
      	echo '<li class="drag-column header1">';
      		echo '<span class="drag-column-header">';
      			echo '<h2>Times</h2>';
      		echo '</span>';
      		echo '<ul class="times">';
      			echo '<li class="schedule-input">7:30</li>';
      			echo '<li class="schedule-input">8:30</li>';
      			echo '<li class="schedule-input">9:30</li>';
      			echo '<li class="schedule-input">10:30</li>';
      			echo '<li class="schedule-input">11:30</li>';
      			echo '<li class="schedule-input">12:30</li>';
            echo '<li class="schedule-input">1:30</li>';
      			echo '<li class="schedule-input">2:30</li>';
      			echo '<li class="schedule-input">3:30</li>';
      			echo '<li class="schedule-input">5:30</li>';
            echo '<li class="schedule-input">4:30</li>';
      			echo '<li class="schedule-input">6:30</li>';
            echo '<li class="schedule-input">7:30</li>';
      			echo '<li class="schedule-input">8:30</li>';
      			echo '<li class="schedule-input">9:30</li>';
      			echo '<li class="schedule-input">10:30</li>';
      			echo '<li class="schedule-input">12:30</li>';
            echo '<li class="schedule-input">11:30</li>';
      		echo '</ul>';
      	echo '</li>';

        $weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        foreach ($schedule as $day_num => $day) {
          echo '<li class="drag-column header2">';
            echo '<span class="drag-column-header">';
              echo '<h2>'.$weekdays[$day_num].'</h2>';
            echo '</span>';
            echo '<ul class="drag-inner-list" id="'.$day_num.'">';
              foreach ($day as $schedule_class) {
                foreach ($classes as $class) {
                  if ($schedule_class == $class['id']) {
                    if ($class['type'] == 1){
                      echo '<li class="drag-item">';
                    } elseif ($class['type'] == 0) {
                      echo '<li class="class">';
                    }
                      echo '<div class="schedule-input" data-schedule="'.$class['id'].'" style="background-color: #';
                        if ($class['color']) {
                          echo $class['color'];
                        } else {
                          echo $constantColour;
                        }
                        echo ';">';
                        echo $class['name'];
                      echo '</div>';
                    echo '</li>';
                    break;
                  }
                }
              }
            echo '</ul>';
          echo '</li>';
        }
      echo '</ul>';
    echo '</div>';
}
?>
