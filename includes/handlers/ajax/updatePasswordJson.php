<?php

include("../../config.php");

if(!isset($_POST['username'])){
    echo "ERROR: Couldn't Set Password!";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])){
    echo "All Passwords Not Set!";
    exit();
}

if($_POST['oldPassword'] =="" || $_POST['newPassword1'] =="" || $_POST['newPassword2'] ==""){
    echo "Fill All Fields";
    exit();
}

$username=$_POST['username'];
$oldPassword=$_POST['oldPassword'];
$newPassword1=$_POST['newPassword1'];
$newPassword2=$_POST['newPassword2'];

$oldMd5=md5($oldPassword);

$passCheck=mysqli_query($con,"select * from users where username='$username' and password='$oldMd5'");
if(mysqli_num_rows($passCheck) !=1){
    echo "Incorrect Password!";
    exit();
}

if($newPassword1 != $newPassword2){
    echo "Password Didn't Match!";
    exit();
}

if(preg_match('/[^A-Za-z0-9]/',$newPassword1)){
    echo "Password Should Contain Letters And Numbers Only!";
    exit();
}

if(strlen($newPassword1)>15 || strlen($newPassword1)<3){
    echo "Password Should Be Between 5 To 15 Characters!";
    exit();
}

$newMd5=md5($newPassword1);

$query=mysqli_query($con,"update users set password='$newMd5' where username='$username'");
echo "Successfully Updated!";

?>