<?php
class ManagerDB {
    protected function dbConnect(){
        // $bdd = new PDO('mysql:host=localhost;dbname=weekly_scheduler;charset=utf8', 'root', 'root');
        $db = new \PDO('mysql:host=localhost;dbname=weeky;charset=utf8', 'root', 'root');

        return $db;
    }
}