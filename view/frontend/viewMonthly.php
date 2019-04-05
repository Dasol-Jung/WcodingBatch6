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
<?php $styles[]="<link rel='stylesheet' href='../../public/css/viewMonthly.css'/>"?>
<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.css' />
<link href='../../public/lib/fullCalendar/core/main.css' rel='stylesheet' />
<link href='../../public/lib/fullCalendar/daygrid/main.css' rel='stylesheet' />
<link href='../../public/css/addButton.css' rel='stylesheet' />

<div class='bodyWrapper'>
    <section class="listWrapper">
    <button class='addEvent'><i class='fas fa-plus'></i></button>
        <div id='external-events'>
            <div id='external-events-listing'>
                
            </div>
        </div>
    </section>
    <section class="calWrapper">
        <div id="calendarSchedule"></div>
    </section>
</div>
<!-- modal -->
<form class="modalTarget addSimpleSchedule">
<h2>Add a simple schedule</h2>
    <label for="scheduleName">Name</label>
    <input name ='scheduleName' id='scheduleName' type="text" >
    <label for="scheduleDesc">Description</label>
    <input name='scheduleDesc' id='scheduleDesc' type="text" >
    <button class="addSimpleBtn">Add</button>
</form>
<!-- detailed schedule modal -->
<?php require_once('view/frontend/addButtonCalendar.php')?>
<script src="../../public/js/frontend/jquery.js"></script>
<script src="../../public/js/frontend/jquery-ui.js"></script>
<script src='../../public/lib/fullCalendar/core/main.js'></script>
<script src='../../public/lib/fullCalendar/daygrid/main.js'></script>
<script src='../../public/lib/fullCalendar/interaction/main.js'></script>
<script src= "../../public/js/frontend/scheduleManager.js"></script>
<script src= "../../public/js/frontend/viewMonthly.js"></script>
<script>scheduleManager.getSchedule();</script>
<?php

//schedule ends here
$content=ob_get_clean();

require_once("view/template.php");

?>