<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = new PDO('mysql:host=192.168.1.250:3306;dbname=weekly_scheduler;charset=utf8', 'weekly_scheduler_admin', 'forestOrange43Vita',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

function authenticate($db, $userId){

    $checkUser = $db->prepare("SELECT kakao_uid FROM kakao_user WHERE kakao_uid=:kakao_uid");
    $checkUser->bindParam(":kakao_uid",$userId, PDO::PARAM_STR);
    $checkUser->execute();
    
    if($checkUser->rowCount()){
        return true;
    }else{
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

$isAuthenticated = authenticate($db,10464082645);

if($isAuthenticated===true){
    echo "true";}
    else{
        echo $isAuthenticated;
    }

?>