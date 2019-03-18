<?php
session_start();
$styles[]="<link rel='stylesheet' href='../../public/css/welcome.css'/>";
ob_start();
?>
<div class="bodyWrapper">

    <div class="welcomeMsgContainer">
        <div class="msgBg">     
            <p class='line1'>You're</p>
            <p class='line2'>Signed Up</p>
            <p class='line3'>Successfully</p>
            <p class='line4'>
                Welcome
            </p>
            
            <div class="nameWrapper">
                <span class="nameBody"><?=$_SESSION['firstName']?></span>
                <span class="nameShadow"><?=$_SESSION['firstName']?></span>
            </div>
            <button class='start'>START</button>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('view/template.php');
?>