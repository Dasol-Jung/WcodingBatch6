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
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.css' />

<link href='../../public/fullcalendar/core/main.css' rel='stylesheet' />
<link href='../../public/fullcalendar/daygrid/main.css' rel='stylesheet' />

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
            <!-- <p>
                <input type='checkbox' id='drop-remove' checked='checked' />
                <label for='drop-remove'>remove after drop</label>
            </p> -->
        </div>
        <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h4>Drag to here</h4>
        </div>
    </section>
    <section class="calWrapper">
        <div id="calendarSchedule"></div>
    </section>
</div>

<!-- <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/jquery.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/jquery-ui.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/moment.min.js'></script> -->
<!-- <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.js'></script> -->

<script src='../../public/fullcalendar/core/main.js'></script>
<script src='../../public/fullcalendar/daygrid/main.js'></script>

<!-- <script src= "../../public/js/frontend/viewMonthly_jquery.js"></script> -->
<script src= "../../public/js/frontend/viewMonthly.js"></script>

<?php

//schedule ends here
$content=ob_get_clean();

require_once("view/template.php");

?>