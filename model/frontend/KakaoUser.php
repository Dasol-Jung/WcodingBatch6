<?php
require_once("model/ManagerDB.php");

class KakaoUser extends ManagerDB{

    public function registerKakaoUser($kakaoUserInfo){
        $db = $this->dbConnect();
        $uid = $kakaoUserInfo['uid'];
        $registerData = $db->prepare("INSERT INTO kakao_user(kakao_uid, first_name, image, email, access_token, refresh_token, create_date, last_login_date, super_uid) VALUES(:kakao_uid, :first_name, :image, :email, :access_token, :refresh_token, NOW(), NOW(), :super_uid)
        ON DUPLICATE KEY UPDATE last_login_date = current_timestamp(), super_uid=super_uid
        "); 

        //find super uid

        $superUidFromDb = $this->findByUid($uid)['super_uid'];

        //create super uid
        $superUid = $superUidFromDb ? $superUidFromDb : uniqid("",true);

        //update kakao_user table
        $registerData -> bindParam(':kakao_uid', $uid, PDO::PARAM_INT);
        $registerData -> bindParam(':first_name', $kakaoUserInfo['first_name'], PDO::PARAM_STR);
        $registerData -> bindParam(':image', $kakaoUserInfo['img'], PDO::PARAM_STR);
        $registerData -> bindParam(':email', $kakaoUserInfo['email'], PDO::PARAM_STR);
        $registerData -> bindParam(':access_token', $kakaoUserInfo['accessToken'], PDO::PARAM_STR);
        $registerData -> bindParam(':refresh_token', $kakaoUserInfo['refreshToken'], PDO::PARAM_STR);
        $registerData -> bindParam(':super_uid', $superUid, PDO::PARAM_STR);

        //update super_user table

        $userType = 'kakao';
        $superUserReq = $db->prepare("INSERT INTO super_user (super_uid, type, uid) VALUES (:super_uid, :type, :uid)
        ON DUPLICATE KEY UPDATE super_uid = super_uid
        ");
        $superUserReq->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        $superUserReq->bindParam(":type", $userType, PDO::PARAM_STR);
        $superUserReq->bindParam(":uid", $uid, PDO::PARAM_STR);

        if($registerData->execute() && $superUserReq->execute()){
            $_SESSION['isLoggedIn']=true;
            $_SESSION['firstName']=$kakaoUserInfo['first_name'];
            $_SESSION['uid']=$uid;
            $_SESSION['superUid']=$superUidFromDb;
            $_SESSION['userType']='kakao';
            $_SESSION['avatar']=$kakaoUserInfo['img'];
            return 'success';
        }
        else{
            return "Something went wrong";
            exit();
        }
    }

    public function searchKakaoUser($uid){
        if(!$uid){
            throw new Exception("Your login has been failed");
        } else{
            $db = $this->dbConnect();
            $loginData = $db->prepare("SELECT * FROM kakao_user WHERE kakao_uid = $uid");
            $loginData->execute();
            $user = $loginData->fetch();
            return $user;
        }  
    }

    public function connectKakao($kakaoUserInfo){
        // connect db
        $db = $this->dbConnect();
        $uid = $kakaoUserInfo['uid'];

        //create super uid
        $superUid = $_SESSION['superUid'];

        //get existing super uid

        $getCurrentSuperUid = $db->query("SELECT super_uid, uid FROM super_user WHERE uid='$uid'");
       
        if($currentSuperUid=$getCurrentSuperUid->fetch()['super_uid']){
            
            $updateConnectedAcct = $db->prepare("UPDATE super_user SET super_uid=:super_uid WHERE super_uid=:currentSuperUid");
            $updateConnectedAcct->bindParam(":super_uid",$superUid,PDO::PARAM_STR);
            $updateConnectedAcct->bindParam(":currentSuperUid",$currentSuperUid,PDO::PARAM_STR);
            $updateConnectedAcct->execute();

            $updateKakaoTable = $db->prepare("UPDATE kakao_user SET super_uid=:super_uid WHERE super_uid=:currentSuperUid");
            $updateKakaoTable->bindParam(":super_uid",$superUid,PDO::PARAM_STR);
            $updateKakaoTable->bindParam(":currentSuperUid",$currentSuperUid,PDO::PARAM_STR);
            $updateKakaoTable->execute();

            $updateInternalTable = $db->prepare("UPDATE internal_user SET super_uid=:super_uid WHERE super_uid=:currentSuperUid");
            $updateInternalTable->bindParam(":super_uid",$superUid,PDO::PARAM_STR);
            $updateInternalTable->bindParam(":currentSuperUid",$currentSuperUid,PDO::PARAM_STR);
            $updateInternalTable->execute();

        }
        //insert into super_user table
        $userType = 'kakao';
        $superUserReq = $db->prepare("INSERT INTO super_user (super_uid, type, uid) VALUES (:super_uid, :type, :uid)
        ON DUPLICATE KEY UPDATE super_uid = '$superUid'
        ");
        $superUserReq->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        $superUserReq->bindParam(":type", $userType, PDO::PARAM_STR);
        $superUserReq->bindParam(":uid", $uid, PDO::PARAM_STR);

        $registerData = $db->prepare("INSERT INTO kakao_user(kakao_uid, first_name, image, email, access_token, refresh_token, create_date, last_login_date, super_uid) VALUES(:kakao_uid, :first_name, :image, :email, :access_token, :refresh_token, NOW(), NOW(), :super_uid)
        ON DUPLICATE KEY UPDATE last_login_date = current_timestamp(), super_uid='$superUid'
        "); 

        //update kakao_user table
        $registerData -> bindParam(':kakao_uid', $uid, PDO::PARAM_INT);
        $registerData -> bindParam(':first_name', $kakaoUserInfo['first_name'], PDO::PARAM_STR);
        $registerData -> bindParam(':image', $kakaoUserInfo['img'], PDO::PARAM_STR);
        $registerData -> bindParam(':email', $kakaoUserInfo['email'], PDO::PARAM_STR);
        $registerData -> bindParam(':access_token', $kakaoUserInfo['accessToken'], PDO::PARAM_STR);
        $registerData -> bindParam(':refresh_token', $kakaoUserInfo['refreshToken'], PDO::PARAM_STR);
        $registerData -> bindParam(':super_uid', $superUid, PDO::PARAM_STR);
 

        if($registerData->execute()&&$superUserReq->execute()){
            return 'success';
        }else{
            return "Something went wrong";
        }
    }

    public function findByUid($kakaoUid){

        $db= parent::dbConnect();
        $findByUidReq = $db->query("SELECT kakao_uid, email, image, first_name, super_uid FROM kakao_user WHERE kakao_uid='$kakaoUid'");
        return $findByUidReq->fetch();
        
    }
}