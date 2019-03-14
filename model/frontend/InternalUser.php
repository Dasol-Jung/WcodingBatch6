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

        public function login($email,$password,$keepLoggedIn){
            $db = parent::dbConnect();
            $emailCleaned = addslashes(htmlspecialchars(htmlentities(trim($email))));
            $findUserQuery = 'SELECT email, password, first_name, internal_uid FROM internal_user WHERE email=:email';
            $findUser = $db->prepare($findUserQuery);
            $findUser->bindParam(":email",$emailCleaned,PDO::PARAM_STR);
            $findUser->execute();
            if($user=$findUser->fetch()){
                
                if(password_verify($password,$user['password'])){
                    $_SESSION['isLoggedIn']=true;
                    $_SESSION['firstName']=$user['first_name'];
                    $_SESSION['internalUid']=$user['internal_uid'];
                    
                    if($keepLoggedIn){
                        setcookie('keepLoggedIn', true, time()+3600*24*365,'/');
                        setcookie('firstName', $user['first_name'], time()+3600*24*365,'/');
                        setcookie('internalUid', $user['internal_uid'], time()+3600*24*365,'/');
                    }
                    
                    return "success";
                }else{
                    return "User email or password is not correct";
                }
            }else{
                return "User email or password is not correct";
            }
        }
    }
?>