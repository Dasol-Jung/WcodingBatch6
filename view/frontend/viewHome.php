<?php session_start(); $_SESSION["googleToken"] = "";?>

<?php $title = "Weekly Scheduler"; ?>
<?php $meta = "
    <meta name='google-signin-client_id' content='348810924325-fhm38tq65kah3bqdgcp5nseaqkh9kj1s.apps.googleusercontent.com'>
 "; ?>
<?php ob_start();?>
<?php require_once "navbar.php";?>
<?php require_once "carousel.php";?>
<?php require_once "login.php";?>
<?php require_once "footer.php";?>
<div id="my-signin2"></div>
<script src="./public/js/frontend/google.js"></script>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<?php $content = ob_get_clean();?>
<?php require "./view/template.php"; ?>
<!--
// 1 create a view only for your button to be included in view_home.(you need to wait for the of Aiden)
// 2. change the testGoogle..php to the actual treatment  : need to create a simple view with only the display of the name and the image
//  2a .  MVC part
    // every time you need to start from index (it means create an action aka AJ already madeit for the internal)
      // -> when you call index  you will have the variable containing the JSON 
    // Second step is in index you need to call a method from the controller (that you created) and give as an argument of this ;ethod the array google info
    // through the method from the controller
      // inside the function or at the beginning of the controller (asss your wish) you load the model
      // the model is actually your googleUser.php aka your class
      // by loading the model you can create a new GoogleUser(); so now you have access to the methods of the model
    // in the model, it's the only who can communicate with your DB;
      // extends Users super classe of AJ
      // create your function to : insert into if not exists the google user otherwise load the user
      // create your function to load the user from the google_uid function searchUser($uid) {}
   // last step in your Controller function == you need to require your view to display the infor;ation of the user -->