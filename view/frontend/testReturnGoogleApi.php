<?php
session_start();

    $googleInfo = json_decode(file_get_contents("php://input"), TRUE); // this line is the the index to get the informations of the google user
    print_r($googleInfo);
    echo $googleInfo["first_name"];
    $_SESSION["googleToken"] = $googleInfo["google_id"];


    // MODEL METHOD to insert your user
    $googleToken = $googleInfo["google_id"];
    $googleFirstName = $googleInfo["first_name"];
    $googleLastName = $googleInfo["last_name"];
    $googleImage = $googleInfo["image_url"];
    $googleEmail = $googleInfo["email"];
    INSERT INTO IF NOT EXISTS google(google_uid, email, image, first_name, last_name, create_date, last_login_date) VALUES ($googleToken, $googleEmail, $googleImage, $googleFirstName, $googleLastName, NOW(), NOW());
  //header("location:index.php");