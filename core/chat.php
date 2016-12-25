<?php
namespace core\chat;
use core\repository\Repository as Repository;
require_once "repository.php";

    class Chat {

        /*
         * Конструктор
         */
        public function __construct(){
            Repository::getInstance(); //Инициализация БД
        }

        /*
         * Сохранить сообщение в БД
         * @param (string) Имя пользователя
         * @param (string) Сообщение пользователя
         * @return (bool) В случает успеха TRUE, иначе FALSE
         */
        public static function sendMsg($userName, $userMsg){
            return Repository::sendMsg($userName, $userMsg);
        }

        /*
         *  Получить сообщения из БД
         * @param $from (int) ID сообщения, после которого сделать выборку сообщений
         * @param $max  (int) Максимальное кол. считываемых сообщений, если передать 0 - то следует считать все сообщения из БД
         * @return (array) Возвращает ассоциативный массив сообщений
         */
        public static function readMsg($from =0, $max =10, $reverse =false){
            return Repository::readMsg($from, $max, $reverse);
        }

        /**
         * @param $max Максимальное кол. последний сообщений
         * @return (array) Возвращает ассоциативный массив сообщений
         */
        public static function readLastMsg($max){
            return Repository::readLastMsg($max);
        }
    }


