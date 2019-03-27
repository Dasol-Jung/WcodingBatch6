<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
require_once("./ScheduleManager.php");

//get json data and convert it into an associate array
$data = file_get_contents("php://input");
$dataInArr = json_decode($data, true);

//extract kakao id, schedule date and title from the associative array above.
$userId = $dataInArr['userRequest']['user']['properties']['appUserId'];
$scheduleDate = json_decode(str_replace("\\","",$dataInArr['action']['params']['sys_date']),true)['date'];
$scheduleTitle = trim(json_encode($dataInArr['action']['params']['title']),'"');

$scheduleManager = new ScheduleManager();
$response = $scheduleManager->createSchedule($userId, $scheduleTitle, $scheduleDate);

echo $response;

?>