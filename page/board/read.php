<?php
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
?>

<!doctype html>
<head>
    <meta charset="UTF-8">
    <title> 탁솔 게시판 </title>
    <link rel = "stylesheet" type = "text/css" href="/css/mystyle.css" />
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
</body>
</html>