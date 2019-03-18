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
<?php $styles[]="<link rel='stylesheet' href='../../public/css/viewWeekly.css'/>"?>

<div class='bodyWrapper'>
    <!-- Add schedule form -->
    <div class="addScheduleContainer">
        <form action="">
            
        </form>
    </div>
    <section class="listWrapper">

    </section>
    <section class="calWrapper">
        <div class="utilContainer">
            <div class="calendarCtrl">
            <button class="prev">
                Prev
            </button>
            <div class="showCal">
                <span id='month'>
                Mar
                </span>
                <span id='date'>
                12th
                </span>
            </div>
            <button class="next">
                Next
            </button>
            </div>
            
            <button class="addSchedule">
                Add
            </button>
        </div>
        <div class="calContainer">
        
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            <div class="dayContainer">
                <div class="dayAndDate">
                    <span class="month">
                        Month
                    </span>
                    <span class="date">
                        Date
                    </span>
                </div>
                <div class="calbody"></div>
            </div>
            
        </div>
    </section>
</div>
<script src= "../../public/js/frontend/viewWeekly.js"></script>
<?php

//schedule ends here
$content=ob_get_clean();

require_once("view/template.php");

?>
