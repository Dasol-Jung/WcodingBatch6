<?php
/**
 * This class is for CRUD communication with database via kakao chatbot.
 * Response and request body will be only json.
 */
class ScheduleManager{

    private function dbConnect(){
        try{
            $db = new PDO('mysql:host=192.168.1.250:3306;dbname=weekly_scheduler;charset=utf8', 'weekly_scheduler_admin', 'forestOrange43Vita',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            return $db;
        }
        catch(Exception $e){
            $errorMessage = $e->getMessage();
            require('view/frontend/errorView.php');
        }
    }

    //read one day schedule from db

    public function readOneSchedule($userId, $date){

        $db= $this->dbConnect();
        $isAuthenticated = $this->authenticate($db,$userId);
        if($isAuthenticated===true){
            $getSchedule = $db->prepare("SELECT title, description FROM schedule WHERE user_id=:user_id AND event_date = :event_date");
            $getSchedule->bindParam(":user_id", $userId, PDO::PARAM_STR);
            $getSchedule->bindParam(":event_date", $date, PDO::PARAM_STR);
            if($getSchedule->execute()){
                $scheduleItems = [];
                while($scheduleInfo=$getSchedule->fetch(PDO::FETCH_ASSOC)){
                    $scheduleItems[]=["title"=>$scheduleInfo['title'], "description"=>$scheduleInfo['description']];
                }
                if(!empty($scheduleItems)){
                $chatResponse = json_decode('{
                    "version": "2.0",
                    "template": {
                      "outputs": [
                        {
                          "listCard": {
                            "header": {
                              "title": "스케줄입니다"
                            },
                            "items": []
                          }
                        }
                      ]
                    }
                  }',true);
                  $chatResponse["template"]["outputs"][0]["listCard"]["items"]=$scheduleItems;
                  return json_encode($chatResponse,JSON_UNESCAPED_UNICODE);
                }
                else{
                    $chatResponse = '
                    {
                        "version": "2.0",
                        "template": {
                            "outputs": [
                                {
                                    "simpleText": {
                                        "text": "일정이 없습니다"
                                    }
                                }
                            ]
                        }
                    }';
                    return $chatResponse;
                }
            }
        }else{
            return $isAuthenticated;
        }
    }

    //read one day schedule from db

    public function createSchedule($userId, $title, $date){

        $db= $this->dbConnect();
        $isAuthenticated = $this->authenticate($db,$userId);
        if($isAuthenticated===true){
            $addSchedule = $db->prepare("INSERT INTO schedule (title, event_date, user_id) VALUES(:title, :event_date, :user_id)");
            $addSchedule->bindParam(":user_id", $userId, PDO::PARAM_STR);
            $addSchedule->bindParam(":event_date", $date, PDO::PARAM_STR);
            $addSchedule->bindParam(":title", $title, PDO::PARAM_STR);
            if($addSchedule->execute()){
            
                $chatResponse = '
                {
                    "version": "2.0",
                    "template": {
                        "outputs": [
                            {
                                "simpleText": {
                                    "text": "일정이 추가되었습니다"
                                }
                            }
                        ]
                    }
                }';
                }
                else{
                    $chatResponse = '
                    {
                        "version": "2.0",
                        "template": {
                            "outputs": [
                                {
                                    "simpleText": {
                                        "text": "일정이 추가되지 않았습니다"
                                    }
                                }
                            ]
                        }
                    }';  
                }
                return $chatResponse;
            }
            else{
                return $isAuthenticated;
            }  
        }

        private function authenticate($db, $userId){

            $checkUser = $db->prepare("SELECT kakao_uid FROM kakao_user WHERE kakao_uid=:kakao_uid");
            $checkUser->bindParam(":kakao_uid",$userId, PDO::PARAM_STR);
            $checkUser->execute();
            if($checkUser->rowCount()){
                return true;
            }else{
                $signUpMsg = '
                {
                    "version": "2.0",
                    "template": {
                      "outputs": [
                        {
                          "basicCard": {
                            "title": "Weeky",
                            "description": "Weeky 가입하기",
                            "profile": {
                              "nickname": "가입하기"
                            },
                            "buttons": [
                              {
                                "action":  "webLink",
                                "label": "가입하기",
                                "webLinkUrl": "http://localhost:8888/index.php"
                              }
                            ]
                          }
                        }
                      ]
                    }
                  }';
                return $signUpMsg;
            }
        }
    }


?>