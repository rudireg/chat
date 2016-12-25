<?php
use core\chat\Chat as Chat;
require_once "chat.php";

$userName = $_POST['userName'];
$userMsg  = $_POST['userMsg'];
$userName = htmlspecialchars(substr($userName, 0, 128));
$userMsg  = htmlspecialchars(substr($userMsg, 0, 1024));

if(empty($userName) || empty($userMsg)){
    $response = array("text"=>"Ошибка. Пустые параметры", "error"=>1);
    echo json_encode($response);
    return;
}

$chat = new Chat();
if(!$chat->sendMsg($userName, $userMsg)) {
    $response = array("text"=>"Ошибка отправки сообщения", "error"=>2);
    echo json_encode($response);
    return;
}

$response = array("text"=>"УСПЕШНАЯ отправка сообщения", "error"=>0);
echo json_encode($response);
return;


