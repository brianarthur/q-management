<?php
  include('./functions.php');

  $class_list = getClasses($_SESSION['id']);
  $schedule = getSchedules($_SESSION['schedule']);

  $constantColour = "1a5dc9";
?>


<div class="schedule-content">
  
<? printSidebar($class_list); ?>

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

<? printSchedule($schedule, $class_list); ?>

  </div>
</div>
