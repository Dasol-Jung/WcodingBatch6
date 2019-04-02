<?php $styles[]="<link rel='stylesheet' href='public/css/signUp.css'/>"?>
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
        <div style="background-color : #eee; width: 100%; text-align : center; display : grid; align-items : center;" id="gSignInWrapper">
            <div id="googleLogin" class="customGPlusSignIn">
                <img style='height : 22px; position: relative; top : 2px;' src='../../public/images/googleLogo.png'/>
                <span style='position : relative; bottom:5px; left : 10px; font-size : 0.9rem;' class="buttonText">Google</span>
            </div>
        </div>
        <div>  
            <div class="kakaoSignin"><img id="kakaoLogo" src="../../public/images/kakaoLogo.png"/><span>Kakao</span><a id="kakaoLogin"></a></div>
        </div>
    </div>
    
    <div class="toSigninContainer">
        <span class="toSignin">Already have an account? <a href="http://localhost:8888/index.php?action=login">Sign in</a></span>
    </div>
</form>
<script src= "../../public/js/frontend/signUp.js"></script>

