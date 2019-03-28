<?php
function loadToDoList($user){
    $user_id = $_SESSION['internalUid'];
    $db= parent::dbConnect();
    $req = $db->prepare('SELECT * FROM schedule WHERE user_id = :user_id');
    $req->execute(array( 'user_id' => $user_id ));
    $events = array();
    while($data = $req -> fetch()){
        $eventsArray['schedule_id'] =  $data['schedule_id'];
        $eventsArray['user_id'] = "5c9af6277acf25.70313808";
        $eventsArray['title'] = $data['title'];
        $eventsArray['description'] = $data['description'];
        $eventsArray['priority'] = $data['priority'];
        $eventsArray['event_date'] = date($data['event_date']);
        $eventsArray['is_done'] = $data['is_done'];
        $events[] = $eventsArray;
    }
    echo json_encode($events);
}