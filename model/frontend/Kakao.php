<?php

require_once("model/ManagerDB.php");

class KakaoUser extends ManagerDB{
    public function registerKakaoUser($kakaoUserInfo){
        $db = $this->dbConnect();
        $uid = $kakaoUserInfo['uid'];
        $registerData = $db->prepare("INSERT INTO user(uid, first_name, img, email, access_token, refresh_token, create_date) VALUES(:uid, :first_name, :img, :email, :access_token, :refresh_token, NOW())"); 

        $registerData -> bindParam(':uid', $uid, PDO::PARAM_INT);
        $registerData -> bindParam(':first_name', $kakaoUserInfo['first_name'], PDO::PARAM_STR);
        $registerData -> bindParam(':img', $kakaoUserInfo['img'], PDO::PARAM_STR);
        $registerData -> bindParam(':email', $kakaoUserInfo['email'], PDO::PARAM_STR);
        $registerData -> bindParam(':access_token', $kakaoUserInfo['accessToken'], PDO::PARAM_STR);
        $registerData -> bindParam(':refresh_token', $kakaoUserInfo['refreshToken'], PDO::PARAM_STR);
        $registerData->execute();
        return $this->searchKakaoUser($uid);
    }

    public function searchKakaoUser($uid){
        if(!$uid){
            throw new Exception("Your login has been failed");
        } else{
            $db = $this->dbConnect();
            $loginData = $db->prepare("SELECT * FROM user WHERE uid = $uid");
            $loginData->execute();
            $user = $loginData->fetch();
            return $user;
        }  
    }
}