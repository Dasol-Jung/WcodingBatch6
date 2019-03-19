<?php 
require_once('model/ManagerDB.php');
require('model/frontend/Kakao.php');

function viewHome()
{
    require('view/frontend/viewHome.php');
}

function viewCalendar()
{
    require('view/frontend/viewCalendar.php');
}

function userPage()
{
    require('view/frontend/userPage.php');
}
/**
 * This function blah 
 * @param Array $kakaoUser the array of all the informations of the user
 * 
 */
function loggedUser($kakaoUserInfo){
    $kakaoUserManager = new KakaoUser();
    $user = $kakaoUserManager->registerKakaoUser($kakaoUserInfo);
    require('view/frontend/testKakao.php');
}