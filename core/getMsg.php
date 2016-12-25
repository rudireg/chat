<?php
use core\chat\Chat as Chat;
require_once "chat.php";

/**
 * Если $from 0, выборка идет с конца таблицы, иначе с ID на которое указывает $from
 * $max -максимальное кол. сообщений для чтения. Если 0 - то считать все.
 */
$from    = (int)  $_POST['from'];
$max     = (int)  $_POST['max'];
$reverse = (bool)  $_POST['reverse'];
/**
 * Инициализация
 */
$chat = new Chat();

/**
 * Читаем сообщения
 */
$msg = $chat->readMsg($from, $max, $reverse);

/**
 * Если нет сообщений
 */
if($msg === null){
    $response = array("text"=>"", "error"=>0);
    echo json_encode($response);
    return;
}

/**
 * Если есть сообщения
 */
usort($msg, "rcmp");
$response = array("text"=>$msg, "error"=>0);
echo json_encode($response);
return;

/**
 * Сортировка
 */
function rcmp($a, $b){
    return strcmp($a['msg_time'], $b['msg_time']);
}













