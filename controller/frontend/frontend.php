<?php

require_once('model/ManagerDB.php');

function viewHome()
{
    require('view/frontend/viewHome.php');
}

function viewCalendar()
{
    require('view/frontend/viewCalendar.php');
}

function viewLogin(){
    require("view/frontend/viewLogin.php");
}

function viewWelcome(){
    require("view/frontend/viewWelcome.php");
}

function signUp($email,$password,$confirmPassword,$firstName){
    require("model/frontend/InternalUser.php");
    $userManager = new InternalUser();
    $result = $userManager->userSignUp($email,$password,$confirmPassword,$firstName);
    ob_clean();
    echo $result;

}