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
							location.href = 'http://localhost:8888/index.php?action=monthlySchedule'	
						} else {
							location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
						}
					}
				},
				addButton: {
					text: 'Add',
					click: function(){
						location.href = 'http://localhost:8888/index.php?action=weeklySchedule&add=add'
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
function openForm() {
    document.getElementById("myForm").style.display = "block";
}

// var closeForm = document.getElementById('closeForm');closeForm.onclick = function(){
// 	var formDiv = document.getElementById('myForm');
// 	formDiv.style.display = 'none';
// }
// function closeForm() {
// 	var closeForm = document.getElementById('closeForm');
// 	closeForm.onclick = function(){
// 	var formDiv = document.getElementById('myForm');
// 		formDiv.parentnode.remove();
// 	}
// }
/**
 * EXECUTION OF THE SCRIPT 
 */

{
	var calendarEl = document.getElementById('weeklyCalendar');
	generateCalendar(calendarEl);
}

/**
 * Disiplay errors on the check of the form
 */ 
