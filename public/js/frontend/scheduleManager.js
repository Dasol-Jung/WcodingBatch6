//schedule managing unit

let scheduleManager = (function() {
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

	let renderSimple = function(events) {
		let dragContainer = document.querySelector('#external-events-listing');
		events.forEach(event => {
			let eventElement = document.createElement('div');
			eventElement.textContent = event['title'];
			eventElement.className = 'fc-event';
			dragContainer.appendChild(eventElement);
		});
	};

	return { getSchedule };
})();
