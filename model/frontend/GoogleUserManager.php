<?php
require_once("model/ManagerDB.php");
class GoogleUserManager extends ManagerDB
{
    public function getGoogle($googleProfileInfo){
        $bdd = $this->dbConnect();

        $searchGoogle = $bdd->prepare("SELECT * FROM google_user");
        $searchGoogle ->execute(array($googleProfileInfo));
        return $searchGoogle;
    }

    public function makeGoogle($googleInfo){
        $bdd = $this->dbConnect();
        $googleToken = $googleInfo["google_id"];
        $googleFirstName = $googleInfo["first_name"];
        $googleLastName = $googleInfo["last_name"];
        $googleImage = $googleInfo["image_url"];
        $googleEmail = $googleInfo["email"];
        $request = "INSERT INTO weekly_scheduler.google_user
        (super_uid, google_uid, email, image, first_name, last_name, access_token, refresh_token, create_date, last_login_date, remember_me_token)
        VALUES(NULL, '$googleToken', '$googleEmail', '$googleImage', '$googleFirstName', '$googleLastName', NULL, NULL, current_timestamp(), current_timestamp(), NULL)
        ";

        //$createGoogle = $bdd->prepare("INSERT INTO google_user (google_uid, email, image, first_name, last_name) VALUES ('$googleToken', '$googleEmail', '$googleImage', '$googleFirstName', '$googleLastName'");
        //print_r($createGoogle);

        $createGoogle = $bdd->prepare($request);
        print_r($createGoogle);
        $test = $createGoogle->execute();
        return $test;
    }
}