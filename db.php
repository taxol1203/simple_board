<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');

    $db = new mysqli("localhost" , "root" , "7777", "board"); //mysqli로 연결해 준다  -> db 주소 ,db계정, ,db 비번, ,db이름
    $db->set_charset("utf8");

    function mq($sql){
        global $db;     //global은 외부에서 선언 된 $sql을 함수 내에서 사용하게 해준다
        return $db->query($sql);
    }
?>
    