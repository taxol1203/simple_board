<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $rno = $_POST['rno'];
    $sql = mq("select * from reply where idx = ".$rno." ");
    $reply = $sql->fetch_array();

    $bno = $_POST['b_no'];
    $sql2 = mq("select * from board where idx = ".$bno." ");
    $board = $sql2->fetch_array();

    $pw_input = $_POST['pw'];
    $pw_saved = $reply['pw'];

    if(pw_input == pw_saved){
        $sql_ret = mq("delete from reply where idx = ".$rno." "); ?>
        <script type = "text/javascript">
            alert('댓글이 삭제되었습니다');
            location.replace("read.php?idx = <? php echo $board["idx"]; ?> ");
        </script>
    <?php }else{
        ?>
        <script type = "text/javascript">
            alert('wrong password');
            history.back();
        </script>
    <?php } 
?>