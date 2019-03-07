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
)

.on('drag', function(el) {

	if ($selected) {
		$selected.removeClass("glow");
		$selected = null;
	}

	// add 'is-moving' class to element being dragged
	el.classList.add('is-moving');
	$(el).removeClass("glow");
})
.on('dragend', function(el) {

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
})
.on('drop', function(el, target) {
	if (target) {
		var i;
		var elements = target.children;
		for (i = 0; i < elements.length; i++) {
			if (!elements[i].classList.contains('gu-transit')){
				$(elements[i]).remove();
			}
		}
	}
})
.on('over', function(el, container) {
	$(el).removeClass("glow");
	if (container !== document.getElementById('study-block')) {
		var i;
		var elements = container.children;
		for (i = 0; i < elements.length; i++) {
			$(elements[i]).hide();
		}
	}
})
.on('out', function(el, container) {
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

$(window).click(function(el){
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
	var schedule = getScheduleValues();
	$.ajax({
		url: "save_schedule.php",
		type: "POST",
		data: {schedule : schedule},
		success: function (data){
			if (data.error) {
				$('body').append(data.error.msg);
			}
		}
	});
});

$("#add-activity").click(function (){
	addActivity();
});

$("#new-activity").submit(function(e) {
	e.preventDefault();
	addActivity();
});

function addActivity(){
	var inputName = $("#activity-name").val();
	if (inputName != '') {
		$.ajax({
			url: "add_class.php",
			type: "POST",
			data: {activityName : inputName},
			success: function (data) {
				if (data.error) {
					$('body').append(data.error.msg);
				} else {
					var element = "<div class='schedule-input original-block' style='background-color: #11ee33" + data.class.color + ";' data-schedule=" + data.class.id + ">" + data.class.name + "</div>";
					$('#study-block').append(element);
				}
			}
		});
	}
}
