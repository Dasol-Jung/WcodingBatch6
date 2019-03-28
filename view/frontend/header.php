<?php 
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 
?>
<link rel='stylesheet' href='http://localhost:8888/public/css/1_shared/header.css'/>
<header>
    <div class="logoContainer">
        <img id='logo' src="../../public/images/Logo.png" alt="">
    </div>
    <nav>
        <ul class="menuWrapper">
            <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']==true):?>
                <li class="menuItem"><a class='menuLink' href="index.php">HOME</a></li>
                <li class="menuItem"><a class='menuLink' href="index.php">AVATAR</a></li>
                <li class="menuItem"><a class='menuLink' href="index.php">PROFILE</a></li>
                <li class="menuItem"><a class='menuLink' href="index.php?action=weeklySchedule">SCHEDULER</a></li>
                <li class="menuItem"><a class='menuLink' href="index.php?action=logout">LOGOUT</a></li>
            <?php else :?>
                <li class="menuItem"><a class='menuLink' href="index.php">HOME</a></li>
                <li class="menuItem"><a class='menuLink' href="#">ABOUT US</a></li>
            <?php endif?>
        </ul>
    </nav>
</header>