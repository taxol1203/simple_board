<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";

    $rno = $_POST['rno'];
    $sql = mq("select * from reply where idx= ".$rno." ");
    $reply = $sql->fetch_array();

    $bno = $_POST['b_no'];
    $sql2 = mq("select * from board where idx = ".$bno." ");
    $board = $sql2->fetch_array();

    $pw = $_POST['pw'];

    $sql3 = mq("update reply set content = '".$_POST['content']."' where idx = ".$rno."  ");
    
    if(sql3){
?>  
    <script type = "text/javascript"> 
        alert('modify success'); 
        location.replace("read.php?idx=<?php echo $bno; ?>")
    </script>
<?php }else { ?>
    <script type = "text/javascript"> 
        alert('modify success'); 
        location.replace("read.php?idx=<?php echo $bno; ?>")
    </script>
<?php } ?>
