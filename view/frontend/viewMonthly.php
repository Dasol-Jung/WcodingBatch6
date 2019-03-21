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
<?php $styles[]="<link rel='stylesheet' href='../../public/css/viewMonthly.css'/>"?>
<link href='../../public/fullcalendar/core/main.css' rel='stylesheet' />
<link href='../../public/fullcalendar/daygrid/main.css' rel='stylesheet' />

<script src='../../public/fullcalendar/core/main.js'></script>
<script src='../../public/fullcalendar/daygrid/main.js'></script>


<div class='bodyWrapper'>
    <section class="listWrapper">

    </section>
    <section class="calWrapper">
        <div id="switchDiv">
            <button id="monthlyWeeklyBtn">
                switch to weekly
            </button>
        </div>
        <div id="monthlyCalendar"></div>
    </section>
</div>
<script src= "../../public/js/frontend/viewMonthly.js"></script>

<?php

//schedule ends here
$content=ob_get_clean();

require_once("view/template.php");

?>
