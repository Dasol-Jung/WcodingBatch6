<?php
require_once("../../model/ManagerDB.php");
class GoogleUserManager extends ManagerDB
{
    public function getGoogle($googleProfileInfo){
        $bdd = $this->dbConnect();

        $searchGoogle = $bdd->prepare("SELECT * FROM google");
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
        // INSERT INTO IF NOT EXISTS google(google_uid, email, image, first_name, last_name, create_date, last_login_date) VALUES ($googleToken, $googleEmail, $googleImage, $googleFirstName, $googleLastName, NOW(), NOW());
        $createGoogle = $bdd->prepare("INSERT INTO google (google_uid, email, image, first_name, last_name, create_date, last_login_date)
        SELECT * FROM (SELECT $googleToken, $googleEmail, $googleImage, $googleFirstName, $googleLastName, NOW(), NOW()) AS gtmp
        WHERE NOT EXISTS (SELECT google_uid FROM google WHERE google_uid = $googleToken) LIMIT 1;");
        $createGoogle ->execute(array($googleInfo));
        return $createGoogle;
    }
}