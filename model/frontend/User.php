<?php

require_once('model/ManagerDB.php');
require_once('model/Utils.php');

class User extends ManagerDB{

    protected function findByEmail($email){
        $db = parent::dbConnect();
        $findUserId = $db->prepare("SELECT internal_uid, first_name, super_uid FROM internal_user WHERE email = :email");
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
        $userType= htmlspecialchars($userType);
        $findUser = $db->query("SELECT email, first_name, setting_schedule_view FROM {$userType}_user WHERE {$userType}_uid='$uid'");
        return $findUser->fetchAll()[0];
    }

    public function changePersonalInfo($firstName, $avatar){
        $inputs = array("firstName"=>$firstName, "avatar"=>$avatar);
        $utils = new Utils();
        if($utils->validator($inputs)!=true){
            return "invalid";
            exit();
        }else{
            $db = parent::dbConnect();
            $userType = htmlspecialchars($_SESSION['userType']);
            $uid = htmlspecialchars($_SESSION['uid']);

            // save file to server
            if($avatar['size']>0){
                $fileUploadResult = $utils->fileUpload($avatar);
                if($fileUploadResult['isSuccess']){
                    
                    //update DB
                   
                    $filePath = $fileUploadResult['filePath'];
                    $updatePersonalInfo = "UPDATE {$userType}_user SET first_name=:firstName, image=:image WHERE {$userType}_uid=:uid";
                    $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                    $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                    $updatePersonalInfoReq->bindValue(":image",$filePath, PDO::PARAM_STR);
                    $updatePersonalInfoReq->bindValue(":uid",$uid, PDO::PARAM_STR);
                     
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

                $updatePersonalInfo = "UPDATE {$userType}_user SET first_name=:firstName WHERE {$userType}_uid=:uid";
                $updatePersonalInfoReq = $db->prepare($updatePersonalInfo);
                $updatePersonalInfoReq->bindValue(":firstName",$firstName, PDO::PARAM_STR);
                $updatePersonalInfoReq->bindValue(":uid",$uid, PDO::PARAM_STR);
                       
                if($updatePersonalInfoReq->execute()){
                    return 'success';
                }else{
                    return 'failure';
                }
            }
        }
    }

    public function getAvatars($superUid){

        // connect to db
        $db = parent::dbConnect();

        //find uids connected to a super uid

        $getUids = $db->query("SELECT * FROM super_user WHERE super_uid='$superUid'");
        $accounts = $getUids->fetchAll();
        $avatars = [];

        foreach($accounts AS $account){
           
            $avatarReq = $db->query("SELECT * FROM {$account['type']}_user WHERE super_uid='$superUid'");
            while($avatar = $avatarReq->fetch()){
                $avatars["{$account['type']}"][] = ['image'=>$avatar['image'], 'uid'=>$avatar["{$account['type']}_uid"]];
            }
                
        }
        return $avatars;
    }

    public function signOut($uid,$userType){

        // connect to db
        $db = parent::dbConnect();

            $signoutReq = $db->prepare("DELETE FROM {$userType}_user WHERE {$userType}_uid=:uid");
            $signoutReq->bindParam(":uid", $uid, PDO::PARAM_STR);
            $superSignOutReq = $db->prepare("DELETE FROM super_user WHERE uid=:uid");
            $superSignOutReq->bindParam(":uid", $uid, PDO::PARAM_STR);
            if($signoutReq->execute()&&$superSignOutReq->execute()){
                if($userType=='internal'&&$_SESSION['avatar']!='public/images/defaultUserImage.svg'){
                    unlink($_SESSION['avatar']);
                }
                setcookie('rememberMeToken');
                setcookie('firstName');
                setcookie('uid');
                setcookie('userType');
                session_destroy();
                return 'success';
            }else{
                return 'failure';
            }
                
    }

    public function switchAccount($superUid, $type){

            $db = parent::dbConnect();

            $userReq = $db->prepare("SELECT {$type}_uid, first_name, image FROM {$type}_user WHERE super_uid=:super_uid");
            $userReq->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
            if($userReq->execute()){
                $user = $userReq->fetch();
                $_SESSION['isLoggedIn']=true;
                $_SESSION['uid'] = $user["{$type}_uid"];
                $_SESSION['firstName'] = $user['first_name'];
                $_SESSION['userType'] = $type;
                $_SESSION['avatar'] = $user['image'];
                return 'success';
                
            }else{
                return 'failure';
            }
                   
    }

    public function changeUserSetting($value, $type, $userType, $superUid){

        // issue : setting column name dynamically isn't possible for now.
        // for now I set column name directly as setting_schedule_view

        $db = parent::dbConnect();
        $settingType = "setting_" . $type;

        $userReq = $db->prepare("UPDATE {$userType}_user SET ${settingType}=:settingValue WHERE super_uid=:super_uid");
        $userReq->bindParam(":settingValue", $value, PDO::PARAM_STR);
        $userReq->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        if($userReq->execute()){
            return 'success';
            
        }else{
            return 'failure';
        }      
    }

    public function disconnectAccount($userId, $userType, $superUid){
        $db = parent::dbConnect();
        $newSuperUid = uniqid("",true);

        //change superuid in super_user table
        $updateSuper = $db->prepare("UPDATE super_user SET super_uid=:new_super_uid WHERE super_uid=:super_uid AND uid=:uid");
        $updateSuper->bindValue(":new_super_uid", $newSuperUid, PDO::PARAM_STR);
        $updateSuper->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        $updateSuper->bindParam(":uid", $userId, PDO::PARAM_STR);

        //change superuid in each user table
        $updateIndividual = $db->prepare("UPDATE {$userType}_user SET super_uid=:new_super_uid WHERE super_uid=:super_uid AND {$userType}_uid=:uid");
        $updateIndividual->bindValue(":new_super_uid", $newSuperUid, PDO::PARAM_STR);
        $updateIndividual->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        $updateIndividual->bindParam(":uid", $userId, PDO::PARAM_STR);

        if($updateSuper->execute() && $updateIndividual->execute()){
            if($_SESSION['userType'] == $userType){
                $_SESSION['superUid'] = $newSuperUid;
            }
            return 'success';
            
        }else{
            return 'failure';
        }      
    }
}

?>