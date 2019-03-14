<?php $styles[] = "<link rel='stylesheet' href='public/css/1_shared/index.css'"?>
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