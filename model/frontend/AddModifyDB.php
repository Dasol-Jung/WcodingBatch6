<?php

require_once('User.php');

class AddModifyDB extends User{

    public function addInfo($addWeekly){
        $user_id = $_SESSION['internalUid'];
        $db= parent::dbConnect();
        $title = $_POST["title"];
        $description = $_POST["description"];
        $priority = $_POST["priority"];
        $eventDate = $_POST["eventDate"];
        $done = $_POST["done"];
        $addRequest = "INSERT INTO schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('$user_id', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $addToInfo = $db->prepare($addRequest);
        $addAfflines = $addToInfo->execute();
        header('location:http://localhost:8888/index.php?action=weeklySchedule');
    }

    public function modifyInfo($modWeekly){
        $user_id = $_SESSION['internalUid'];
        $db= parent::dbConnect();
        $title = $_POST["title"];
        $description = $_POST["description"];
        $priority = $_POST["priority"];
        $eventDate = $_POST["event_date"];
        $done = $_POST["is_done"];
        $modRequest = "UPDATE schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('$user_id', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $modifytoInfo = $db->prepare($modRequest);
        $modAffLines = $modifytoInfo->execute();
        return $modAffLines;
    }

    public function loadToDoList($user){
        $user_id = ($_SESSION['internalUid']) ? $_SESSION['internalUid'] : $user ;
        $db= $this->dbConnect();
        $req = $db->prepare('SELECT * FROM schedule WHERE user_id = :user_id');
        $req->execute(array( 'user_id' => $user_id ));
        $events = array();
        while($data = $req -> fetch()){
            $eventsArray['id'] =  $data['schedule_id'];
            $eventsArray['user_id'] = $data['user_id'];
            $eventsArray['title'] = $data['title'];
            $eventsArray['description'] = $data['description'];
            $eventsArray['priority'] = $data['priority'];
            $eventsArray['start'] = $data['event_date'];
            $eventsArray['is_done'] = $data['is_done'];
            $events[] = $eventsArray;
        }
        echo json_encode($events);
    }

}