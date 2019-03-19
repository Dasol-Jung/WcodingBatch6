<?php $styles[] = "<link rel='stylesheet' href='public/css/1_shared/index.css'/>"?>
<?php $styles[]='<link rel="stylesheet" href="public/css/signIn.css"/>'?>
<?php ob_start(); ?>
<script src="https://apis.google.com/js/api:client.js"></script>
<script src="http://developers.kakao.com/sdk/js/kakao.min.js"></script>
<div class="bodyWrapper">
    <div class="left">
        <?php require_once "carousel.php"?>
    </div>
    <div class="divider"></div>
    <div class="right">
<form class="loginForm" action="index.php" method="POST">

    <label for="email">Email</label>
    <input name="email" id="email" type="email"/>
    <label for="password">Password</label>
    <input name="password" id="password" type="password"/>
    <div class="keepLoggedIn-container">
        <input name="keepLoggedIn" value="1" id="keepLoggedIn" type="checkbox"/>
        <label for="keepLoggedIn">Remember Me</label>
    </div>
    <span class='error' id='error_message'></span>

    <button id="signInBtn">Sign In</button>
    <div class="social-hr">
        <span>Sign in with</span>
    </div>
    <div class="socialSigninContainer">
        <div style="background-color : #eee; padding-left : 2.5rem; display : grid; align-items : center;" id="gSignInWrapper">
            <div id="customBtn" class="customGPlusSignIn">
                <img style='height : 22px; position: relative; top : 2px;' src='../../public/images/googleLogo.png'/>
                <span style='position : relative; bottom:5px; left : 10px; font-size : 0.9rem;' class="buttonText">Google</span>
            </div>
        </div>
        <div>  
            <div class="kakaoSignin"><img id="kakaoLogo" src="../../public/images/kakaoLogo.png"/><span>Kakao</span><a id="kakao-login-btn"></a></div>
        </div>
    </div>
    
    <div class="toSignUpContainer">
        <span class="toSignup">You don't have an account? <a href="index.php">Sign Up</a></span>
    </div>
</form>
</div>
</div>
<script src= "../../public/js/frontend/utils.js"></script>
<script src= "../../public/js/frontend/login.js"></script>
<script src= "../../public/js/frontend/google.js"></script>
<script src="../../public/js/frontend/kakaoAcct.js"></script>
<script>startApp();</script>
<?php
$content = ob_get_clean();
require("view/template.php");?>
