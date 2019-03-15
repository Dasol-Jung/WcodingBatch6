<?php
class ManagerDB {
    protected function dbConnect(){
        
        $bdd = new PDO('mysql:host=arroz.wcoding.com;port=8833;dbname=weekly_scheduler;charset=utf8', 'weekly_scheduler_admin', 'forestOrange43Vita');
        return $bdd
    }
}