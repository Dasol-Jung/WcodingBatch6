<?php
require_once('model/ManagerDB.php');
//require_once('model/Utils.php');
class User extends ManagerDB{
    protected function findByEmail($email){
        $db = parent::dbConnect();
        $findUserId = $db->prepare("SELECT internal_uid, first_name FROM internal_user WHERE email = :email");
        $findUserId->bindValue(":email",$email,PDO::PARAM_STR);
        $findUserId->execute();
        $internalUid = $findUserId->fetchAll();
        return $internalUid[0];
    }
}
?>