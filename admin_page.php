<div class="title">
  <div class="container">
    <h1> Settings </h1>
  </div>
  <hr>
</div>

<div id="content" class="container">
  <div class="row">
    <div class="col-2">
      <div class="nav flex-column nav-pills" id="settingsTabs" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="upload-schedules-tab" data-toggle="pill" href="#upload-schedules" role="tab" aria-controls="upload-schedules" aria-selected="true">Upload Schedules</a>
        <a class="nav-link" id="views-schedules-tab" data-toggle="pill" href="#views-schedules" role="tab" aria-controls="views-schedules" aria-selected="false">View Schedules</a>
        <a class="nav-link" id="classes-page-tab" data-toggle="pill" href="#classes-page" role="tab" aria-controls="classes-page" aria-selected="false">View Classes</a>
      </div>
    </div>
    <div class="col-10">
      <div class="tab-content" id="settingsContent">
        <div class="tab-pane fade show active" id="upload-schedules" role="tabpanel" aria-labelledby="upload-schedules-tab">
          <div id="upload-new-schedules" class="mb-4">
            <h2>Upload New Schedule Files</h2>
            <div class="jumbotron" style="padding: 2rem 1rem !important;">
              <div class="alert alert-warning" role="alert">
                <b>Warning!</b> Uploading new section schedules will remove previous section templates.
              </div>
              <div>Schedule files must have the following naming convention: <b>'SectionXXTimetable.xlsx'</b> where XX is the section number.</div>
              <div>Files must be Excel type files with extension 'xlsx'.</div>
            </div>
            <div class="mt-4">
            	<form id="upload_schedules">
            		<div class="form-row">
            			<div class="form-group col">
            	    	<input type="file" id="schedule_files" name="file[]" multiple class="form-control-file">
            			</div>
            			<div class="form-group col-auto align-self-end">
            				<input id="upload_button" type="submit" class="btn btn-primary btn-sm" value="Upload">
            			</div>
            	  </div>
            	</form>
            </div>
            <div id="upload_message" class="mb-4">
              <?php
                if (!empty($_GET['uploaded'])) {
                  echo "<p class='text-success'>Schedules succesfully uploaded.</p>";
                }
              ?>
            </div>
          </div>
          <hr>
          <div id="semester-dates" class="mt-4">
            <h2 class="mt-4">Set Semester Start and End Dates</h2>
            <?php
              $json = file_get_contents("config.json");
              $config = json_decode($json, true);
              $start = date('Y-m-d', strtotime($config['startDate']));
              $end = date('Y-m-d', strtotime($config['endDate']));
              echo "<div class='form-row mt-3'>";
                echo "<div class='col-2'>";
                  echo "<label for='start' class='mt-1'>Start Date: </label>";
                echo "</div>";
                echo "<div class='col-5'>";
                  echo "<input id='start' class='form-control' type='date' value='$start'>";
                echo "</div>";
              echo "</div>";
              echo "<div class='form-row mt-3'>";
                echo "<div class='col-2'>";
                  echo "<label for='end' class='mt-1'>End Date: </label>";
                echo "</div>";
                echo "<div class='col-5'>";
                  echo "<input id='end' class='form-control' type='date' value='$end'>";
                echo "</div>";
              echo "</div>";
            ?>
            <div id="changeDateMessage" class="mt-4"></div>
          </div>
        </div>
        <div class="tab-pane fade" id="views-schedules" role="tabpanel" aria-labelledby="views-schedules-tab">
          <h2>View Schedules</h2>
          <?php
            $schedule = getScheduleSections();
            echo "<select id='select-section'>";
            foreach ($schedule as $section) {
              echo "<option value='".$section['id']."'>Section ".$section['section_number']."</option>";
            }
            echo "</select>";
            $classes = getClasses(0);
            $schedule = getSchedules($schedule[0]['id']);
            echo "<div id='active_schedules' class='mt-4 mb-4'>";
              printSchedule($schedule, $classes);
            echo "</div>"
          ?>
        </div>
        <div class="tab-pane fade" id="classes-page" role="tabpanel" aria-labelledby="classes-page-tab">
          <h2>View Classes</h2>
          <table class="table mb-4">
            <thead class="thead-light">
              <tr>
                <th>Class Name</th>
                <th>Recommended Hours</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $classes = getClasses(0);
                foreach ($classes as $class) {
                  if ($class['type'] == 1 && $class['id'] != 1) {
                    echo "<tr data-class='".$class['id']."'>";
                      echo "<td>".$class['name']."</td>";
                      echo "<td><input class='update-hours form-control' type='number' min='0' max='24' value='".$class['hours']."'></td>";
                    echo "</tr>";
                  }
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
