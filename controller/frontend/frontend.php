<?php
session_start();
require_once('model/ManagerDB.php');
require_once('model/frontend/KakaoUser.php');
require_once("model/frontend/InternalUser.php");
require_once("model/frontend/GoogleUser.php");
require_once("model/frontend/User.php");


function viewHome()
{
    $internalUser = new InternalUser();
    $internalUser->checkRememberMe();
    ob_start();
        require('view/frontend/viewSignUp.php');
    $rightSection = ob_get_clean();
    require('view/frontend/viewHome.php');
}

function viewCalendar()
{
    require('view/frontend/viewCalendar.php');
}

function viewLogin(){
    ob_start();
        require("view/frontend/viewLogin.php");
    $rightSection = ob_get_clean();
    require('view/frontend/viewHome.php');
}

function viewWelcome(){
    require("view/frontend/viewWelcome.php");
}

function signUp($email,$password,$confirmPassword,$firstName){
    $internalUser = new InternalUser();
    $result = $internalUser->registerInternalUser($email,$password,$confirmPassword,$firstName);
    ob_end_clean();
    echo $result;

}

function login($email, $password, $keepLoggedIn){
    $internalUser = new InternalUser();
    $result = $internalUser->login($email,$password,$keepLoggedIn);
    ob_end_clean();
    echo $result;
}

/**
 * loggedUser : logs users on kakao
 * @param Array $kakaoUser the array of all the informations of the user
 * 
 */
function loginWithKakao($kakaoUserInfo){
    $kakaoUser = new KakaoUser();
    $kakaoLoginResult = $kakaoUser->registerKakaoUser($kakaoUserInfo);
    ob_end_clean();
    echo $kakaoLoginResult;
}

function loginWithGoogle($googleInfo)
{
    $googleUser = new GoogleUser();
    $googleLoginResult = $googleUser-> registerGoogleUser($googleInfo);
    ob_end_clean();
    echo $googleLoginResult;
}

function logout(){
    $user = new User();
    $user->userLogout();
}

function viewWeekly()
{
    require("view/frontend/viewWeekly.php");
}

function viewMonthly()
{
    require("view/frontend/viewMonthly.php");
}
