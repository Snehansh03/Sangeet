<?php 

function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "_", $inputText);
	return $inputText;
}

function sanitizeFormString($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}




if(isset($_POST['registerButton'])) {
	//Register button was pressed
	$username = sanitizeFormUsername($_POST['username']);
	$firstName = sanitizeFormString($_POST['firstName']);
    $lastName = sanitizeFormString($_POST['lastName']);
    $email = $_POST['email'];
    $password = sanitizeFormPassword($_POST['password']);
    $cpassword = sanitizeFormPassword($_POST['cpassword']);

    $wasSuccess=$account->register($username,$password,$cpassword,$firstName,$lastName,$email);

    if ($wasSuccess){
		$_SESSION['userLoggedIn']=$username;
        header("Location: index.php");
    }
}


?>