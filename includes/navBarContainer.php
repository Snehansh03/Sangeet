<div id="navBarContainer">
<nav class="navBar">
<span role="link" tabindex="0" onClick="openPage('index.php')" class="logo"><img src="assets/images/icons/logo.png"></span>
<div class="group">
<div class="navItem">
<span role="link" tabindex="0" onClick="openPage('search.php')" class="navItemLink" >Search <img src="assets/images/icons/search.png" class="icon" alt="Search"></span>
</div>
</div>
<div class="group">
<div class="navItem">
<span role="link" tabindex="0" onClick="openPage('browse.php')" class="navItemLink" >Browse</span>
</div>
<div class="navItem">
<span role="link" tabindex="0" onClick="openPage('yourmusic.php')" class="navItemLink" >Your Music</span>
</div>
<div class="navItem">
<span role="link" tabindex="0" onClick="openPage('profile.php')" class="navItemLink" ><?php echo $userLoggedIn->getUsername(); ?></span>
</div>
</div>
</nav>
</div>