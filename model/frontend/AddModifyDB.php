<?php

require_once('User.php');

class AddModifyDB extends User{

    public function addInfo($addWeekly){
        $db= parent::dbConnect();
        $title = $_POST["title"];
        $description = $_POST["description"];
        $priority = $_POST["priority"];
        $eventDate = $_POST["eventDate"];
        $done = $_POST["done"];
        $addRequest = "INSERT INTO schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('12345678', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $addToInfo = $db->prepare($addRequest);
        $addAfflines = $addToInfo->execute();
        return $addAfflines;
    }

    public function modifyInfo($modWeekly){
        $db= parent::dbConnect();
        $title = $_POST["title"];
        $description = $_POST["description"];
        $priority = $_POST["priority"];
        $eventDate = $_POST["event_date"];
        $done = $_POST["is_done"];
        $modRequest = "UPDATE schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('12345678', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $modifytoInfo = $db->prepare($modRequest);
        $modAffLines = $modifytoInfo->execute();
        return $modAffLines;
    }


    
}