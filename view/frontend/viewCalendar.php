<?php $title = 'Weekly Scheduler'; ?>
<?php ob_start(); ?>
<?php require_once "navbar.php"?>
<?php require_once "calendar.php"?>
<?php require_once "footer.php"?>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>