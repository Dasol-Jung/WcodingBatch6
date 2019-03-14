<?php
    session_start();
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);  
    require_once('User.php');
    class InternalUser extends User{

        public function userSignUp($email,$password,$confirmPassword,$firstName){
            $db= parent::dbConnect();
            $inputs = array("email"=>"$email", "password"=> $password, "confirmPassword"=>$confirmPassword, "firstName"=>$firstName);
            $utils = new Utils();
            if($utils->validator($inputs)!=true){
                return "Sign up failed";
                exit();
            }

            //check if user email already exists
            $emailCleaned = addslashes(htmlspecialchars(htmlentities(trim($email))));
            $checkExistsQuery = 'SELECT * FROM internal_user WHERE email = :email';
            $checkExistsReq = $db->prepare($checkExistsQuery);
            $checkExistsReq->bindParam(":email", $emailCleaned, PDO::PARAM_STR);
            $checkExistsReq->execute();
            $result = $checkExistsReq->fetch();
            if($result!=''){
                return "The email already exists";
                exit();
            }
            //hash password
            $passwordHashed = password_hash($password,PASSWORD_DEFAULT);
            $userId = uniqid("",true);
            $firstNameCleaned = htmlspecialchars($firstName);

            $signUpReq = $db->prepare("INSERT INTO internal_user (internal_uid, email, password, first_name) VALUES (:userId, :email, :password, :first_name)");
            $signUpReq->bindParam(":userId", $userId, PDO::PARAM_STR);
            $signUpReq->bindParam(":email", $emailCleaned, PDO::PARAM_STR);
            $signUpReq->bindParam(":password", $passwordHashed, PDO::PARAM_STR);
            $signUpReq->bindParam(":first_name", $firstNameCleaned, PDO::PARAM_STR);
            $signUpReq->execute();

            //find user id by email and set session;
            $_SESSION['internalUid'] = parent::findByEmail($emailCleaned)['internal_uid'];
            $_SESSION['firstName'] = parent::findByEmail($emailCleaned)['first_name'];
            return "success";
        }
    }
?>