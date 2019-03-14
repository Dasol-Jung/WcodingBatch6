<?php
session_start();
$style="<link rel='stylesheet' href='../../public/css/welcome.css'/>";
ob_start();
?>

<h1>
    Welcome <?=$_SESSION['firstName']?>
</h1>
<?php
$content = ob_get_clean();
require('view/template.php');
?>