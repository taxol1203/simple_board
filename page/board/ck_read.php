<?php  
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
    ?>
<link rel = "stylesheet" type = "text/css" href = "/css/jquery-ui.css" />
<script type = "text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type = "text/javascript" src="/js/jquery-ui.js"></script>
<script type = "text/javascript">
    $(function(){
        $("#writepass").dialog({
            modal:true,
            title:'비밀글 입니다.',
            width:400,
        });
    });
</script>
<?php

$bno = $_GET['idx'];
$sql = mq("select * from board where idx = ".$bno." ");
$board = $sql->fetch_array();

?>

<div id='writepass'>
    <form action="" method="post">
        <p>비밀번호 <input type="password" name="pw_chk" /> <input type="submit" value="확인" /> </p>
    </form>
</div>

<?php  
    //board에 잇는 비밀번호
    $bpw = $board['pw'];
    //여기 pw_chk는 위의 password에서 가져온 건가?
    if(isset($_POST['pw_chk'])){
        $pwk = $_POST['pw_chk'];
        //if(password_verify($pwk, $bpw)){ <- 이거 안됨 개빡침
        if($pwk == $bpw){
        ?>
        <!-- pwk와 bpw값이 같으면 read.php로 보내고 -->
        <script type="text/javascript"> 
            location.replace("read.php?idx=<?php echo $board["idx"]; ?>");
        </script>
        <?php
        }else{ ?>
            <script type="text/javascript"> alert('wrong password');</script>
        <?php }
    }
    ?>