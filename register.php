<?php
include("includes/config.php");
 include("includes/classes/Account.php");
 include("includes/classes/Constants.php");
 $account=new Account($con);

 include("includes/handlers/register-handler.php");
 include("includes/handlers/login-handler.php");

 function getInputValue($name){
     if(isset($_POST[$name])){
         echo($_POST[$name]);
     }
 }

?>

<html>
<head>
	<title>Sangeet</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
<?php 

if (isset($_POST['registerButton'])) {
	echo '<script>$(document).ready(function() { 
		$("#loginForm").hide();
		$("#registerForm").show();
	});
	</script>';
}
else {
	echo '<script>$(document).ready(function() { 
		$("#loginForm").show();
		$("#registerForm").hide();
	});
	</script>';
}
?>
<div id="background">
<div id="loginContainer">
	<div id="inputContainer">
		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account</h2>
			<p>
			<?php echo $account->getError(Constants::$invalid); ?>
				<label for="loginUsername">Username</label>
				<input id="loginUsername" name="loginUsername" type="text" value="<?php getInputValue('loginUsername')?> " required>
			</p>
			<p>
				<label for="loginPassword">Password</label>
				<input id="loginPassword" name="loginPassword" type="password" required>
			</p>

			<button type="submit" name="loginButton">LOG IN</button>
			<div class="hasAccountText" >
			<span id="hideLogin" >Don't have an account ? Sign Up</span>
			</div>
			
		</form>



		<form id="registerForm" action="register.php" method="POST">
			<h2>Create your free account</h2>
			<p>
            <?php echo $account->getError(Constants::$udm); ?>
			<?php echo $account->getError(Constants::$udm1); ?>
				<label for="username">Username</label>
				<input id="username" name="username" type="text" value="<?php getInputValue('username') ?> " required>
			</p>

			<p>
				<label for="firstName">First name</label>
				<input id="firstName" name="firstName" type="text" value="<?php getInputValue('firstName') ?> " required>
			</p>

			<p>
				<label for="lastName">Last name</label>
				<input id="lastName" name="lastName" type="text" value="<?php getInputValue('lastName') ?> " required>
			</p>

			<p>
				<label for="email">Email</label>
				<input id="email" name="email" type="email" value="<?php getInputValue('email') ?> " required>
			</p>

			<p>
            <?php echo $account->getError(Constants::$pdm); ?>
            <?php echo $account->getError(Constants::$padm); ?>
				<label for="password">Password</label>
				<input id="password" name="password" type="password" required>
			</p>

			<p>
				<label for="cpassword">Confirm password</label>
				<input id="cpassword" name="cpassword" type="password" required>
			</p>

			<button type="submit" name="registerButton">SIGN UP</button>
			<div class="hasAccountText" >
			<span id="hideRegister" >Already have an account ? Log In</span>
			</div>

		</form>


	</div>
	<div id="loginText">
	<h1>Get great music,</h1>
	<h2>Listen for free</h2>
	<ul>
	<li>Discover</li>
	<li>Create</li>
	<li>Follow</li>
	</ul>
	</div>
</div>	
</div>
</body>
</html>