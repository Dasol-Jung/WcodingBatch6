/** add events */
(function changeWeeklyMonthly(){
	document.querySelector('#monthlyWeeklyBtn').addEventListener("click",() => {
		window.location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
	})
})();

document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('monthlyCalendar');

	var calendar = new FullCalendar.Calendar(calendarEl, {
		plugins: [ 'dayGrid' ],

		editable: true,
	});

	calendar.render();
});

var monthlyCalendar = document.querySelector('#monthlyCalendar');
var toolBar = monthlyCalendar.querySelector('.fc-toolbar');
console.log(monthlyCalendar);