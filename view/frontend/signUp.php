<?php ob_start();?>

<link rel="stylesheet" href="../../public/css/signUp.css"/>
<form class="loginForm" action="index.php" method="POST">

    <label for="email">Email</label>
    <input name="email" id="email" type="text"/>
    <span class='error' id='error_email'></span>
    <label for="password">Password</label>
    <input name="password" id="password" type="password"/>
    <span class='error' id='error_password'></span>
    <label for="confirmPassword">Confirm Password</label>
    <input name="confirmPassword" id="confirmPassword" type="password"/>
    <span class='error' id='error_confirmPassword'></span>

    <button id="signupBtn">Sign Up</button>
    <span class="socialSignup">Sign Up with</span>
    <div class="socialSignupContainer">
        <button class="googleSignup"><img id="googleLogo" src="../../public/images/googleLogo.png"/><span>Google</span></button>
        <button class="kakaoSignup"><img id="kakaoLogo" src="../../public/images/kakaoLogo.png"/><span>Sign Up</span></button>
    </div>
    
    <div class="toSigninContainer">
        <span class="toSignin">Already have an account? <a href="index.php/signin">Sign in</a></span>
    </div>
</form>
<script src= "../../public/js/frontend/utils.js"></script>
<script src= "../../public/js/frontend/signUp.js"></script>
<?php $content=ob_get_clean();?>

<?php include '../template.php'?>