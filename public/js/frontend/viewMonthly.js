/** add events */
console.log(document);
(function changeWeeklyMonthly(){
	document.querySelector('button.monthlyWeekly').addEventListener("click",() => {
			window.location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
	})
})();

document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('monthlyCalendar');

	var calendar = new FullCalendar.Calendar(calendarEl, {
		plugins: [ 'dayGrid' ]
	});

	calendar.render();
});