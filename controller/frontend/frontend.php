<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
require_once('model/ManagerDB.php');
require_once('model/frontend/KakaoUser.php');
require_once("model/frontend/InternalUser.php");
require_once("model/frontend/GoogleUser.php");
require_once("model/frontend/User.php");
require_once('model/frontend/AddModifyDB.php');


function viewHome()
{
    $internalUser = new InternalUser();
    $internalUser->checkRememberMe();
    $user = new User();
    if(isset($_SESSION['uid'])&&isset($_SESSION['userType'])){
        $userInfo = $user->getUserInfo($_SESSION['uid'],$_SESSION['userType']);
        $avatars = $user->getAvatars($_SESSION['superUid']);
    }
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
    $user = new User();
        $userInfo = $user->getUserInfo($_SESSION['uid'],$_SESSION['userType']);
        $avatars = $user->getAvatars($_SESSION['superUid']);
    require("view/frontend/viewWeekly.php");
}

function viewMonthly()
{
    $user = new User();
        $userInfo = $user->getUserInfo($_SESSION['uid'],$_SESSION['userType']);
        $avatars = $user->getAvatars($_SESSION['superUid']);
    require("view/frontend/viewMonthly.php");
}

function viewProfile()
{
    if($_SESSION['isLoggedIn']!= true){
        header("Location: index.php");
    }else{
        $user = new User();
        $userInfo = $user->getUserInfo($_SESSION['uid'],$_SESSION['userType']);
        $avatars = $user->getAvatars($_SESSION['superUid']);
        require("view/frontend/viewProfile.php");
    }
}

function checkCurrentPW($uid, $currentPW){
    $internalUser = new InternalUser();
    $result = $internalUser->checkCurrentPassword($uid,$currentPW);
    ob_end_clean();
    echo $result;
}

function changePassword($password, $confirmPassword){
    $internalUser = new InternalUser();
    $result = $internalUser->changePassword($password,$confirmPassword);
    ob_end_clean();
    echo $result;
}

function changePersonalInfo($firstName, $avatar){
    $user = new User();
    $result = $user->changePersonalInfo($firstName, $avatar);
    ob_end_clean();
    echo $result;
}

function connectGoogle($googleUserInfo){
    $googleUser = new GoogleUser();
    $result = $googleUser->connectGoogle($googleUserInfo);
    ob_end_clean();
    print_r($result);
}

function connectKakao($kakaoUserInfo){
    $kakaoUser = new KakaoUser();
    $result = $kakaoUser->connectKakao($kakaoUserInfo);
    ob_end_clean();
    print_r($result);
}

function signOut($uid, $userType){
    $user = new User();
    $result = $user->signOut($uid,$userType);
    ob_end_clean();
    print_r($result);
}

function switchAccount($superUid, $type){
    $user = new User();
    $result=$user->switchAccount($superUid, $type);
    ob_end_clean();
    echo $result;
}

function changeUserSetting($value, $type, $userType, $superUid){
    $user = new User();
    $result=$user->changeUserSetting($value, $type, $userType, $superUid);
    ob_end_clean();
    echo $result;
}

function displayAddModal(){
   // require("view/frontend/addButtonCalendar.php");
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
