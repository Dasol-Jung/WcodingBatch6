<?php

require_once('model/ManagerDB.php');

function viewHome()
{ 
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
    require("model/frontend/InternalUser.php");
    $internalUser = new InternalUser();
    $result = $internalUser->userSignUp($email,$password,$confirmPassword,$firstName);
    ob_clean();
    echo $result;

}

function login($email, $password, $keepLoggedIn){
    require("model/frontend/InternalUser.php");
    $internalUser = new InternalUser();
    $result = $internalUser->login($email,$password,$keepLoggedIn);
    ob_clean();
    echo $result;
}