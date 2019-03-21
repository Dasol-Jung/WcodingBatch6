<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$styles[]= "<link rel='stylesheet' href='public/css/profile.css'/>";
ob_start();
?>

<div class="bodyWrapper">

<div class="profileForm" action="index.php" method="POST">

    <label for="email">Email</label>
    <input readonly value="<?=$userInfo['email']?>" name="email" id="email" type="email"/>

    <?php if($_SESSION['userType']=='internal'):?>
        <label for="changePassword">Password</label>
        <button id="changePassword">Change Password</button>
    <?php endif?>

    <form class="checkCurrentPW modalTarget">
        <label for="currentPW">Current password</label>
        <input name='currentPW' type="password" placeholder='Enter current password'>
        <button>Confirm</button>
    </form>

    <form class="personalInfo">
        <div class="firstNameContainer">
            <label for="firstName">First Name</label>
            <input <?php echo $_SESSION['userType']=='internal' ?  null : 'readonly'?> value='<?=$userInfo['first_name']?>' name="firstName" id="firstName" type="text"/>
            <span class='error' id='error_firstName'></span>
        </div>
    
        <div class="avatarContainer">
            <label for="avatarBtn">Avatar</label>
            <img id='profileAvatar' src="<?=$_SESSION['avatar']?>" alt="public/images/defaultUserImage.svg">
            <?php if($_SESSION['userType']=='internal'):?>
              <label for="changeAvatar">Edit</label>
              <input name="avatar" id="changeAvatar" type="file"/>
              <span class='error' id='error_avatar'></span>
            <?php endif?>
            
        </div>
        <?php if($_SESSION['userType']=='internal'):?>
            <button class="savePersonalInfo">Save</button>
        <?php endif?>
    </form>
    <button id="signOut">Sign out</button>
</div>
   
</div>
<script src='public/js/frontend/profile.js'></script>
<?php
$content = ob_get_clean();
require('view/template.php');
?>