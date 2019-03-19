<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
require_once("User.php");
class GoogleUserManager extends User
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

    public function makeGoogle($googleInfo){
        $db= parent::dbConnect();
        $googleAccessToken = $googleInfo["access_token"];
        $googleId = $googleInfo["google_id"];
        $googleFirstName = $googleInfo["first_name"];
        $googleLastName = $googleInfo["last_name"];
        $googleImage = $googleInfo["image_url"];
        $googleEmail = $googleInfo["email"];
        $request = "INSERT INTO weekly_scheduler.google_user
        (super_uid, google_uid, email, image, first_name, last_name, access_token, refresh_token, create_date, last_login_date, remember_me_token)
        VALUES(NULL, '$googleId', '$googleEmail', '$googleImage', '$googleFirstName', '$googleLastName', '$googleAccessToken', NULL, current_timestamp(), current_timestamp(), NULL)
        ON DUPLICATE KEY UPDATE last_login_date = current_timestamp()";
        $reqCreateGoogle = $db->prepare($request);
        $googleAffectedLines = $reqCreateGoogle->execute();
        return $this->getGoogle($googleId, $googleEmail);
    }
}