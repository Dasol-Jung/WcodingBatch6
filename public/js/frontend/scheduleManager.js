//schedule managing unit

let scheduleManager = (function() {
	/**
     * getSchedule : get schedule from
     * @params
     * -startDate : the starting date in a mysql string form year-month-day ex)2019-03-29
     * -finishDate : the finishing date(inclusive) in a mysql string form year-month-day ex)2019-03-29
     */
	let getSchedule = function(startDate, finishDate) {
		let xhr = new XMLHttpRequest();
		let newForm = new FormData();
		xhr.open('POST', `index.php`);
		newForm.append('action', 'addSimple');
		newForm.append('start', startDate);
		newForm.append('finish', finishDate);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
				console.log(xhr.response);
			}
			if (xhr.status >= 400) {
				//php error page
				return;
			}
		};
		xhr.send(newForm);
	};

	return { getSchedule };
})();
