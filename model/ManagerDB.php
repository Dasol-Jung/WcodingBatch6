<?php
class ManagerDB {
    protected function dbConnect(){
        $bdd = new PDO('mysql:host=localhost;dbname=weekly_scheduler;charset=utf8', 'root', 'root');
        return $bdd;
    }
}