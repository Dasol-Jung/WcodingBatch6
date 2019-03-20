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
        <div class="utilContainer">
            <button class="monthlyWeekly">
                weekly/monthly
            </button>
            <button class="prev">
                Prev
            </button>
            <div class="showCal">
                <span id='month'>
                Mar
                </span>
            </div>
            <button class="next">
                Next
            </button>
        </div>
        <div class="calContainer">
        
            <table>
                <tr class='days'>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Frid</th>
                    <th>Sat</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
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
