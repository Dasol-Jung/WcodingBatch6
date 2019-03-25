<?php

require_once('User.php');

class AddModifyButton extends User{

    public function addInfo($addWeekly){
        $db= parent::dbConnect();
        $title = $addWeekly["title"];
        $description = $addWeekly["description"];
        $priority = $addWeekly["priority"];
        $startpm = $addWeekly["start"];
        $endpm = $addWeekly["end"];
        $done = $addWeekly["is_done"];
        // $repeat = $addWeekly["repeat"];
        $addRequest = "INSERT INTO schedule(user_id, title, description, priority, start, end, is_done,create_date)
        VALUES('12345678','$title','$description','$priority','$start','$end','$done',NOW())";
        $addToInfo = $db->prepare($addRequest);
        $addAfflines = $addToInfo->execute();
        return $addAfflines;
    }

    public function modifyInfo($modWeekly){
        $db= parent::dbConnect();
        $title = $addWeekly["title"];
        $description = $addWeekly["description"];
        $priority = $addWeekly["priority"];
        $start = $addWeekly["start"];
        $end = $addWeekly["end"];
        $done = $addWeekly["is_done"];
        // $repeat = $addWeekly["repeat"];
        $modRequest = "UPDATE schedule(user_id, title, description, priority, start, end, is_done,create_date)
        VALUES('12345678','$title','$description','$priority','$start','$end','$done',NOW())";
        $modifytoInfo = $db->prepare($modRequest);
        $modAffLines = $modifytoInfo->execute();
        return $modAffLines;
    }


//     public function addInfo($email,$password,$confirmPassword,$firstName){
//         $db= parent::dbConnect();
//         $inputs = array("title"=>"$title",
//                     "description"=> $description,
//                     "date"=>$date,
//                     "description"=> $description,
//                     "done"=>$done,
//                     "repeat"=>$repeat);

//         $addQuery ="SELECT * FROM schedule WHERE title = :title";
//         $addButt = $db->prepare($addQuery);
//         $addButt->execute();
//         $addButt = $checkExistsReq->fetch();
//         return $addButt;
//     }
// }