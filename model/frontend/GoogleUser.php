<?php
while(ob_get_level()){
    ob_end_clean();
}
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);  

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

require_once("User.php");

class GoogleUser extends User
{
    public function getGoogle($googleId,$googleEmail){
        $db= parent::dbConnect();
        $searchGoogle = $db->prepare("SELECT * FROM google_user WHERE google_uid=$googleId AND email='$googleEmail'");
        $searchGoogle ->execute();
        if($googleUser=$searchGoogle->fetch()){
                $_SESSION['isLoggedIn']=true;
                $_SESSION['firstName']=$googleUser['first_name'];
                $_SESSION['google_uid']=$googleUser['google_uid'];
                
                    //create a token to remember the user
                    $rememberMeToken = uniqid("",true);
                    //save the token on database
                    $rememberMeQuery = 'UPDATE google_user SET remember_me_token = :remember_me_token WHERE google_uid=:google_uid';
                    $rememberMeReq = $db->prepare($rememberMeQuery);
                    $rememberMeReq->bindParam(":remember_me_token",$rememberMeToken,PDO::PARAM_STR);
                    $rememberMeReq->bindParam(":google_uid",$googleUser['google_uid'],PDO::PARAM_STR);
                    $rememberMeReq->execute();
                    setcookie('rememberMeToken', $rememberMeToken, time()+3600*24*365,'/');
                    setcookie('firstName', $googleUser['first_name'], time()+3600*24*365,'/');
                    setcookie('google_uid', $googleUser['google_uid'], time()+3600*24*365,'/');
                }
        return $googleUser;
    }

    public function registerGoogleUser($googleInfo){

        // connect db
        $db= parent::dbConnect();

        //set variables
        $googleAccessToken = $googleInfo["access_token"];
        $googleId = $googleInfo["google_id"];
        $googleFirstName = $googleInfo["first_name"];
        $googleLastName = $googleInfo["last_name"];
        $googleImage = $googleInfo["image_url"];
        $googleEmail = $googleInfo["email"];

        //find super uid

        $superUidFromDb = $this->findByUid($googleId)['super_uid'];

        //create super uid
        $superUid = $superUidFromDb!='' ? $superUidFromDb : uniqid("",true);

        //update google_user table
        $request = "INSERT INTO google_user
        (super_uid, google_uid, email, image, first_name, last_name, access_token, refresh_token, create_date, last_login_date, remember_me_token)
        VALUES('$superUid', '$googleId', '$googleEmail', '$googleImage', '$googleFirstName', '$googleLastName', '$googleAccessToken', NULL, current_timestamp(), current_timestamp(), NULL)
        ON DUPLICATE KEY UPDATE last_login_date = current_timestamp(), super_uid=super_uid";
        $reqCreateGoogle = $db->prepare($request);

        //update super_user table
        $userType = 'google';
        $superUserReq = $db->prepare("INSERT INTO super_user (super_uid, type, uid) VALUES (:super_uid, :type, :uid)
        ON DUPLICATE KEY UPDATE super_uid = super_uid");
        $superUserReq->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        $superUserReq->bindParam(":type", $userType, PDO::PARAM_STR);
        $superUserReq->bindParam(":uid", $googleId, PDO::PARAM_STR);

        if($reqCreateGoogle->execute() && $superUserReq->execute()){
            $_SESSION['isLoggedIn']=true;
            $_SESSION['firstName']=$googleFirstName;
            $_SESSION['uid']=$googleId;
            $_SESSION['userType']='google';
            $_SESSION['avatar']=$googleImage;
            $_SESSION['superUid']= $superUid;
            
            return 'success';
        }else{
            throw new Exception("Google Login Failed");
        }
    }

    public function connectGoogle($googleInfo){
       // connect db
       $db= parent::dbConnect();

       //set variables
       $googleAccessToken = $googleInfo["access_token"];
       $googleId = $googleInfo["google_id"];
       $googleFirstName = $googleInfo["first_name"];
       $googleLastName = $googleInfo["last_name"];
       $googleImage = $googleInfo["image_url"];
       $googleEmail = $googleInfo["email"];
       //create super uid
       $superUid = $_SESSION['superUid'];
       //get existing super uid

       $getCurrentSuperUid = $db->query("SELECT super_uid, uid FROM super_user WHERE uid='$googleId'");
       
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
        $userType = 'google';
        $superUserReq = $db->prepare("INSERT INTO super_user (super_uid, type, uid) VALUES (:super_uid, :type, :uid)
        ON DUPLICATE KEY UPDATE super_uid = '$superUid'
        ");
        $superUserReq->bindParam(":super_uid", $superUid, PDO::PARAM_STR);
        $superUserReq->bindParam(":type", $userType, PDO::PARAM_STR);
        $superUserReq->bindParam(":uid", $googleId, PDO::PARAM_STR);

       //update google_user table
       $request = "INSERT INTO google_user
       (super_uid, google_uid, email, image, first_name, last_name, access_token, refresh_token, create_date, last_login_date, remember_me_token)
       VALUES('$superUid', '$googleId', '$googleEmail', '$googleImage', '$googleFirstName', '$googleLastName', '$googleAccessToken', NULL, current_timestamp(), current_timestamp(), NULL)
       ON DUPLICATE KEY UPDATE last_login_date = current_timestamp(), super_uid='$superUid'";
       $reqCreateGoogle = $db->prepare($request);

       if($reqCreateGoogle->execute()&&$superUserReq->execute()){
         
           return 'success';
       }else{
           throw new Exception("Google Login Failed");
       }
    }

    public function findByUid($googleUid){

        $db= parent::dbConnect();
        $findByUidReq = $db->query("SELECT google_uid, email, image, first_name, super_uid FROM google_user WHERE google_uid='$googleUid'");
        return $findByUidReq->fetch();
        
    }
}