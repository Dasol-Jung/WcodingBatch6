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

function sendScheduleForm(form) {
	form.addEventListener('submit', e => {
		e.preventDefault();
		let xhr = new XMLHttpRequest();
		let formData = new FormData(form);
		formData.append('action', 'addEditAppointment');
		xhr.open('POST', 'index.php');
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
				form.reset();
				switch (xhr.response) {
					case 'success':
						location.reload();
						break;

					default:
						break;
				}
			}
			if (xhr.status >= 400) {
				//php error page
				return;
			}
		};
		xhr.send(formData);
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
			let scheduleId = eventEl.getAttribute('data-scheduleId');
			return {
				title: eventEl.innerText,
				extendedProps: { priority: priority, is_done: isDone, schedule_id: scheduleId }
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
					let detailedSchedule = document.querySelector('.modalTarget.detailedSchedule');
					detailedSchedule
						.querySelectorAll('.labelChecked')
						.forEach(label => label.classList.remove('labelChecked'));
					detailedSchedule.querySelector('input[name="scheduleId"]').value = '';
					detailedSchedule.querySelector('label[for="medium"]').classList.add('labelChecked');
					detailedSchedule.querySelector('input[id="medium"]').checked = 'true';
					detailedSchedule.querySelector('label[for="notDone"]').classList.add('labelChecked');
					detailedSchedule.querySelector('input[id="notDone"]').checked = 'true';
					detailedSchedule.querySelector(`button#submit`).innerText = 'add';
					detailedSchedule.querySelector('button#discard').addEventListener('click', e => {
						e.preventDefault();
						if (confirm('Do you really want to discard this schedule?')) {
							detailedSchedule.parentNode.parentNode.style.display = 'none';
						}
					});
					document.body.appendChild(clientUtils.createModal(detailedSchedule, [ '70%' ]));
					sendScheduleForm(detailedSchedule);
				}
			}
		},
		eventClick: function(info) {
			let { schedule_id, description, is_done, priority } = info.event._def.extendedProps;
			let title = info.event._def.title;
			let newDate = new Date(info.event._instance.range.start);
			let year = newDate.getFullYear();
			let month = '0' + (newDate.getMonth() + 1);
			month.length > 2 ? (month = month.slice(1)) : null;
			let day = '0' + newDate.getDate();
			day.length > 2 ? (day = day.slice(1)) : null;
			let eventDate = `${year}-${month}-${day}`;
			let detailedSchedule = document.querySelector('.modalTarget.detailedSchedule');
			detailedSchedule
				.querySelectorAll('.labelChecked')
				.forEach(label => label.classList.remove('.labelChecked'));
			detailedSchedule.querySelector(`textarea[name="description"]`).value = description;
			detailedSchedule.querySelector(`input[name="scheduleId"]`).value = schedule_id;
			detailedSchedule.querySelector(`input[name="title"]`).value = title;
			detailedSchedule.querySelector(`button#submit`).innerText = 'update';
			detailedSchedule.querySelector(`input[name="eventDate"]`).value = eventDate;
			detailedSchedule.querySelector(`label[for="${priority}"]`).classList.add('labelChecked');
			detailedSchedule.querySelector(`input[value="${priority}"]`).checked = 'true';
			if (is_done == '1') {
				detailedSchedule.querySelector(`label[for="done"]`).classList.add('labelChecked');
				detailedSchedule.querySelector('input[id="done"]').checked = 'true';
			} else {
				detailedSchedule.querySelector(`label[for="notDone"]`).classList.add('labelChecked');
				detailedSchedule.querySelector('input[id="notDone"]').checked = 'true';
			}

			detailedSchedule.querySelector('button#discard').addEventListener('click', e => {
				e.preventDefault();
				if (confirm('Do you really want to discard this schedule?')) {
					detailedSchedule.parentNode.parentNode.style.display = 'none';
				}
			});
			document.body.appendChild(clientUtils.createModal(detailedSchedule, [ '70%' ]));
			sendScheduleForm(detailedSchedule);
		},
		selectable: true,
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar
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
