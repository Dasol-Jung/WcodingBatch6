<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);   
session_start();
$time = $_SERVER['REQUEST_TIME'];
/**
* for an hour timeout, specified in seconds
*/
$timeout_duration = 3600;

/**
* Here we look for the user's LAST_ACTIVITY timestamp. If
* it's set and indicates our $timeout_duration has passed,
* blow away any previous $_SESSION data and start a new one.
*/
if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

/**
* Finally, update LAST_ACTIVITY so that our timeout
* is based on it and not the user's login time.
*/

$_SESSION['LAST_ACTIVITY'] = $time;

require_once('./controller/frontend/frontend.php');
$util = new Utils();

try{
    if (isset($_GET['action'])) {

        switch($_GET['action']){
            case 'viewCalendar': 
                viewCalendar();
                break;

            case 'login':
                // redirect to index.php if the user is already logged in
                if(isset($_SESSION['isLoggedIn'])&&$_SESSION['isLoggedIn']==true){
                    while(ob_get_level()){
                        ob_end_clean();
                    }
                    ob_start();
                    header("Location: index.php");
                    ob_end_clean();
                }

                //if the user is not logged in, show login form
                viewLogin();
                break;

            case 'googleLogin':                
                $googleInfo = json_decode(file_get_contents("php://input"), TRUE);
                switch($_GET['type']){

                    case 'login':
                        loginWithGoogle($googleInfo);
                        break;

                    case 'connect':
                        connectGoogle($googleInfo);
                        break;

                    default:
                        break;
                }
                break;
            
            case 'kakaoLogin':
                $kakaoInfo = json_decode(file_get_contents("php://input"), TRUE);
                switch($_GET['type']){
                    case 'login':
                        loginWithKakao($kakaoInfo);
                        break;
                    case 'connect':
                        connectKakao($kakaoInfo);
                        break;
                    default:
                        break;
                }
                break;

            case 'logout':
                logout();
                break;

            case 'welcome':
                viewWelcome();
                break;

            case 'weeklySchedule':
                viewWeekly();
                break;

            case 'monthlySchedule':
                viewMonthly();
                break;

            case 'profile':
                viewProfile();
                break;
            
            case 'switch':
                switchAccount($_SESSION['superUid'],$_GET['type']);
                break;

            case 'loadTodoList':
                loadAllToDoList($_SESSION['uid']);
                break;

            case "getSimple":
                getSimpleSchedule($_SESSION['uid']);
                break;
            
            default:
                break;
        }

    }   else{
        viewHome();
    }
    if (isset($_POST['action'])) {

        switch($_POST['action']){
            case 'signup':
                if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])  && isset($_POST['firstName'])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirmPassword'];
                    $firstName = $_POST['firstName'];
                    signUp($email,$password,$confirmPassword,$firstName);
                }else{
                    throw new Exception("Failed to sign up");
                }
                break;

            case 'login':

                if(isset($_POST['email']) && isset($_POST['password'])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $keepLoggedIn = $_POST['keepLoggedIn']=="1" ? true : false;
                    login($email,$password, $keepLoggedIn);
                }

            case 'checkCurrentPW':

                if(isset($_POST['currentPW']) && isset($_SESSION['uid'])){
                    checkCurrentPW($_SESSION['uid'], $_POST['currentPW']);
                }
                break;
            
            case 'changePassword':

                if(isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_SESSION['isCurrentPasswordCorrect'])){
                    changePassword($_POST['password'], $_POST['password']);
                }

            case 'changePersonalInfo':

                changePersonalInfo($_POST['firstName'],$_FILES['avatar']);
                break;

            case 'signOut':
                
                signOut($_SESSION['uid'], $_SESSION['userType']);
                break;

            case 'changeSetting':

                if(isset($_POST['value']) && isset($_POST['type']) && $_SESSION['userType'] && $_SESSION['superUid'] ){
                    changeUserSetting($_POST['value'],$_POST['type'], $_SESSION['userType'],$_SESSION['superUid']);
                }
                break;            

            case 'disconnect':
                if(isset($_POST['userId']) && isset($_POST['userType'])&& isset($_SESSION['superUid'])){
                    //userId, userType : the id and type of the user account to disconnect respectively
                    disconnectAccount($_POST['userId'], $_POST['userType'], $_SESSION['superUid']);
                }

            case 'addSimple':
                if(isset($_POST['scheduleName']) && isset($_POST['scheduleDesc'])&& isset($_SESSION['uid'])){
                    addSimpleSchedule($_POST['scheduleName'],$_POST['scheduleDesc'],$_SESSION['uid']);
                }

            case 'changeDate':
            if(isset($_POST['scheduleId']) && isset($_POST['date']) && isset($_SESSION['uid'])){
                changeDate($_POST['scheduleId'],$_POST['date'],$_SESSION['uid']);
            }

            case "addEditAppointment":
                addEditSchedule($_POST,$_SESSION['uid']);
                break;
                
            default :
                break;
        }
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}