/** add events */

function generateCalendar(calendarEl) {
	document.addEventListener('DOMContentLoaded', function() {
		var calendar = new FullCalendar.Calendar(calendarEl, {
			events: {
				url: 'http://localhost:8888/index.php?action=loadTodoList',
				type: 'GET', // Send post data
				error: function() {
					alert('There was an error while fetching events.');
				}
			},

			customButtons: {
				changeWeeklyMonthly: {
					text: 'Weekly/Monthly',
					click: function() {
						if (document.body.contains(document.getElementById('weeklyCalendar'))) {
							location.href = 'http://localhost:8888/index.php?action=monthlySchedule';
						} else {
							location.href = 'http://localhost:8888/index.php?action=weeklySchedule';
						}
					}
				},
				addButton: {
					text: 'Add',
					click: function() {
						if (document.body.contains(document.getElementById('weeklyCalendar'))) {
							location.href = 'http://localhost:8888/index.php?action=monthlySchedule&add=add';
						} else {
							location.href = 'http://localhost:8888/index.php?action=weeklySchedule&add=add';
						}
					}
				}
			},
			header: {
				left: 'changeWeeklyMonthly addButton',
				center: 'prev,title,next',
				right: null
			},
			plugins: [ 'dayGrid' ],
			defaultView: 'dayGridWeek'
		});
		calendar.render();
	});
}

// When the user clicks on <span> (x), close the modal
// When the user clicks anywhere outside of the modal, close it
function closeForm() {
	var span = document.getElementsByClassName('close')[0];
	var modal = document.getElementById('myModal');
	window.onclick = function(e) {
		if (e.target == modal) {
			modal.style.display = 'none';
		}
	};
	span.onclick = function() {
		modal.style.display = 'none';
	};
}

/**
 * EXECUTION OF THE SCRIPT 
 */

{
	var calendarEl = document.getElementById('weeklyCalendar');
	generateCalendar(calendarEl);
}

/**
 * Disiplay errors on the check of the form
 */

/**
 * ajax refreshing the page 
 * delayed*
 */

// var eventApp = [];
// var xhr =  new XMLHttpRequest();
// xhr.onreadystatechange = function() {
// 	if (this.readyState == 4 && this.status == 200) {
// 		var appointments = JSON.parse(this.responseText);
// 		//console.log(appointments);

// 		if(appointments.length>0) {
// 			for (var i in appointments) {
// 				var event = {
// 					'title' : appointments[i].title,
// 					'start' : appointments[i].event_date
// 				}
// 				// eventApp += ;
// 				// eventApp += appointment.priority;
// 				// eventApp += appointment.event_date;
// 				// eventApp += appointment.is_done;
// 				eventApp[i] = event;
// 			}
// 		}
// 		console.log(eventApp);
// 	}
// };
// xhr.open("GET", "http://localhost:8888/index.php?action=loadTodoList", true);
// xhr.send();

// window.onload = loadPage();
// function loadPage(){
// var ajax = new XMLHttpRequest();
// ajax.onreadystatechange = function() {
// 	if (this.readyState == 4 && this.status == 200) {
// 		console.log("test");
// 		var appointment = JSON.parse(this.responseText);
// 		console.log(this.responseText);
// 		var eventApp = [];
// 		if(appointment.user_id)
// 		for(var i=0; i < appointment.length; i++){
// 			eventApp += appointment.title;
// 			eventApp += appointment.priority;
// 			eventApp += appointment.event_date;
// 			eventApp += appointment.is_done;
// 		}
// 	}
// };
// ajax.open("GET", "http://localhost:8888/index.php?action=loadTodoList", true);
// ajax.send();
// }
