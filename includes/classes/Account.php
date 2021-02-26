<?php

class Account {

    private $con;
    private $errorArray;

    public function __construct ($con) {
        $this->con= $con;
        $this->errorArray=array();
    }

    public function login($un,$pw){
        $pw=md5($pw);

        $query=mysqli_query($this->con,"SELECT * FROM users WHERE username='$un' AND password='$pw'");

        if(mysqli_num_rows($query)==1){
            return true;
        }
        else{
            array_push($this->errorArray,Constants::$invalid);
            return false;
        }
    }

    public function register($un,$p,$pa,$fn,$ln,$em) {
        $this->validateUsername($un);
        $this->validatePassword($p,$pa);

        if (empty($this->errorArray)){

            return $this->getUserDetails($un,$fn,$ln,$em,$p);
        }
        else{
            return false;
        }
    }

    public function getError($error){
        if (!in_array($error,$this->errorArray)){
            $error="";    
        }
        return "<span class='errorMessage' style='color: #07d159'>$error</span>";
    }

    private function getUserDetails($un,$fn,$ln,$em,$pw){
        $encryptedpw=md5($pw);
        $profilepic="assets/images/profile-pic/head_emerald.png";
        $date=date("Y-m-d");

        $result=mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un' , '$fn' ,'$ln' ,'$em' ,'$encryptedpw','$date', '$profilepic' )");

        return $result;
    }

    private function validateUsername($un){
        if (strlen($un)>15 || strlen($un)<5){
            array_push($this->errorArray,Constants::$udm);
            return;
        }

        $checkuser=mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
        if(mysqli_num_rows($checkuser) !=0){
            array_push($this->errorArray,Constants::$udm1);
            return;
        }
    }

    private function validatePassword($pass, $pass1){
        if ($pass != $pass1){
            array_push($this->errorArray,Constants::$pdm);
            return;
        }
        if (preg_match('/[^A-Za-z0-9]/',$pass)){
            array_push($this->errorArray,Constants::$padm);
            return;
        }
    }

}

?>