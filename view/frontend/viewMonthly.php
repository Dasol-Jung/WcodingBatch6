<?php
//start session
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

//redirect user if he's not logged in
if($_SESSION['isLoggedIn']!=true){
   ob_end_clean();
   header("Location: http://localhost:8888/index.php");
}

//schedule starts from here
ob_start();
?>
<?php $styles[]="<link rel='stylesheet' href='../../public/css/viewSchedule.css'/>"?>
<link href='../../public/css/addButton.css' rel='stylesheet' />
<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.css' />

<link href='../../public/lib/fullCalendar/core/main.css' rel='stylesheet' />
<link href='../../public/lib/fullCalendar/daygrid/main.css' rel='stylesheet' />

<div class='bodyWrapper'>
    <section class="listWrapper">
        <div id='external-events'>
            <div id='external-events-listing' ondrop="drop(event)" ondragover="allowDrop(event)">
                <h4>Draggable Events</h4>
                <div class='fc-event' id="1" draggable="true" ondragstart="drag(event)" >My Event 1</div>
                <div class='fc-event' id="2" draggable="true" ondragstart="drag(event)">My Event 2</div>
                <div class='fc-event' id="3" draggable="true" ondragstart="drag(event)">My Event 3</div>
                <div class='fc-event' id="4" draggable="true" ondragstart="drag(event)">My Event 4</div>
                <div class='fc-event' id="5" draggable="true" ondragstart="drag(event)">My Event 5</div>
            </div>
        </div>
        <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h4>Drag to here</h4>
        </div>
    </section>
    <section class="calWrapper">
        <div id="monthlyCalendar"></div>
    </section>
</div>

<script src='../../public/lib/fullCalendar/core/main.js'></script>
<script src='../../public/lib/fullCalendar/daygrid/main.js'></script>
<script src= "../../public/js/frontend/viewMonthly.js"></script>
<script src= "../../public/js/frontend/modifyButton.js"></script>
<?php
require("view/frontend/addButtonCalendar.php");
//schedule ends here
$content=ob_get_clean();

require_once("view/template.php");

?>