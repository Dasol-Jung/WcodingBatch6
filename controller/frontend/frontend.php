<?php
session_start();
require_once('model/ManagerDB.php');
require_once("model/frontend/InternalUser.php");

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

function loggedInGoogle($googleInfo)
{
    require("model/frontend/GoogleUserManager.php");
    $user = new GoogleUserManager();
    $user= $user-> makeGoogle($googleInfo);
    require("view/frontend/googleLoginButton.php");
}