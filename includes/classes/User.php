<?php

class User {

    private $con;
    private $username;

    public function __construct ($con,$username) {
        $this->con= $con;
        $this->username=$username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getEmail(){
        $query=mysqli_query($this->con,"select email from users where username='$this->username'");
        $row=mysqli_fetch_array($query);
        return $row['email'];
    }

    public function getFirstandLastName(){
        $query=mysqli_query($this->con,"select concat(firstName,' ',lastName) as name from users where username='$this->username'");
        $row=mysqli_fetch_array($query);
        return $row['name'];
    }

}

?>