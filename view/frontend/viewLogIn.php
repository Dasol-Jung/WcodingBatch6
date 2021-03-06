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

    <button id="signInBtn" >Sign In</button>
    <div class="social-hr">
        <span>Sign in with</span>
    </div>
    <div class="socialSigninContainer">
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
    
    <div class="toSignUpContainer">
        <span class="toSignup">You don't have an account? <a href="index.php">Sign Up</a></span>
    </div>
</form>
<script src= "../../public/js/frontend/login.js"></script>

