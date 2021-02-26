<?php
include("includes/includedFiles.php");

?>

<div class="entityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getFirstandLastName(); ?></h1>
        </div>
        <div class="buttonItems">
        <button class="button" onClick="openPage('updateDetails.php')">User Details</button>
        <button class="button" onClick="logout()">LogOut</button>
        </div>
    </div>
</div>