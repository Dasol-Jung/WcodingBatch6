// function changeWeeklyMonthly(){
// 	document.querySelector('button.weeklyMonthly');addEventListener("click",() => {
// 			if(document.location.href = 'http://localhost:8888/index.php?action=monthlySchedule'){
// 				document.location.href= 'http://localhost:8888/index.php?action=weeklySchedule'
// 			}else{
// 				document.location.href= 'http://localhost:8888/index.php?action=monthlySchedule'
// 			}
// 		}
// 	)
// }

/* initialize the calendar
-----------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function() {
	var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;

	var containerEl = document.getElementById('external-events');
	var calendarEl = document.getElementById('calendarSchedule');
  var checkbox = document.getElementById('drop-remove');

	// initialize the external events
  // -----------------------------------------------------------------

  new Draggable(containerEl, {
		itemSelector: '.fc-event',
		containers: [ calendarEl ],
    eventData: function(eventEl) {
      return {
        title: eventEl.innerText
      };
    }
	});

	// initialize the calendar
  // -----------------------------------------------------------------
	var calendar = new Calendar(calendarEl, {
		plugins: ['interaction', 'dayGrid'],
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
		allDayDefault: true,
		selectable: true,
		selectHelper: true,
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar
		drop: function(info) {
			console.log(info.view);
      // is the "remove after drop" checkbox checked?
      if (checkbox.checked) {
        // if so, remove the element from the "Draggable Events" list
				info.draggedEl.parentNode.removeChild(info.draggedEl);
      }
    },
		eventLimit: true, // for all non-TimeGrid views
		views: {
			timeGrid: {
				eventLimit: 5 
			}
		},
		// select: function(start, end, allDay) {
		// 	var title = prompt('Event Title:');
		// 	if (title) {
		// 		calendar.fullCalendar('renderEvent',
		// 			{
		// 				title: title,
		// 				start: start,
		// 				end: end,
		// 				allDay: allDay
		// 			},
		// 			true // make the event "stick"
		// 		);
		// 	}
		// 	calendar.fullCalendar('unselect');
		// },
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

// function allowDrop(ev) {
// 	ev.preventDefault();
// }

// function drag(ev) {
// 	ev.dataTransfer.setData("text", ev.target.id);
// }

// function drop(ev) {
// 	ev.preventDefault();
// 	var data = ev.dataTransfer.getData("text");
// 	ev.target.appendChild(document.getElementById(data));
// }