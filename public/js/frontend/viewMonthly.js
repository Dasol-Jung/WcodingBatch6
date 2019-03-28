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


/* initialize the calendar
-----------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendarSchedule');

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	var calendar = new FullCalendar.Calendar(calendarEl, {
    
		plugins: [ 'dayGrid'],
		defaultView: 'dayGridMonth',
		header: {
			left: 'changeWeeklyMonthly addButton',
		  center: 'title',
			right: 'prev,next'
		},
    customButtons: {
      changeWeeklyMonthly: {
        text: 'Weekly/Monthly',
        click: function() {
          if(document.body.contains(document.getElementById("monthlyCalendar"))){
            document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule'
          } else {
            document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule'
          }
        }
      },
      addButton: {
        text: 'Add',
				click: function() {
          if(document.body.contains(document.getElementById("monthlyCalendar"))){
            document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule&add=add'
          } else {
            document.location.href = 'http://localhost:8888/index.php?action=weeklySchedule&add=add'
          }
        }
      }
    },
		selectable: true,
		selectHelper: true,
		allDayDefault: true,
		droppable: true, // this allows things to be dropped onto the calendar
		dragRevertDuration: 0,
		eventLimit: true, // for all non-TimeGrid views
		views: {
			timeGrid: {
				eventLimit: 5 
			}
		},
		select: function(start, end, allDay) {
			var title = prompt('Event Title:');
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}
			calendar.fullCalendar('unselect');
		},
		editable: true,
		events:  {
			url: 'http://localhost:8888/index.php?action=loadTodoList',
			type: 'GET', // Send post data
			error: function() {
				alert('There was an error while fetching events.');
			}
		}
	});

	calendar.render();
});

function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	ev.target.appendChild(document.getElementById(data));
}