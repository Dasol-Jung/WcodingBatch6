<?php
session_start();
require_once('model/ManagerDB.php');
require('model/frontend/Kakao.php');
require_once("model/frontend/InternalUser.php");

function viewHome()
{
    $internalUser = new InternalUser();
    $internalUser->checkRememberMe();
    require('view/frontend/viewHome.php');
}

function viewCalendar()
{
    require('view/frontend/viewCalendar.php');
}

/**
 * loggedUser : logs users on kakao
 * @param Array $kakaoUser the array of all the informations of the user
 * 
 */
function loggedInKakao($kakaoUserInfo){
    $kakaoUserManager = new KakaoUser();
    $kakaoUserManager->registerKakaoUser($kakaoUserInfo);
}

function viewLogin(){
    require("view/frontend/viewLogin.php");
}

function viewWelcome(){
    require("view/frontend/viewWelcome.php");
}

function signUp($email,$password,$confirmPassword,$firstName){
    $internalUser = new InternalUser();
    $result = $internalUser->userSignUp($email,$password,$confirmPassword,$firstName);
    ob_end_clean();
    echo $result;
}

function login($email, $password, $keepLoggedIn){
    $internalUser = new InternalUser();
    $result = $internalUser->login($email,$password,$keepLoggedIn);
    ob_end_clean();
    echo $result;
}

function logout(){
    $internalUser = new InternalUser();
    $internalUser->userLogout();
}

function viewWeekly()
{
    require("view/frontend/viewWeekly.php");
}

function viewMonthly()
{
    require("view/frontend/viewMonthly.php");
}

function loggedInGoogle($googleInfo)
{
    require("model/frontend/GoogleUserManager.php");
    $googleUser = new GoogleUserManager();
    $googleUser-> makeGoogle($googleInfo);

}