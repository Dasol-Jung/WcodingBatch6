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

    public function changePersonalInfo($firstName, $avatar){
        $inputs = array("firstName"=>$firstName, "avatar"=>$avatar);
        $utils = new Utils();
        if($utils->validator($inputs)!=true){
            return "invalid";
            exit();
        }else{
            $db = parent::dbConnect();
            
            // save file to server
            if($avatar['size']>0){
                $fileUploadResult = $utils->fileUpload($avatar);
                if($fileUploadResult['isSuccess']){

                    //update DB

                    switch($_SESSION['userType']){
                        case 'internal':
                            $filePath = $fileUploadResult['filePath'];
                            $updatePersonalInfo = "UPDATE internal_user SET first_name=:firstName, image=:image WHERE internal_uid=:uid";
                            $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                            $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                            $updatePersonalInfoReq->bindValue(":image",$filePath, PDO::PARAM_STR);
                            $updatePersonalInfoReq->bindValue(":uid",$_SESSION['uid'], PDO::PARAM_STR);
                            break;

                        case "google":
                            $filePath = $fileUploadResult['filePath'];
                            $updatePersonalInfo = "UPDATE google_user SET first_name=:firstName, image=:image WHERE google_uid=:uid";
                            $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                            $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                            $updatePersonalInfoReq->bindValue(":image",$filePath, PDO::PARAM_STR);
                            $updatePersonalInfoReq->bindValue(":uid",$_SESSION['uid'], PDO::PARAM_STR);
                            break;

                        case "kakao":
                            $filePath = $fileUploadResult['filePath'];
                            $updatePersonalInfo = "UPDATE kakao_user SET first_name=:firstName, image=:image WHERE kakao_uid=:uid";
                            $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                            $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                            $updatePersonalInfoReq->bindValue(":image",$filePath, PDO::PARAM_STR);
                            $updatePersonalInfoReq->bindValue(":uid",$_SESSION['uid'], PDO::PARAM_STR);
                            break;

                        default;
                            break;
                    }

                    if($updatePersonalInfoReq->execute()){
                        //delete existing file
                        if($_SESSION['avatar']!='public/images/defaultUserImage.svg'){
                            unlink($_SESSION['avatar']);
                        }
                        //update session
                        $_SESSION['avatar']=$filePath;
                        return 'success';
                    }else{
                        return 'failure';
                    }
                    
                }else{
                    return 'failure';
                }
            }else{
                switch($_SESSION['userType']){
                    case 'internal':
                        
                        $updatePersonalInfo = "UPDATE internal_user SET first_name=:firstName WHERE internal_uid=:uid";
                        $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                        $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                        $updatePersonalInfoReq->bindValue(":uid",$_SESSION['uid'], PDO::PARAM_STR);
                        break;

                    case "google":
                        
                        $updatePersonalInfo = "UPDATE google_user SET first_name=:firstName WHERE google_uid=:uid";
                        $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                        $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                        $updatePersonalInfoReq->bindValue(":uid",$_SESSION['uid'], PDO::PARAM_STR);
                        break;

                    case "kakao":
                        
                        $updatePersonalInfo = "UPDATE kakao_user SET first_name=:firstName WHERE kakao_uid=:uid";
                        $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                        $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                        $updatePersonalInfoReq->bindValue(":uid",$_SESSION['uid'], PDO::PARAM_STR);
                        break;

                    default;
                        break;
                }
                if($updatePersonalInfoReq->execute()){
                    
                    return 'success';
                }else{
                    return 'failure';
                }
            }
        }
    }
}

?>