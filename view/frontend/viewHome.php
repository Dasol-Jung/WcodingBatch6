<?php $title = 'Weekly Scheduler'; ?>
<?php ob_start(); ?>

<?php require_once "carousel.php"?>
<?php require_once "viewSignUp.php"?>

<?php
$content = ob_get_clean();
require("view/template.php"); ?>