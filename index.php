<?php
require('./controller/frontend/frontend.php');
try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'viewCalendar') {
            viewCalendar();
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