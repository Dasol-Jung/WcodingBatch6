<?php
require('./controller/frontend/frontend.php');
try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'viewCalendar') {
            viewCalendar();
        }
        if ($_GET['action'] == 'loggedUser') {
            // print_r(file_get_contents("php://input"));
            $kakaoInfo = json_decode(file_get_contents("php://input"), TRUE);
            // print_r($kakaoInfo);
            loggedUser($kakaoInfo);
            
        }
    }
    else {
        viewHome();
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}