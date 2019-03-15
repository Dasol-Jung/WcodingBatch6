<?php
require('./controller/frontend/frontend.php');
try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'viewCalendar') {
            viewCalendar();
        }
        elseif ($_GET['action'] == 'loggedIn') {
            $googleInfo = json_decode(file_get_contents("php://input"), TRUE);
            loggedInGoogle($googleInfo);
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