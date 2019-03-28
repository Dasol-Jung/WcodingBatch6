<?php
header('Content-Type: application/json; charset=utf-8');
ob_start();
require_once("./ScheduleManager.php");

//get json data and convert it into an associate array
$data = file_get_contents("php://input");
$dataInArr = json_decode($data, true);

//extract kakao id, schedule date and title from the associative array above.
$userId = $dataInArr['userRequest']['user']['properties']['appUserId'];
$scheduleDate = json_decode(str_replace("\\","",$dataInArr['action']['params']['sys_date']),true)['date'];
$scheduleTitle = trim(json_encode($dataInArr['action']['params']['title'],JSON_UNESCAPED_UNICODE),'"');

$scheduleManager = new ScheduleManager();
$response = $scheduleManager->createSchedule($userId, $scheduleTitle, $scheduleDate);

ob_get_clean();
echo $response;

?>