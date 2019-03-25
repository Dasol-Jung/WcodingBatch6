<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$styles[]= "<link rel='stylesheet' href='public/css/profile.css'/>";
ob_start();
?>

<div class="bodyWrapper">
<script src="https://apis.google.com/js/api:client.js"></script>
<script src="http://developers.kakao.com/sdk/js/kakao.min.js"></script>
<div class="profileForm" action="index.php" method="POST">
    <div class="leftCol">
        <label for="email">Email</label>
        <input readonly value="<?=$userInfo['email']?>" name="email" id="email" type="email"/>

        <form class="personalInfo">
            <fieldset>
                <legend>Personal Info</legend>
            
            <div class="firstNameContainer">
                <label for="firstName">First Name</label>
                <input <?php echo $_SESSION['userType']=='internal' ?  null : 'readonly'?> value='<?=$userInfo['first_name']?>' name="firstName" id="firstName" type="text"/>
                <span class='error' id='error_firstName'></span>
            </div>
            <div class="avatarAndSave">
                <div class="avatarContainer">
                    <label for="avatarBtn">Avatar</label>
                    <div class="avatarBox">
                    <img id='profileAvatar' src="<?=$_SESSION['avatar']?>" alt="public/images/defaultUserImage.svg">
                    <?php if($_SESSION['userType']=='internal'):?>
                    <label for="changeAvatar">Edit</label>
                    <input name="avatar" id="changeAvatar" type="file"/>
                    <span class='error' id='error_avatar'></span>
                    <?php endif?>
                    </div>
                </div>
                <?php if($_SESSION['userType']=='internal'):?>
                    <button class="savePersonalInfo">Save</button>
                <?php endif?>
            </div> 
            </fieldset> 
        </form>
    </div>

    <div class="rightCol">
    <?php if($_SESSION['userType']=='internal'):?>
        <label>Password</label>
        <button id="changePassword">Change Password</button>
    <?php endif?>
    <div class="connectedAcct">
        <label for="connectAcct">Connected Acccounts</label>
        <div class="connectedAcctContainer">
        <?php if(isset($avatars['internal'])):?>
            <div class="internalAcct">
                    <span>Weeky </span>
                <?php foreach($avatars['internal'] as $internalAvatar):?>
                    <img src="<?=$internalAvatar?>" alt="">
                <?php endforeach?>
                    <button id="discntInternal">Disconnect</button>
                
            </div>
            <?php endif?>
            <?php if(isset($avatars['google'])):?>
            <div class="googleAcct">
                    <span>Google </span>
                <?php foreach($avatars['google'] as $googleAvatar):?>
                    <img src="<?=$googleAvatar?>" alt="">
                <?php endforeach?>
                <button id="discntGoogle">Disconnect</button>
            </div>
            <?php endif?>
            <?php if(isset($avatars['kakao'])):?>
            <div class="kakaoAcct">
                    <span>Kakao </span>
                <?php foreach($avatars['kakao'] as $kakaoAvatar):?>
                    <img src="<?=$kakaoAvatar?>" alt="">
                <?php endforeach?>
                <button id="discntKakao">Disconnect</button>
            </div>
            <?php endif?>
        </div>
    </div>
    </div>

<div class="connectNewAcct">
    <label for="connectAcct">Connect new account</label>
        <div class="connectButtons">
            <div style="background-color : #eee; width: 100%; height : 2.3rem; text-align : center;  display : grid; align-items : center;" id="gSignInWrapper">
                <div id="connectGoogle" class="customGPlusSignIn">
                    <img style='height : 22px; position: relative; top : 2px;' src='../../public/images/googleLogo.png'/>
                    <span style='position : relative; bottom:5px; left : 10px; font-size : 0.9rem;' class="buttonText">Google</span>
                </div>
            </div>
            <div>  
                <div class="kakaoSignin"><img id="kakaoLogo" src="../../public/images/kakaoLogo.png"/><span>Kakao</span><a id="connectKakao"></a></div>
            </div>
        </div>
    </div>
    <div class="signOutContainer">
        <label for="connectAcct">Sign out</label>
        <button id="signOut">Sign out</button>
    </div>
</div>
<form class="checkSignOut modalTarget">
        <label for="currentPW">Current password</label>
        <input name='currentPW' type="password" placeholder='Enter current password'>
        <button class='confirmPWBtn'>Confirm</button>
    </form>
    <form class="checkCurrentPW modalTarget">
        <label for="currentPW">Current password</label>
        <input name='currentPW' type="password" placeholder='Enter current password'>
        <button class='confirmPWBtn'>Confirm</button>
    </form>
   
</div>
<script src='public/js/frontend/profile.js'></script>
<script src="../../public/js/frontend/google.js"></script>
<script src="../../public/js/frontend/kakaoAcct.js"></script>
<script>startApp();</script>
<?php
$content = ob_get_clean();
require('view/template.php');
?>