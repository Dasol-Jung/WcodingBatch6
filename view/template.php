<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='google-signin-client_id' content='852784944923-o4n8r0gg2sl9k3tdgu2fue8uq13esm82.apps.googleusercontent.com'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weeky</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css"/>
    <?php foreach($styles as $style):?>
        <?=$style?>
    <?php endforeach?>
</head>
<body>
<?php require_once "view/frontend/header.php"?>
    <?= $content ?>
<?php require_once "view/frontend/footer.php"?>

</body>
</html>