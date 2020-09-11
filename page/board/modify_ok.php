<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
    //include_once 'password.php';

    $bno = $_GET['idx'];
    $username = $_POST['name'];
    //$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
    $userpw = $_POST['pw'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = mq("update board set name='".$username."',pw='".$userpw."',title='".$title."',content='".$content."' where idx=".$bno." ");
    if($sql){
        echo "<script>
        alert('수정이 완료되었습니다.');
        </script>";
    }
?>

<meta http-equiv="refresh" content="0 url=/page/board/read.php?idx=<?php echo $bno; ?>">    
