<?php

require_once('model/ManagerDB.php');
require_once('model/Utils.php');

class User extends ManagerDB{

    protected function findByEmail($email){
        $db = parent::dbConnect();
        $findUserId = $db->prepare("SELECT internal_uid, first_name FROM internal_user WHERE email = :email");
        $findUserId->bindValue(":email",$email,PDO::PARAM_STR);
        $findUserId->execute();
        $internalUid = $findUserId->fetchAll();
        return $internalUid[0];
    }

    public function userLogout(){
        setcookie('rememberMeToken');
        setcookie('firstName');
        setcookie('uid');
        setcookie('userType');
        session_destroy();
        header("Location: index.php");
    }

    public function getUserInfo($uid, $userType){
        $db = parent::dbConnect();
        switch($userType){
            case 'internal':
                $findUser = $db->query("SELECT email, first_name FROM internal_user");
                return $findUser->fetchAll()[0];
                break;

            case 'google':
                $findUser = $db->query("SELECT email, first_name FROM google_user");
                return $findUser->fetchAll()[0];
                break;

            case 'kakao':
                $findUser = $db->query("SELECT email, first_name FROM kakao_user");
                return $findUser->fetchAll()[0];
                break;

            default:
                return null;
                break;
        }
    }
}

?>