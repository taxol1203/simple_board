<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";

    $bno = $_GET['idx'];
    $userpw = $_POST['dat_pw'];

    if($bno && $_POST['dat_user'] && $userpw && $_POST['content']){
        $sql = mq("insert into reply(con_num,name,pw,content, `date`) values(".$bno.", '".$_POST['dat_user']."' , '".$userpw."' , '".$_POST['content']."' , now() ) ");
        if(sql){
            echo "<script> alert('댓글 작성 성공');
            location.href = '/page/board/read.php?idx=$bno';</script>";
        }
        else{
            echo "<script> alert('댓글 작성에 실패 했습니다');
            history.back(); </script>";
        }
    }
?>

    