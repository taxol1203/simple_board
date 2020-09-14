<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
?>

<!doctype html>
<head>
    <meta charset="UTF-8">
    <title> 탁솔 게시판 </title>
    <link rel = "stylesheet" type = "text/css" href="/css/mystyle.css" />
    <link rel = "stylesheet" type = "text/css" href="/css/jquery-ui.css" />
    <script type="text/javascript" src = "/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src = "/js/jquery-ui.js"></script>
    <script type="text/javascript" scr = "/js/common.js"></script>
</head>

<body>
    <?php
        $bno = $_GET['idx']; //bno로 해당 글에 대한 index를 받는다.
        $board_bef = mysqli_fetch_array(mq("select * from board where idx=".$bno."")); //idx로 글의 정보가 담긴 db를 select
        $hit = $board_bef['hit'] + 1; //조회수 1 추가
        $fet = mq("update board set hit = ".$hit." where idx = ".$bno."");  //조회수 수정
        $sql = mq("select * from board where idx = ".$bno.""); //이후 다시 수정된 db를 받음
        $board = $sql->fetch_array();
    ?>

<!-- 글 불러오기 -->
<div id = "board_read">
    <h2><?php echo $board['title']; ?></h2>
        <div id = "user_info">
            <?php echo $board['name']; ?> <?php echo $board['date']; ?> 조회: <?php echo $board['hit']; ?>
                <div id = "bo_line"></div>
        </div>
        <div id="bo_content">
            <?php echo nl2br("$board[content]"); ?>   <!-- n12br : 한 줄 띄우기를 html의 /br로 변환해줌 -->
        </div>
    <!-- 목록, 수정, 삭제 -->
    <div id="bo_ser">
        <ul>
            <li><a href="/index.php"> [목록으로] </a><li>
            <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>  <!-- 수정을 클릭하면, modify.php에 인자로 idx를 넘겨주며 이동 -->
            <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
        </ul>
	</div>
</div>

<!-- 댓글 불러오기 -->
<div class="reply_view">
    <h3> 댓글목록 </h3>
        <?php
            $sql3 = mq("select * from reply where con_num = ".$bno." order by idx desc");
            while($reply = $sql3->fetch_array()){
            ?>
        <div class = "dap_lo">
            <div><b><?php echo $reply['name'];?></b></div>
            <div class = "dap_to comt_edit"><?php echo nl2br($reply['content']);?></div>
            <div class = "dap_to rep_me"><?php echo $reply['date'];?></div>
            <div class = "rep_me rep_menu">
                <a class = "dat_edit_bt" href="#"> 수정 </a>
                <a class = "dat_delete_bt" href="#"> 삭제 </a>
            </div>
            <!-- 댓글 수정 폼 dialog -->
            <div class = "dat_edit">
                <form method="post" action="rep_modify_ok.php">
                    <input type = "hidden" name = "rno" value = "<?php echo $reply['idx']; ?>" /> 
                    <input type = "hidden" name = "b_no" value = "<?php echo $bno; ?>">
                    <input type = "password" name = "pw" class = "dap_sm" placeholder="비밀번호"/>
                    <textarea name = "content" class="dap_edit_t"> 
                        <?php echo $reply['content']; ?></textarea>
                    <input type = "submit" value = "수정하기" class = "re_mo_bt">
                </form>
            </div>
            
            <!-- 댓글 삭제 비밀번호 확인 -->
            <div class = "dat_delete">
                <form method = "post" action = "reply_delete.php">
                    <input type = "hidden" name = "rno" value = "<?php echo $reply['idx']; ?>" />
                    <input type = "hidden" name = "b_no" value = "<?php echo $bno; ?>">
                    <p>
                        비밀번호
                        <input type = "password" name = "pw" />
                        <input type = "submit" value = "확인">
                    </p>
                </form>
            </div>
        </div>
        <?php } ?>
    <!-- 댓글 입력 -->
    <div class = "dap_ins">
        <form method = "post" action = "reply_ok.php?idx=<?php echo $bno; ?>">
                <input type = "text" name = "dat_user" id = "dat_user" class = "dat_user" size = "15" placeholder = "id">
                <input type = "text" name = "dat_pw" id = "dat_pw" class = "dat_pw" size = "15" placeholder = "password">
                <div style = "margin-top:10px; ">
                    <textarea name = "content" class = "reply_content" id = "re_content" > </textarea>
                    <button id = "rep_bt" class = "re_bt"> 댓글 </button>
                </div>
        </form>
    </div>
</div> <!-- 댓글 불러오기 끝 -->

<div id = "foot_box"> </div>


</body>
</html>