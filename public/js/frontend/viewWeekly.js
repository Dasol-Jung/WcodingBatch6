/** add events */

function createAddButtonEvent() {
	document.querySelector('button.addSchedule').addEventListener('click', () => {});
}

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
						if(document.body.contains(document.getElementById("weeklyCalendar"))){
							document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule'	
						} else {
							document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
						}
					}
				},
				addButton: {
					text: 'Add',
					click: function(){
						window.location.replace = "http://localhost:8888/index.php?action=weeklySchedule&add=add"
					}
				}
			},
			header: {
				left: 'changeWeeklyMonthly addButton',
				center: 'title',
				right: 'today prev,next'
			},
			plugins: [ 'dayGrid' ],
			defaultView: 'dayGridWeek'
		});
		calendar.render();
	});
}

/**
 * EXECUTION OF THE SCRIPT 
 */

{
	var calendarEl = document.getElementById('weeklyCalendar');
	generateCalendar(calendarEl);
}