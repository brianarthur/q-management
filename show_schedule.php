<?php
  $class_list = array();
  $schedule = array();

  $user_id = $_SESSION['id'];

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
  }
  else {
      $error = $query->errorInfo();
      echo "My SQL Error: " . $error;
      return false;
  }

  if ($query = $pdo->prepare("SELECT `schedule`, `section_number` FROM `schedule` WHERE `id` = :id")) {
      $query_array = array(
    		"id"=>$_SESSION['schedule'],
    	);
      $query->execute($query_array);
    	while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    		$schedule = json_decode($result['schedule']);
        $schedule_section = $result['section_number'];
    	}
    	//print_r($schedule);
    }
  else {
    	$error = $query->errorInfo();
    	echo "My SQL Error: " . $error;
    	return false;
  }
  $constantColour = "1a5dc9";
?>
<div class="schedule-content">
  <div id="sidebar" class="sidebar">
    <div class="class-list">
      <div class="sidebar-header">
        <h3>Activity</h3>
      </div>
      <div id="study-block">
        <?php
          foreach ($class_list as $class) {
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
        ?>
      </div>
    </div>

    <div class="class-stats">
      <div class="sidebar-header">
        <h3>Recommended Hours Remaining</h3>
      </div>
      <div id="statistics">
        <div class='schedule-input' style="opacity: 0;"></div>
        <div class='schedule-input' ><p id="hourCount0">0</p></div>
        <div class='schedule-input' ><p id="hourCount1">0</p></div>
        <div class='schedule-input'><p id="hourCount2">0</p></div>
        <div class='schedule-input'><p id="hourCount3">0</p></div>
        <div class='schedule-input'><p id="hourCount4">0</p></div>
        <div class='schedule-input'><p id="hourCount5">0</p></div>
        <div class='schedule-input'><p id="hourCount6">0</p></div>
      </div>
    </div>
  </div>


  <div id="schedule">
    <div id='schedule-menu' class="mb-4">
      <form id="new-activity">
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">Create new activity</div>
          </div>
          <input id="activity-name" class="form-control" type="text" placeholder="New activity name" name="activity-name" autocomplete="off" required data-toggle="popover" data-placement="top" data-trigger="focus" data-content="Exceeds max length.">
          <div class="input-group-append">
            <button id="add-activity" class="btn btn-sm btn-info">+</button>
          </div>
        </div>
      </form>
      <div class="btn-group">
        <button id="save_schedule" class="btn btn-outline-primary">SAVE</button>
        <button id="export_schedule" class="btn btn-outline-info">EXPORT</button>
        <button id="discard_changes" class="btn btn-outline-danger">DISCARD</button>
      </div>
    </div>

    <div class="drag-container">
      <ul class="drag-list">
      	<li class="drag-column header1">
      		<span class="drag-column-header">
      			<h2>Times</h2>
      		</span>
      		<ul class="times">
      			<li class="schedule-input">7:30</li>
      			<li class="schedule-input">8:30</li>
      			<li class="schedule-input">9:30</li>
      			<li class="schedule-input">10:30</li>
      			<li class="schedule-input">11:30</li>
      			<li class="schedule-input">12:30</li>
            <li class="schedule-input">1:30</li>
      			<li class="schedule-input">2:30</li>
      			<li class="schedule-input">3:30</li>
      			<li class="schedule-input">4:30</li>
      			<li class="schedule-input">5:30</li>
      			<li class="schedule-input">6:30</li>
            <li class="schedule-input">7:30</li>
      			<li class="schedule-input">8:30</li>
      			<li class="schedule-input">9:30</li>
      			<li class="schedule-input">10:30</li>
      			<li class="schedule-input">11:30</li>
      			<li class="schedule-input">12:30</li>
      		</ul>
      	</li>
        <?php
          $weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
          foreach ($schedule as $day_num => $day) {
            echo '<li class="drag-column header2">';
              echo '<span class="drag-column-header">';
                echo '<h2>'.$weekdays[$day_num].'</h2>';
              echo '</span>';
              echo '<ul class="drag-inner-list" id="'.$day_num.'">';
                foreach ($day as $schedule_class) {
                  foreach ($class_list as $class) {
                    if ($schedule_class == $class['id']) {
                      if ($class['type'] == 1){
                        echo '<li class="drag-item">';
                        echo '<div class="schedule-input" data-schedule="'.$class['id'].'" style="background-color: #';
                        if ($class['color']) {
                          echo $class['color'];
                        } else {
                          echo $constantColour;
                        }
                        echo ';">';
                      } elseif ($class['type'] == 0) {
                        echo '<li class="class">';
                        echo '<div class="schedule-input" data-schedule="'.$class['id'].'" style="background-color: #'.$class['color'].';">';
                      }
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
        ?>
      </ul>
    </div>
  </div>
</div>
