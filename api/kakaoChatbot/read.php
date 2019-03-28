<?php
header('Content-Type: application/json; charset=utf-8');
ob_start();
require_once("./ScheduleManager.php");

//get json data and convert it into an associate array
$data = file_get_contents("php://input");
$dataInArr = json_decode($data, true);

//extract kakao id and schedule date from the associative array above.
$userId = $dataInArr['userRequest']['user']['properties']['appUserId'];
$scheduleDate = json_decode(str_replace("\\","",$dataInArr['action']['params']['sys_date']),true)['date'];

$scheduleManager = new ScheduleManager();
$response = $scheduleManager->readOneSchedule($userId, $scheduleDate);

ob_get_clean();
echo $response;

?>