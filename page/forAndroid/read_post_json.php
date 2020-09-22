<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    //json으로 변환하기 위한 array 세팅
    $data = array();

    $bno = $_POST['idx']; //bno로 해당 글에 대한 index를 받는다.
    $board_bef = mysqli_fetch_array(mq("select * from board where idx=".$bno."")); //idx로 글의 정보가 담긴 db를 select
    $hit = $board_bef['hit'] + 1; //조회수 1 추가
    $fet = mq("update board set hit = ".$hit." where idx = ".$bno."");  //조회수 수정
    $sql = mq("select * from board where idx = ".$bno.""); //이후 다시 수정된 db를 받음
    $board = $sql->fetch_array();

    //array로 변환
    array_push($data, array(
        'title'=>$board['title'],
        'writer'=>$board['name'],
        'date'=>$board['date'],
        'idx'=>$bno,
        'hit'=>$hit,
        'content'=>$board['content']
    ));
    //이후 json으로
    $json = json_encode(array("webnautes"=>$data));
    echo $json;
?>