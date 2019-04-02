<?php

require_once('User.php');

class AddModifyDB extends User{

    public function addInfo($addWeekly){
        $user_id = $_SESSION['uid'];
        $view = $addWeekly['view'];
        $db= parent::dbConnect();
        $title = $addWeekly["title"];
        $description = $addWeekly["description"];
        $priority = $addWeekly["priority"];
        $eventDate = $addWeekly["eventDate"];
        $done = $addWeekly["done"];
        $addRequest = "INSERT INTO schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('$user_id', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $addToInfo = $db->prepare($addRequest);
        $addAfflines = $addToInfo->execute();
        header('location:http://localhost:8888/index.php?action='.$view);
    }

    public function modifyInfo($modWeekly){
        $user_id = $_SESSION['uid'];
        $db= parent::dbConnect();
        $title = $addWeekly["title"];
        $description = $addWeekly["description"];
        $priority = $addWeekly["priority"];
        $eventDate = $addWeekly["event_date"];
        $done = $addWeekly["is_done"];
        $modRequest = "UPDATE schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('$user_id', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $modifytoInfo = $db->prepare($modRequest);
        $modAffLines = $modifytoInfo->execute();
        return $modAffLines;
    }

    public function loadToDoList($user){
        $user_id = ($_SESSION['uid']) ? $_SESSION['uid'] : $user ;
        $db= $this->dbConnect();
        $req = $db->prepare('SELECT * FROM schedule WHERE user_id = :user_id AND is_simple= "0"');
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

    public function getSimpleSchedule($uid){

        $user_id = ($_SESSION['uid']) ? $_SESSION['uid'] : $uid ;
        $db= $this->dbConnect();
        $req = $db->prepare('SELECT * FROM schedule WHERE user_id = :user_id AND is_simple= "1"');
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
        return json_encode($events);
    }

}