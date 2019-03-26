<?php

class ManagerDB {
    protected function dbConnect(){
        try{
            $db = new PDO('mysql:host=192.168.1.250:3306;dbname=weekly_scheduler;charset=utf8', 'weekly_scheduler_admin', 'forestOrange43Vita',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            return $db;
        }
        catch(Exception $e){
            $errorMessage = $e->getMessage();
            require('view/frontend/errorView.php');
        }
    }
}