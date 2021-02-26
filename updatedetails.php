<?php

include("includes/includedFiles.php");

?>

<div class="userDetails">

    <div class="container borderBottom">
        <h2>Email</h2>
        <input type="email" class="email" name="email" placeholder="Enter Email..." value="<?php echo $userLoggedIn->getEmail(); ?>">
        <span class="message"></span>
        <button class="button" onClick="updateEmail('email')">Save</button>
    </div>
    <div class="container">
        <h2>Password</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Enter Current Password..." >
        <input type="password" class="newPassword1" name="newPassword1" placeholder="Enter New Password..." >
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Enter Confirm Password..." >
        <span class="message"></span>
        <button class="button" onClick="updatePassword('oldPassword','newPassword1','newPassword2')">Update Password</button>
    </div>



</div>