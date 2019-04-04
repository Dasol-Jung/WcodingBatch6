<?php

require_once('User.php');

class AddModifyDB extends User{

    public function addEditSchedule($date,$uid){

        $user_id = isset($_SESSION['uid']) ? $_SESSION['uid'] : $uid;
        $title = htmlspecialchars($date["title"]);
        $scheduleId = htmlspecialchars($date["scheduleId"]);
        $description = htmlspecialchars($date["description"]);
        $priority = htmlspecialchars($date["priority"]);
        $eventDate = htmlspecialchars($date["eventDate"]);
        $isDone = htmlspecialchars($date["done"]);
        // find current schedule
        $db= parent::dbConnect();
        $findCurrent = $db->prepare("SELECT * FROM schedule WHERE user_id=:user_id AND schedule_id=:schedule_id");
        $findCurrent->bindParam(":user_id",$user_id,PDO::PARAM_STR);
        $findCurrent->bindParam(":schedule_id",$scheduleId,PDO::PARAM_STR);
        $findCurrent->execute();
        if($findCurrent->fetch()){
            $updateReq = "UPDATE schedule SET title=:title, description=:description, priority=:priority, event_date=:event_date, is_done=:is_done, create_date=NOW() WHERE user_id=:user_id AND schedule_id=:schedule_id";
            $updateSchedule = $db->prepare($updateReq);
            $updateSchedule->bindParam(":title",$title,PDO::PARAM_STR);
            $updateSchedule->bindParam(":description",$description,PDO::PARAM_STR);
            $updateSchedule->bindParam(":priority",$priority,PDO::PARAM_STR);
            $updateSchedule->bindParam(":event_date",$eventDate,PDO::PARAM_STR);
            $updateSchedule->bindParam(":is_done",$isDone,PDO::PARAM_STR);
            $updateSchedule->bindParam(":user_id",$user_id,PDO::PARAM_STR);
            $updateSchedule->bindParam(":schedule_id",$scheduleId,PDO::PARAM_STR);
            $updateSchedule->execute();
        }else{
            $addRequest = "INSERT INTO schedule(user_id, title, description, priority, event_date, is_done, create_date)
            VALUES('$user_id', '$title', '$description', '$priority', '$eventDate', '$isDone',NOW())";
            $addSchedule = $db->prepare($addRequest);
            $addSchedule->execute();
        }
        // header("Location:http://localhost:8888/index.php?action=monthlySchedule");
    }

    public function loadToDoList($user){
        $user_id = ($_SESSION['uid']) ? $_SESSION['uid'] : $user ;
        $db= $this->dbConnect();
        $req = $db->prepare('SELECT * FROM schedule WHERE user_id = :user_id AND is_simple= "0"');
        $req->execute(array( 'user_id' => $user_id ));
        $events = array();
        while($data = $req -> fetch()){
            $eventsArray['schedule_id'] = $data['schedule_id'];
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
            $eventsArray['schedule_id'] =  $data['schedule_id'];
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

    public function addSimpleSchedule($title,$desc, $uid){

        $title=htmlspecialchars($title);
        $desc=htmlspecialchars($desc);
        $user_id = ($_SESSION['uid']) ? $_SESSION['uid'] : $uid ;
        $db= $this->dbConnect();
        try{
            $req = $db->prepare('INSERT INTO schedule (title,description,is_simple,user_id) VALUES(:title,:desc, "1",:user_id)');
        }
        catch(Exception $e){
            return $e;
        }
        $req->bindParam(":title",$title,PDO::PARAM_STR);
        $req->bindParam(":desc",$desc,PDO::PARAM_STR);
        $req->bindParam(":user_id",$user_id,PDO::PARAM_STR);
        try{
            $req->execute();
        }catch(Exception $e){
            return $e;
        }
        return 'success';
    }

    public function changeDate($scheduleId,$date, $uid){

        $scheduleId=htmlspecialchars($scheduleId);
        $date=htmlspecialchars($date);
        $user_id = ($_SESSION['uid']) ? $_SESSION['uid'] : $uid ;
        $db= $this->dbConnect();
        try{
            $req = $db->prepare('UPDATE schedule SET event_date=:date, is_simple=0 WHERE user_id=:user_id AND schedule_id=:schedule_id');
        }
        catch(Exception $e){
            return $e;
        }
        $req->bindParam(":date",$date,PDO::PARAM_STR);
        $req->bindParam(":user_id",$user_id,PDO::PARAM_STR);
        $req->bindParam(":schedule_id",$scheduleId,PDO::PARAM_STR);
        try{
            $req->execute();
        }catch(Exception $e){
            return $e;
        }
        return 'success';
    }
}