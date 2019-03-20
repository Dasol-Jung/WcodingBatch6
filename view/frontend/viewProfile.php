<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$styles[]= "<link rel='stylesheet' href='public/css/profile.css'/>";
ob_start();
?>

<div class="bodyWrapper">

<form class="profileForm" action="index.php" method="POST">

    <label for="email">Email</label>
    <input value="" name="email" id="email" type="email"/>
    <span class='error' id='error_email'></span>

    <label for="changePassword">Password</label>
    <button id="changePassword">Change Password</button>

    <fieldset>
    <legend>Personal Info</legend>
    <label for="firstName">First Name</label>
    <input value='' name="firstName" id="firstName" type="text"/>
    <span class='error' id='error_firstName'></span>

    <label for="avatarBtn">Avatar</label>
    <img id='avatar' src="<?=$_SESSION['avatar']?>" alt="public/images/defaultUserImage.svg">
    <label for="changeAvatar"><button class='changeAvatar'>Change Avatar</button></label>
    <input name="avatar" id="changeAvatar" type="file"/>
    <span class='error' id='error_firstName'></span>
    <button class="savePersonalInfo">Save</button>
    </fieldset>
    
    <button id="signOut">Sign out</button>

   
</form>
   
</div>
<?php
$content = ob_get_clean();
require('view/template.php');
?>