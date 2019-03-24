var drake = dragula([
	document.getElementById('schedule'),
	document.getElementById('study-block')], {
		isContainer: function (el) {
			return el.classList.contains('drag-item');
		},
		copy: function (el, source) {
			return source === document.getElementById('study-block');
		},
		accepts: function (el, target, source, siblings) {
			return target.classList.contains('drag-item');
		},
		moves: function(el, container, handle) {
			return container === document.getElementById('study-block');
		}
	}
).on('drag', function(el) {

	if ($selected) {
		$selected.removeClass("glow");
		$selected = null;
	}

	el.classList.add('is-moving');
	$(el).removeClass("glow");
}).on('dragend', function(el) {

	// remove 'is-moving' class from element after dragging has stopped
	$(el).removeClass("is-moving glow original-block");
/*
	// add the 'is-moved' class for 600ms then remove it
	window.setTimeout(function() {
		//el.classList.add('is-moved');
		window.setTimeout(function() {
			el.classList.remove('is-moved');
		}, 600);
	}, 100);
*/
	//getScheduleValues();
}).on('drop', function(el, target) {
	if (target) {
		var i;
		var elements = target.children;
		for (i = 0; i < elements.length; i++) {
			if (!elements[i].classList.contains('gu-transit')){
				$(elements[i]).remove();
			}
		}
	}
}).on('over', function(el, container) {
	$(el).removeClass("glow");
	if (container !== document.getElementById('study-block')) {
		var i;
		var elements = container.children;
		for (i = 0; i < elements.length; i++) {
			$(elements[i]).hide();
		}
	}
}).on('out', function(el, container) {
	if (container !== document.getElementById('study-block')) {
		var i;
		var elements = container.children;
		for (i = 0; i < elements.length; i++) {
			$(elements[i]).show();
		}
	}
});



function getScheduleValues() {
	var dragBoxes;
	var i;
	var id;
	var values = [];
	var dayValues = [];

	for (id = 0; id <= 6; id++) {
		dayValues = [];
		dragBoxes = $("li .schedule-input", "#" + id);
		for (i = 0; i<dragBoxes.length; i++){
			dayValues.push($(dragBoxes[i]).attr('data-schedule'));
		}
		values.push(dayValues);
		dayValues = [];
	}
	return values;	//ABLE TO SAVE THESE VALUES IN DATABASE
}

getScheduleValues();

var $selected;

$(window).on('click touchstart', function(el){
	if($(el.target).hasClass("original-block")){
		if ($selected) {
			$selected.removeClass("glow");
			$selected = null;
		}
		$selected = $(el.target);
		$selected.addClass("glow");
	} else if ($(el.target).hasClass("schedule-input") && $selected) {
		var $parent = $(el.target).parent();
		if ($parent.hasClass("drag-item")) {
			$parent.html($selected.clone());
			$parent.children().removeClass("glow original-block");
			getScheduleValues();
		}
	} else if ($selected) {
		$selected.removeClass("glow");
		$selected = null;
	}
});

$('#save_schedule').click(function(){
	$("#export_alert").remove();
	$("#save_alert").remove();
	var schedule = getScheduleValues();
	$.ajax({
		url: "save_schedule.php",
		type: "POST",
		data: {schedule : schedule},
		success: function (data){
			if (data.error) {
				$('body').append(data.error.msg);
			} else {
				var alertMessage = '<div id="save_alert" class="alert alert-success alert-dismissible fade show" role="alert">Schedule saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				$('#schedule').prepend(alertMessage);
			}
		}
	});
});

$('#export_schedule').click(function(){
	$("#save_alert").remove();
	$("#export_alert").remove();
	var alertMessage = '<div id="save_alert" class="alert alert-success alert-dismissible fade show" role="alert">Schedule exported.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				$('#schedule').prepend(alertMessage);
	window.location.href = "export_schedule.php";
});

$('#discard_changes').click(function(){
	var confirmDiscard = confirm("Are you sure you want to discard all recent changes. There is no way to undo this action. Click cancel to go back and save your changes.");
	if (confirmDiscard){
		document.location.reload(true);
	}
});

$("#new-activity").submit(function(e) {
	e.preventDefault();
	addActivity();
});

function addActivity(){
	var maxLength = 20;
	var inputName = $("#activity-name").val();
	if (inputName != '' && inputName.length < maxLength) {
		$.ajax({
			url: "add_class.php",
			type: "POST",
			data: {activityName : inputName},
			success: function (data) {
				if (data.error) {
					$('body').append(data.error.msg);	//Need better error control
				} else {
					var element = "<div class='schedule-input original-block' style='background-color: #1a5dc9" + data.class.color + ";' data-schedule=" + data.class.id + ">" + data.class.name + "</div>";
					$('#study-block').append(element);
					$("#activity-name").val('');
				}
			}
		});
	} else if (inputName.length >= maxLength) {
		var popover = $('#activity-name')
		popover.popover('enable');
		popover.popover('show');
		popover.popover('disable');
	}
}

// Mobile
document.getElementById('study-block').addEventListener("touchmove", function (e) {
	e.preventDefault();
}, {passive: false});

//document.getElementById('sidebar').addEventListener("touchmove", function () {
	//document.getElementById('schedule').addEventListener("touchstart", function (e) {
		//e.preventDefault();
	//}, {passive: false});
//}, {passive: false});
