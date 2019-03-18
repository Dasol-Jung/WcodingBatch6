<?php $styles[]='<link rel="stylesheet" href="public/css/signIn.css"/>'?>

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
    <div class="socialSigninContainer">
        <div id="googleLogin"></div>
        <!-- <button class="googleSignin"><img id="googleLogo" src="../../public/images/googleLogo.png"/><span>Google</span></button> -->
        <button class="kakaoSignin"><img id="kakaoLogo" src="../../public/images/kakaoLogo.png"/><span>Kakao</span></button>
    </div>
    
    <div class="toSignUpContainer">
        <span class="toSignup">You don't have an account? <a href="index.php">Sign Up</a></span>
    </div>
</form>
<script src="../../public/js/frontend/google.js"></script>
<script src= "../../public/js/frontend/utils.js"></script>
<script src= "../../public/js/frontend/login.js"></script>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
