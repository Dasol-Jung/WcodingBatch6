/** add events */
// (function changeWeeklyMonthly(){
// 	document.querySelector('#monthlyWeeklyBtn').addEventListener("click",() => {
// 		window.location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
// 	})
// })();


/* initialize the calendar
-----------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendarSchedule');

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	var calendar = new FullCalendar.Calendar(calendarEl, {
		plugins: [ 'dayGrid'],
		defaultView: 'dayGridMonth',
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth'
		},
		selectable: true,
		selectHelper: true,
		allDayDefault: true,
		droppable: true, // this allows things to be dropped onto the calendar
		dragRevertDuration: 0,
		eventLimit: true, // for all non-TimeGrid views
		views: {
			timeGrid: {
				eventLimit: 5 
			}
		},
		select: function(start, end, allDay) {
			var title = prompt('Event Title:');
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}
			calendar.fullCalendar('unselect');
		},
		editable: true,
		events: [
			{
				title: 'Long Event',
				start: new Date(y, m, 26),
				end: new Date(y, m, 28),
				className: ["event", "high-priority"],
				editable: true
			},
			{
				title: 'Lunch',
				start: new Date(y, m, 25),
				end: new Date(y, m, 25),
				className: ["event", "medium-priority"]
			},
			{
				title: 'Event 2',
				start: new Date(y, m, 26),
				end: new Date(y, m, 26),
				className: ["event", "medium-priority"]
			},
			{
				title: 'Event 3',
				start: new Date(y, m, 26),
				end: new Date(y, m, 28),
				className: ["event", "low-priority"]
			},
			{
				title: 'Event 4',
				start: new Date(y, m, 26),
				end: new Date(y, m, 26),
				className: ["event", "high-priority"]
			},
			{
				title: 'Event 5',
				start: new Date(y, m, 26),
				end: new Date(y, m, 26),
				className: ["event", "medium-priority"]
			}
		],
	});

	calendar.render();
});

function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	ev.target.appendChild(document.getElementById(data));
}