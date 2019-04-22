$('#upload_schedules').submit(function (e) {
	console.log('hello');
	e.preventDefault();
	e.stopPropagation();
	var formData = new FormData();
	for (var i = 0; i <= $("#schedule_files")[0].files.length; i++) {
		formData.append('file[]', $('#schedule_files')[0].files[i]);
	}
	$('#upload_message').html("");
	$.ajax({
		url: "schedule_import.php",
		type: "POST",
		data : formData,
		processData: false,
		contentType: false,
		success : function(data) {
			if (data['success']) {
				window.location.href = "index.php?uploaded=true";
			} else {
				$('#upload_message').html("<p class='text-danger'>Schedules failed to upload.</p>");
			}
		},
		error : function() {
			$('#upload_message').html("<p class='text-danger'>Schedules failed to upload.</p>");
		}
	});
});

$('#select-section').on('change', function () {
	var section = $(this).children("option:selected").val();
	$("#active_schedules").html("");
	$.ajax({
		url: "functions.php",
		type: "POST",
		data : {method: "printSchedule", section: section},
		success : function(data) {
			$("#active_schedules").html(data);
		},
		error : function() {
			$("#active_schedules").html("<p class='text-danger'>Error occured showing the schedule.</p>");
		}
	});
});

var previousStartDate, previousEndDate;

$(document).ready(function() {
	previousStartDate = $('#start').val();
	previousEndDate = $('#end').val();
});

$('#start').on('change', () => changeDate("startDate"));
$('#end').on('change', () => changeDate("endDate"));

function changeDate (method) {
	$("#changeDateMessage").html("");
	var startDate = $('#start').val();
	var endDate = $('#end').val();
	var check = checkDates(startDate, endDate);
	if (method == "startDate" && startDate && check) {
		previousStartDate = startDate;
		saveSemesterDate(startDate, "startDate");
	} else if (method == "endDate" && endDate && check) {
		previousEndDate = endDate;
		saveSemesterDate(endDate, "endDate");
	} else if (!check) {
		if (method == "startDate") {
			$('#start').val(previousStartDate);
		} else if (method == "startDate") {
			$('#end').val(previousEndDate);
		}
		$("#changeDateMessage").html("<p class='text-danger'>Start date must be less than the end date.</p>");
	}
}

function checkDates (startDate, endDate) {
	var valid = true;
	if (startDate && endDate) {
		if (startDate >= endDate) {
			valid = false;
		}
	}
	return valid;
}

function saveSemesterDate (date, method) {
	$.ajax({
		url: "functions.php",
		type: "POST",
		data : {method: method, date: date},
		success : function(data) {
			$("#changeDateMessage").html("<p class='text-success'>Updated semester dates.</p>");
		},
	});
}
