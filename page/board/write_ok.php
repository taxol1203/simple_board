<?php

include $_SERVER['DOCUMENT_ROOT']."/db.php";
//include 'password.php';

//각 변수에 write.php에서 가져온 input 값들을 저장한다
$hit = 0;
$username = $_POST['name'];
//userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$userpw = $_POST['pw'];
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d');

if(isset($_POST['lockpost'])){
    $lo_post = '1';
}else{
    $lo_post = '0';
}

if($username && $userpw && $title && $content){
    $sql_return = mq("insert into board(name,pw,title,content,date, lock_post) values('".$username."','".$userpw."','".$title."','".$content."','".$date."','".$lo_post."')"); 
     if($sql_return){
        echo "<script>
        alert('글쓰기 완료되었습니다.');
        location.href='/index.php';
        </script>";
    }else{
        echo "<script>
        alert('글쓰기에 실패했습니다  name = $name, title = $title, content = $content, date = $date, hit = $hit, pw = $userpw');
        history.back();</script>";
    }
}else{
    echo "<script>
    alert('데이터 전송을 실패하였습니다.');
    history.back();</script>";
}
?>