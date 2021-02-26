<?php

if(isset($_POST['loginButton'])) {

    $un=$_POST['loginUsername'];
    $pw=$_POST['loginPassword'];

    $result=$account->login($un,$pw);

    if($result){
        $_SESSION['userLoggedIn']=$un;
        header("Location: index.php");
    }
}
?>