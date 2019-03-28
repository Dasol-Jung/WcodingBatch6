<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);  
require('./controller/frontend/frontend.php');
try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'viewCalendar') {
            viewCalendar();
        }

        if ($_GET['action'] == 'loggedUser') {
            $kakaoInfo = json_decode(file_get_contents("php://input"), TRUE);
            loggedUser($kakaoInfo);
            
        }
      
        if($_GET['action'] == 'login'){
            // redirect to index.php if the user is already logged in
            if($_SESSION['isLoggedIn']==true){
                while(ob_get_level()){
                    ob_end_clean();
                }
                ob_start();
                header("Location: index.php");
                ob_end_clean();
            }
            //if the user is not logged in, show login form
            viewLogin();
        }
       
        if($_GET['action'] == 'logout'){
            logout();
        }
        if($_GET['action'] == 'welcome'){
            viewWelcome();
        }
        if($_GET['action'] == 'weeklySchedule'){
            if (isset($_GET['add'])){
                if($_GET['add']== 'add'){
                    displayMain();
                } 
            } 
            viewWeekly();
        }

        if($_GET['action'] == 'monthlySchedule'){
            viewMonthly();
        }
        
        if($_GET['action'] == 'googleLogin'){
            $googleInfo = json_decode(file_get_contents("php://input"), TRUE);
            loggedInGoogle($googleInfo);

        }
        // this action just give to fullcalendar API the content of events to load
        if($_GET['action'] == 'loadTodoList'){
            loadAllToDoList("5c9af6277acf25.70313808");
        }
        if($_GET['action'] == 'addEditAppointment'){
            addButton($_POST);
            //loadAllToDoList("5c9af6277acf25.70313808");
            // print_r(loadAllToDoList("5c9af6277acf25.70313808"));
            viewWeekly();
        }

        
    }
    else {
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

            default :
                break;
        }
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}