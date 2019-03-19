/** add events */

(function createAddButtonEvent() {
	document.querySelector('button.addSchedule').addEventListener('click', () => {});
})();

(function changeWeeklyMonthly(){
	document.querySelector('button.weeklyMonthly').addEventListener("click",() => {
			window.location.href = 'http://localhost:8888/index.php?action=monthlySchedule'
	})
})();