<?php
  $class_list = array();
  $schedule = array();

  if ($query = $pdo->prepare("SELECT * FROM `class`")) {
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

  if ($query = $pdo->prepare("SELECT `schedule` FROM `schedule` WHERE `id` = :id")) {
      $query_array = array(
    		"id"=>$_SESSION['schedule'],
    	);
      $query->execute($query_array);
    	while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    		$schedule = json_decode($result['schedule']);
    	}
    	//print_r($schedule);
    }
  else {
    	$error = $query->errorInfo();
    	echo "My SQL Error: " . $error;
    	return false;
  }
?>
<div id="schedule">
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
    		</ul>
    	</li>


      <?php
        foreach ($schedule as $day_num => $day) {
          echo '<li class="drag-column header2">';
            echo '<span class="drag-column-header">';
              echo '<h2>Day '.$day_num.'</h2>';
            echo '</span>';
            echo '<ul class="drag-inner-list" id="'.$day_num.'">';
              foreach ($day as $schedule_class) {
                foreach ($class_list as $class) {
                  if ($schedule_class == $class['id']) {
                    if ($class['type'] == 1){
                      echo '<li class="drag-item">';
                      echo '<div class="schedule-input" data-schedule="'.$class['id'].'" style="background-color: #'.$class['color'].';">';
                    } elseif ($class['type'] == 0) {
                      echo '<li>';
                      echo '<div class="schedule-input class" data-schedule="'.$class['id'].'" style="background-color: #'.$class['color'].';">';
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

  <div class="">
    <div id="study-block" class="d-flex justify-content-around">
      <?php
        foreach ($class_list as $class) {
          echo "<div class='schedule-input original-block' style='background-color: #".$class['color'].";'";
          echo "data-schedule=".$class['id'].">";
          echo $class['name'];
          echo "</div>";
        }
      ?>
    </div>
  </div>

  <button id="save_schedule" class="btn btn-primary mt-4">SAVE</button>
</div>
