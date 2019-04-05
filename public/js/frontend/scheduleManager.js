//schedule managing unit

let scheduleManager = (function() {
	(function() {
		//add an event to 'add-simple-event' button
		let addBtn = document.querySelector('button.addEvent');
		if (addBtn) {
			addBtn.addEventListener('click', e => {
				let addSimpleScheduleForm = document.querySelector('form.addSimpleSchedule');
				addSimpleSchedule(addSimpleScheduleForm);
				document.querySelector('.fc-view-container').style.zIndex = 0;
				document.body.appendChild(clientUtils.createModal(addSimpleScheduleForm));
			});
		}

		//add a simple event
		function addSimpleSchedule(addForm) {
			addForm.addEventListener('submit', e => {
				e.preventDefault();
				let xhr = new XMLHttpRequest();
				let formToSend = new FormData(addForm);
				formToSend.append('action', 'addSimple');
				xhr.open('POST', `index.php`);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
						if (xhr.response == 'success') {
							addForm.reset();
							addForm.parentElement.parentElement.style.display = 'none';
							getSchedule();
						}
					}
					if (xhr.status >= 400) {
						//php error page
						return;
					}
				};
				xhr.send(formToSend);
			});
		}
	})();
	/**
     * getSchedule : get simple schedule from db
     */
	let getSchedule = function() {
		let xhr = new XMLHttpRequest();
		xhr.open('GET', `index.php?action=getSimple`);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
				renderSimple(JSON.parse(xhr.response));
			}
			if (xhr.status >= 400) {
				//php error page
				return;
			}
		};
		xhr.send();
	};
	/**
     * renderSimple : render simple schedules in the DOM
     */

	let renderSimple = function(events) {
		let dragContainer = document.querySelector('#external-events-listing');
		dragContainer.innerHTML = '';
		events.forEach(event => {
			let eventElement = document.createElement('a');
			let isDone = document.createElement('span');
			let priority = document.createElement('div');
			let text = document.createTextNode(event['title']);
			priority.setAttribute('data-priority', event['priority']);
			priority.className = 'priority';
			isDone.setAttribute('data-isDone', event['is_done']);
			isDone.className = 'isDone';
			isDone.innerHTML = '<i class="fas fa-check-circle" />';
			eventElement.setAttribute('data-edit', 'true');
			eventElement.setAttribute('data-scheduleId', event['schedule_id']);
			eventElement.appendChild(priority);
			eventElement.appendChild(text);
			eventElement.className = 'fc-event';
			eventElement.appendChild(isDone);
			dragContainer.appendChild(eventElement);
		});
	};

	let changeDate = function(scheduleId, date) {
		let xhr = new XMLHttpRequest();
		let formToSend = new FormData();
		formToSend.append('action', 'changeDate');
		formToSend.append('scheduleId', scheduleId);
		formToSend.append('date', date);
		xhr.open('POST', `index.php`);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
				if (xhr.response == 'success') {
				}
			}
			if (xhr.status >= 400) {
				//php error page
				return;
			}
		};
		xhr.send(formToSend);
	};

	return { getSchedule, changeDate };
})();
