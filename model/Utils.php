<?php

class Utils{

    /**
     * validator : validate inputs
     * @param : (associative array) ["inputName"=>"value", ...]
     * @return (boolean) return true if all input values are valid
     */
    public function validator($arr){
        $passwordReg = "/^(?=.{8,})(?=.*[!@#\$%\^&\*])(?=.*[a-z])(?=.*[0-9])/";
        $emailReg = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        $firstNameReg = "/^(?=.{1,})/";

        foreach($arr as $inputName=>$value){
            switch($inputName){
                case "email":
                    if(!preg_match($emailReg,$value)){
                        return false;
                    }
                    break;

                case "password":
                    if(!preg_match($passwordReg,$value)){
                        return false;
                    }
                    break;
                case "confirmPassword":
                    if(!preg_match($passwordReg,$value) || $arr['password']!=$value){
                        return false;
                    }
                    break;
                case "firstName":
                    if(!preg_match($firstNameReg,$value)){
                        return false;
                    }
                    break;
                default:
                    break;
            }
        }
        return true;
    }
}