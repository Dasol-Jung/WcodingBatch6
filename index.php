<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);  
require('./controller/frontend/frontend.php');
try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'viewCalendar') {
            viewCalendar();
        }
        if($_GET['action'] == 'login'){
            viewLogin();
        }
        if($_GET['action'] == 'welcome'){
            viewWelcome();
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