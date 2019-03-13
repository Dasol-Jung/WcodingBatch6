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
  <script>
    function onSuccess(googleUser) {
      console.log("Logged in as: " + googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      console.log(error);
    }
    function renderButton() {
      gapi.signin2.render("my-signin2", {
        "scope": "profile email",
        "width": 240,
        "height": 50,
        "longtitle": false,
        "theme": "dark",
        "onsuccess": onSuccess,
        "onfailure": onFailure
      });
    }
  </script>
  <a href="#" onclick="signOut();">Sign out</a>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log("User signed out.");
    });
  }
</script>

<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<?php $content = ob_get_clean();?>
<?php require "./view/template.php"; ?>