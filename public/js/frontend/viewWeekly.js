/** add events */

function generateCalendar(calendarEl) {
	document.addEventListener('DOMContentLoaded', function() {
		var Draggable = FullCalendarInteraction.Draggable;
		var containerEl = document.getElementById('external-events');

		// initialize the external events
		// -----------------------------------------------------------------

		new Draggable(containerEl, {
			itemSelector: '.fc-event',
			containers: [ calendarEl ],
			eventData: function(eventEl) {
				let priority = eventEl.querySelector('.priority').getAttribute('data-priority');
				let isDone = eventEl.querySelector('.isDone').getAttribute('data-isDone');
				let scheduleId = eventEl.getAttribute('data-scheduleId');
				return {
					title: eventEl.innerText,
					extendedProps: { priority: priority, isDone: isDone, schedule_id: scheduleId }
				};
			}
		});

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
			plugins: [ 'dayGrid', 'interaction' ],
			defaultView: 'dayGridWeek',
			editable: true,
			selectable: true,
			droppable: true,
			eventDrop: function(info) {
				let newDate = new Date(info.event.start);
				let year = newDate.getFullYear();
				let month = newDate.getMonth() + 1;
				let day = newDate.getDate();
				newDate = `${year}-${month}-${day}`;
				scheduleManager.changeDate(info.event._def.extendedProps['schedule_id'], newDate);
			},
			eventReceive: function(info) {
				let newDate = new Date(info.event.start);
				let year = newDate.getFullYear();
				let month = newDate.getMonth() + 1;
				let day = newDate.getDate();
				newDate = `${year}-${month}-${day}`;
				scheduleManager.changeDate(info.event._def.extendedProps['schedule_id'], newDate);
			},
			drop: function(info) {
				info.draggedEl.parentNode.removeChild(info.draggedEl);
			}
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
