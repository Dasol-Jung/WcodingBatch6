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
				return {
					title: eventEl.innerText
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

//add an event to 'add-simple-event' button

(function() {
	let addBtn = document.querySelector('button.addEvent');
	addBtn.addEventListener('click', e => {
		let addSimpleScheduleForm = document.querySelector('form.addSimpleSchedule');
		document.querySelector('.fc-view-container').style.zIndex = 0;
		document.body.appendChild(clientUtils.createModal(addSimpleScheduleForm));
	});
})();
