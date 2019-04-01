<?php

require_once('User.php');

class AddModifyDB extends User{

    public function addInfo($addWeekly){
        $user_id = $_SESSION['uid'];
        $view = $addWeekly['view'];
        $db= $this->dbConnect();
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
        $db= $this->dbConnect();
        $title = $modWeekly["title"];
        $description = $modWeekly["description"];
        $priority = $modWeekly["priority"];
        $eventDate = $modWeekly["event_date"];
        $done = $modWeekly["is_done"];
        $modRequest = "UPDATE schedule(user_id, title, description, priority, event_date, is_done, create_date)
        VALUES('$user_id', '$title', '$description', '$priority', '$eventDate', '$done',NOW())";
        $modifytoInfo = $db->prepare($modRequest);
        $modAffLines = $modifytoInfo->execute();
        return $modAffLines;
    }

    public function loadToDoList($user){
        $user_id = ($_SESSION['uid']) ? $_SESSION['uid'] : $user ;
        $db= $this->dbConnect();
        $req = $db->prepare('SELECT * FROM schedule WHERE user_id = :user_id');
        $req->execute(array( 'user_id' => $user_id ));
        $events = array();
        while($data = $req -> fetch()){
            $extProps = [];
            $extProps['user_id'] = $data['user_id'];
            $extProps['description'] = $data['description'];

            $eventsArray =[];
            $eventsArray['id'] =  $data['schedule_id'];
            $eventsArray['title'] = $data['title'];
            $classStatus = ($data['is_done']) ? "isDone" : "notDone";
            $eventsArray['classNames'] = $data['priority']."-priority " . $classStatus ;
            $eventsArray['start'] = $data['event_date'];
            $eventsArray['extendedProps'] = $extProps;

            $events[] = $eventsArray;
        }
       
        echo json_encode($events);
    }

}