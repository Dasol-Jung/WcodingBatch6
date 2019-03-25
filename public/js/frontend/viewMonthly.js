function changeWeeklyMonthly(){
	document.querySelector('button.weeklyMonthly');addEventListener("click",() => {
			if(document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule'){
				document.location.href= 'http://localhost:8888/index.php?action=weeklySchedule'
			}else{
				document.location.href= 'http://localhost:8888/index.php?action=monthlySchedule'
			}
		}
	)
}
function generateCalendar (calendarEl) {
	document.addEventListener('DOMContentLoaded', function() {
		var calendar = new FullCalendar.Calendar(calendarEl, {
			customButtons: {
				changeWeeklyMonthly: {
					text: 'Weekly/Monthly',
					click: function() {
						if(document.body.contains(document.getElementById("monthlyCalendar"))){
							document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
						} else {
							document.location.href = 'http://localhost:8888/index.php?action=monlylySchedule'
						}
					}
				},
				addButton: {
					text: 'Add',
					click: function(){
						document.location.href = "http://localhost:8888/index.php?action=weeklySchedule&add=add"
					}
                }
            },
			header: {
				left: 'changeWeeklyMonthly addButton',
				center: 'title',
				right: 'prev,next'
			},
			plugins: [ 'dayGrid' ],
			defaultView: 'dayGridWeek'
		});
		calendar.render();
	});
}