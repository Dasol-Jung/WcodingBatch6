<?php
     if(!isset($_SESSION)) 
     { 
         session_start(); 
     } 

    require_once('User.php');
    
    class InternalUser extends User{

        public function registerInternalUser($email,$password,$confirmPassword,$firstName){
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
            $_SESSION['isLoggedIn']=true;
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
                    $_SESSION['uid']=$user['internal_uid'];
                    $_SESSION['userType']='internal';
                    
                    if($keepLoggedIn){
                        //create a token to remember the user
                        $rememberMeToken = uniqid("",true);

                        //save the token on database
                        $rememberMeQuery = 'UPDATE internal_user SET remember_me_token = :remember_me_token WHERE internal_uid=:internal_uid';
                        $rememberMeReq = $db->prepare($rememberMeQuery);
                        $rememberMeReq->bindParam(":remember_me_token",$rememberMeToken,PDO::PARAM_STR);
                        $rememberMeReq->bindParam(":internal_uid",$user['internal_uid'],PDO::PARAM_STR);
                        $rememberMeReq->execute();

                        setcookie('rememberMeToken', $rememberMeToken, time()+3600*24*365,'/');
                        setcookie('firstName', $user['first_name'], time()+3600*24*365,'/');
                        setcookie('uid', $user['internal_uid'], time()+3600*24*365,'/');
                        setcookie('userType', 'internal', time()+3600*24*365,'/');
                    }
                    
                    return "success";

                }else{
                    return "User email or password is not correct";
                }
            }else{
                return "User email or password is not correct";
            }
        }

        public function checkRememberMe(){
            
            if(isset($_COOKIE['internal_uid']) && isset($_COOKIE['rememberMeToken'])){
                $db = parent::dbConnect();
                $checkRememberQuery = "SELECT internal_uid, first_name FROM internal_user WHERE internal_uid=:internal_uid AND remember_me_token =:remember_me_token";
                $checkRememberReq = $db->prepare($checkRememberQuery);
                $checkRememberReq->bindParam(":internal_uid",$_COOKIE['internal_uid'],PDO::PARAM_STR);
                $checkRememberReq->bindParam(":remember_me_token",$_COOKIE['rememberMeToken'],PDO::PARAM_STR);
                $checkRememberReq->execute();
                $user = $checkRememberReq->fetch(PDO::FETCH_ASSOC);
                $isRememberMeCookieValid = $user == false ? false : true;
                if($isRememberMeCookieValid==true){
                    $_SESSION['isLoggedIn']=true;
                    $_SESSION['firstName']=user['first_name'];
                    $_SESSION['uid']=$user['internal_uid'];
                    $_SESSION['userType']='internal';
                }
            }
        }
    }
?>