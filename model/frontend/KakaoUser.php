<?php

require_once("model/ManagerDB.php");

class KakaoUser extends ManagerDB{

    public function registerKakaoUser($kakaoUserInfo){
        $db = $this->dbConnect();
        $uid = $kakaoUserInfo['uid'];
        $registerData = $db->prepare("INSERT INTO kakao_user(kakao_uid, first_name, image, email, access_token, refresh_token, create_date, last_login_date, super_uid) VALUES(:kakao_uid, :first_name, :image, :email, :access_token, :refresh_token, NOW(), NOW(), :super_uid)
        ON DUPLICATE KEY UPDATE last_login_date = current_timestamp()
        "); 

        //create super uid
        $superUid = uniqid("",true);

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
            $_SESSION['superUid']=$superUid;
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
}