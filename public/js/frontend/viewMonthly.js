function changeWeeklyMonthly() {
	document.querySelector('button.weeklyMonthly');
	addEventListener('click', () => {
		if ((document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule')) {
			document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule';
		} else {
			document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule';
		}
	});
}

/* initialize the calendar
-----------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function() {
	var Calendar = FullCalendar.Calendar;
	var Draggable = FullCalendarInteraction.Draggable;

	var containerEl = document.getElementById('external-events');
	var calendarEl = document.getElementById('calendarSchedule');

	// initialize the external events
	// -----------------------------------------------------------------

	new Draggable(containerEl, {
		itemSelector: '.fc-event',
		containers: [ calendarEl ],
		eventData: function(eventEl) {
			let priority = eventEl.querySelector('.priority').getAttribute('data-priority');
			let isDone = eventEl.querySelector('.isDone').getAttribute('data-isDone');
			return {
				title: eventEl.innerText,
				extendedProps: { priority: priority, isDone: isDone }
			};
		}
	});

	// initialize the calendar
	// -----------------------------------------------------------------
	var calendar = new Calendar(calendarEl, {
		plugins: [ 'interaction', 'dayGrid' ],
		defaultView: 'dayGridMonth',
		header: {
			left: 'changeWeeklyMonthly addButton',
			center: 'prev,title,next',
			right: null
		},
		customButtons: {
			changeWeeklyMonthly: {
				text: 'Weekly/Monthly',
				click: function() {
					if (document.body.contains(document.getElementById('monthlyCalendar'))) {
						document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule';
					} else {
						document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule';
					}
				}
			},
			addButton: {
				text: 'Add',
				click: function() {
					if (document.body.contains(document.getElementById('monthlyCalendar'))) {
						document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule&add=add';
					} else {
						document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule&add=add';
					}
				}
			}
		},
		allDayDefault: true,
		selectable: true,
		selectHelper: true,
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar
		drop: function(info) {
			info.draggedEl.parentNode.removeChild(info.draggedEl);
		},
		eventLimit: true, // for all non-TimeGrid views
		views: {
			timeGrid: {
				eventLimit: 5
			}
		},

		events: {
			url: 'http://localhost:8888/index.php?action=loadTodoList',
			type: 'GET', // Send post data
			error: function() {
				alert('There was an error while fetching events.');
			}
		}
	});

	calendar.render();
});
