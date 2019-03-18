<?php 
function viewHome()
{
    require("view/frontend/viewHome.php");
}

function viewCalendar()
{
    require("view/frontend/viewCalendar.php");
}
function loggedInGoogle($googleInfo)
{
    require("model/frontend/GoogleUserManager.php");
    $user = new GoogleUserManager();
    $user= $user-> makeGoogle($googleInfo);
    print_r($user);
    require("view/frontend/googleLoginButton.php");
}