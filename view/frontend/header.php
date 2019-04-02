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
                <li class="menuItem"><a class='menuLink' href="index.php?action=weeklySchedule">SCHEDULER</a></li>
                <li class="menuItem avatar">
                    <img id='avatar' src="<?=$_SESSION['avatar']?>" alt="public/images/defaultUserImage.svg">
                </li>
                <ul class="avatarPopup hidden">
                    <li class="profile"><a href="index.php?action=profile" class="menuLink profileLink">MY ACCOUNT</a></li>
                    <?php if(isset($avatars['internal'])&&$avatars['internal']!=''):?>
                    <li>
                        <a class='switchAccount' user='internal' href="index.php?action=switch&type=internal">
                            <span>WEEKY </span>
                            <?php foreach($avatars['internal'] as $internalAvatar):?>
                                <img src="<?=$internalAvatar['image']?>" alt="">
                            <?php endforeach?>
                            
                        </a>
                    </li>
                    <?php endif?>
                    <?php if(isset($avatars['google'])&&$avatars['google']!=''):?>
                    <li>
                        <a class='switchAccount' user='google' href="index.php?action=switch&type=google">  
                            <span>GOOGLE </span>
                            <?php foreach($avatars['google'] as $googleAvatar):?>
                                <img src="<?=$googleAvatar['image']?>" alt="">
                            <?php endforeach?>
                           
                        </a>
                    </li>
                    <?php endif?>
                    <?php if(isset($avatars['kakao'])&& $avatars['kakao']!=''):?>
                    <li>
                        <a class='switchAccount' user='kakao' href="index.php?action=switch&type=kakao">
                        
                            <span>KAKAO </span>
                            <?php foreach($avatars['kakao'] as $kakaoAvatar):?>
                                <img src="<?=$kakaoAvatar['image']?>" alt="">
                            <?php endforeach?>
                           
                        </a>
                    </li>
                    <?php endif?>
                    <li><a class='menuLink logout' id='logout' href="index.php?action=logout">LOGOUT</a></li>
                </ul>
            <?php else :?>
                <li class="menuItem"><a class='menuLink' href="index.php">HOME</a></li>
                <li class="menuItem"><a class='menuLink' href="#">ABOUT US</a></li>
            <?php endif?>
        </ul>
    </nav>
</header>
