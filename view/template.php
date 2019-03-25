<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='google-signin-client_id' content='348810924325-fhm38tq65kah3bqdgcp5nseaqkh9kj1s.apps.googleusercontent.com'>
    <title>Weeky</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css"/>

    <?php if(isset($styles)):?>
        <?php foreach($styles as $style):?>
            <?=$style?>
        <?php endforeach?>
    <?php endif?>
</head>

<body>
<?php require_once "view/frontend/header.php"?>
    <?= $content ?>
    <script src= "public/js/frontend/utils.js"></script>
    <script src= "public/js/frontend/header.js"></script>
    <script>
        clientUtils.initialize()
    </script>
</body>
</html>