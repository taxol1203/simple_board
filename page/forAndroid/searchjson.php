<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $category = $_POST['catgo'];
    $search_con = $_POST['keyword'];


    $sql = mq("select * from board where $category like '%$search_con%' order by idx desc");
    $data = array();

    while($board = $sql->fetch_array()){
        $title = $board["title"];
        $idx = $board["idx"];
        $name = $board["name"];
        $date = $board["date"];
        $hit = $board["hit"];
        if(strlen($title) > 30){
            $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
        }
        
        array_push($data, array(
            'title'=>$title,
            'writer'=>$name,
            'date'=>$date,
            'idx'=>$idx,
            'hit'=>$hit
        ));
        
        //header('Content-Type: application/json; charset=utf8');
        
    }
    $json = json_encode(array("webnautes"=>$data));
    echo $json;
?>
