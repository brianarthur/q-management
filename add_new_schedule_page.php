<?php

if(!empty($_FILES['file'])){
	print_r($_FILES);
	include("schedule_import.php");
	foreach($_FILES['file']['name'] as $key => $name){
		if($_FILES['file']['error'][$key] == 0 && move_uploaded_file($_FILES['file']['tmp_name'][$key], "files/{$name}") && $_FILES['file']['type'][$key] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
			$uploaded[] = $name;
		} else if ($_FILES['file']['type'][$key] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
			echo "ERROR";
		}
	}
	unset($_FILES);
	foreach ($uploaded as $file) {
		uploadFileToDatabase($file);
	}
	/*
	if(!empty($_POST['ajax'])){
		die(json_encode($uploaded));
	}*/
}

?>
<!DOCTYPE html>
<html>
	<head>
		<style type = "text/css">
			#upload_progress {display: none;}
		</style>
		<title> Schedule Upload </title>
	</head>
	<body>
		<div id = "uploaded">
			<?php
				if(!empty($uploaded)){
					foreach($uploaded as $name){
						echo '<div><a href="'.$name.'">'. $name. '</a></div>';
					}
				}
			?>
		</div>
		<div id="upload_progress"></div>
		<div>
			<form action="" method="post" enctype="multipart/form-data">
				<div>
					<input type="file" id="file" name="file[]" multiple="multiple"/>
					<input type="submit" id = "submit" value="upload"/>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="file_upload.js"></script>
	</body>
</html>
	