<?php $styles[] = "<link rel='stylesheet' href='public/css/1_shared/index.css'/>"?>
<?php $styles[]="<link rel='stylesheet' href='public/css/signUp.css'/>"?>
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
                <input value="vksekwm@gmail.com" name="email" id="email" type="email"/>
                <span class='error' id='error_email'></span>
                <label for="firstName">First Name</label>
                <input value='Aiden' name="firstName" id="firstName" type="text"/>
                <span class='error' id='error_firstName'></span>
                <label for="password">Password</label>
                <input value="hello123!" name="password" id="password" type="password"/>
                <span class='error' id='error_password'></span>
                <label for="confirmPassword">Confirm Password</label>
                <input value="hello123!" name="confirmPassword" id="confirmPassword" type="password"/>
                <span class='error' id='error_confirmPassword'></span>

                <button id="signupBtn">Sign Up</button>
                <div class="social-hr">
                    <span>Sign Up with</span>
                </div>
                <div class="socialSignupContainer">
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

                <div class="toSigninContainer">
                    <span class="toSignin">Already have an account? <a href="http://localhost:8888/index.php?action=login">Sign in</a></span>
                </div>
            </form>
    </div>
</div>
<script src= "../../public/js/frontend/utils.js"></script>
<script src= "../../public/js/frontend/signUp.js"></script>
<script src= "../../public/js/frontend/google.js"></script>
<script src="../../public/js/frontend/kakaoAcct.js"></script>
<script>startApp();</script>
<?php
$content = ob_get_clean();
require("view/template.php");?>

