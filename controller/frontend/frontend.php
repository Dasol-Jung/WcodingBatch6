<?php
session_start();
require_once('model/ManagerDB.php');
require('model/frontend/Kakao.php');
require_once("model/frontend/InternalUser.php");
require_once('model/frontend/AddModifyDB.php');


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

/**
 * loggedUser : logs users on kakao
 * @param Array $kakaoUser the array of all the informations of the user
 * 
 */
function loggedUser($kakaoUserInfo){
    $kakaoUserManager = new KakaoUser();
    $user = $kakaoUserManager->registerKakaoUser($kakaoUserInfo);
    require('view/frontend/testKakao.php');
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
    $result = $internalUser->userSignUp($email,$password,$confirmPassword,$firstName);
    ob_clean();
    echo $result;

}

function login($email, $password, $keepLoggedIn){
    $internalUser = new InternalUser();
    $result = $internalUser->login($email,$password,$keepLoggedIn);
    ob_clean();
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

function displayMain(){
    require("view/frontend/addButtonCalendar.php");
}

function addButton($addWeekly){
    $addAffLines = new AddModifyDB();
    $addAffLines-> addInfo($addWeekly);
}

function modifyButton($modWeekly){
    $modAffLines = new AddModifyDB();
    $modAffLines-> modInfo($modWeekly);
}

function loadAllToDoList($user){
    $loadAffLines = new AddModifyDB();
    $loadAffLines-> loadToDoList($user);
}

// function closeForm() {
//     require_once("model/frontend/AddModifyDB.php");
// }
