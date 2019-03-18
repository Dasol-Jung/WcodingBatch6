<?php
$styles[] = "<link rel='stylesheet' href='public/css/1_shared/index.css'";
$meta = "<meta name='google-signin-client_id' content='348810924325-fhm38tq65kah3bqdgcp5nseaqkh9kj1s.apps.googleusercontent.com'>
 "; ?>
<?php ob_start(); ?>

<div class="bodyWrapper">
    <div class="left">
        <?php require_once "carousel.php"?>
    </div>
    <div class="divider"></div>
    <div class="right">
        <?=$rightSection?>
    </div>
</div>
<?php
$content = ob_get_clean();
require("view/template.php"); ?>
