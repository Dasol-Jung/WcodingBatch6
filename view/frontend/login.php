<link rel="stylesheet" href="../../public/css/login.css"/>
<form class="loginForm" action="index.php" method="POST">

    <label for="email">Email</label>
    <input name="email" id="email" type="text">
    <label for="password">Password</label>
    <input name="password" id="password" type="password">
    <label for="confirmPassword">Confirm Password</label>
    <input name="confirmPassword" id="confirmPassword" type="password">

    <button id="signupBtn">Sign Up</button>
    <div class="socialLoginContainer">
        <button class="googleSignup"><img id="googleLogo" src="../../public/images/googleLogo.png"/><span>Google</span></button>
        <button class="kakaoSignup"><img id="kakaoLogo" src="../../public/images/kakaoLogo.png"/><span>Sign Up</span></button>
    </div>
    
    <div class="toSigninContainer">
        <span class="toSignin">Already have an account? <a href="index.php/signin">Sign in</a></span>
    </div>

</form>