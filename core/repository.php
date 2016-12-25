<?php
namespace core\repository;
/*
 * Template: Singleton
 * Description: Работа с БД
 */
class Repository {
    protected static $DBH;

    public static function getInstance(){
        if(self::$DBH === null) {
            try{
                self::$DBH = new \PDO("mysql:host=127.0.0.1;dbname=chat;", "root", "password");
            } catch (\PDOException $e) {
                \file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            }
        }
        return self::$DBH;
    }

    //Отправка сообщения
    public static function sendMsg($userName, $userMsg) {
        $STH = self::$DBH->prepare("INSERT INTO msg (id, user_name, user_msg, msg_time) VALUES (?, ?, ?, ?)");
        $data = array(null, $userName, $userMsg, time());
        return $STH->execute($data);
    }

    /*
     * Считать сообщения из БД
     * @param (string)$from - ID сообщения после которого следует делать выборку (по умолчанию null)
     * @param (string)$max  - Максимальное кол. сообщений для выборки (по умолчанию 10)
     * @return (array | null) - В случает успеха вернет массив сообщений, иначе null
     */
    public static function readMsg($from, $max, $reverse) {
        $q = "SELECT * FROM `msg`";
        if($reverse === false){
                $q .= " WHERE `id` > " . self::$DBH->quote($from);
        }else{
                $q .= " WHERE `id` < " . self::$DBH->quote($from);
        }

//
//
//        if($reverse === false) if($from >= 0) $q .= " WHERE `id` > " . self::$DBH->quote($from);
//        else                   if($from >= 0) $q .= " WHERE `id` < " . self::$DBH->quote($from);
        $q .= " ORDER BY `id` DESC";
        if($max  > 0) $q .= " LIMIT " . (int) $max;
        $STH = self::$DBH->query($q);
        $STH->setFetchMode(\PDO::FETCH_ASSOC);
        if($STH->rowCount() < 1) return null;
        $msg = array();
        while($row = $STH->fetch()) {
            $msg[] = $row;
        }
        return $msg;
    }

    /**
     * Взять последние сообщения
     * @param $max  Максимальное кол. сообщений
     * @return (array | null) - В случает успеха вернет массив сообщений, иначе null
     */
    public static function readLastMsg($max) {
        $STH = self::$DBH->prepare("SELECT * FROM `msg` ORDER BY `id` DESC LIMIT :max");
        $STH->bindParam(':max', $maxLine);
        $maxLine = $max;
        $STH->execute();
        $STH->setFetchMode(\PDO::FETCH_ASSOC);
        if($STH->rowCount() < 1) return null;
        $msg = array();
        while($row = $STH->fetch())
            $msg[] = $row;
        return $msg;
        return null;
    }

    //Закрываем
    final private function __construct() {}
    final private function __clone() {}
    final private function __sleep() {}
    final private function __wakeup() {}
}

