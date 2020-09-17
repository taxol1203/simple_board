<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    //include 'password.php';

    //For android
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


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

    $tmpfile = $_FILES['b_file']['tmp_name'];   //change b_file name to temporary file name
    $o_name = $_FILES['b_file']['name'];        //put origianl filename
    $filename = iconv("UTF-8", "EUC-KR", $_FILES['b_file']['name']);    //prevent for broked korean file name
    $folder = "../../upload/".$filename;
    move_uploaded_file($tmpfile, $folder);      //왜 임시 파일 명으로 업로드 하지?

    if( ($username && $userpw && $title && $content) || $android){
        $sql_return = mq("insert into board(name,pw,title,content,date, lock_post, file) values('".$username."','".$userpw."','".$title."','".$content."','".$date."','".$lo_post."' , '".$o_name."' )"); 
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