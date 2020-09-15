<?php include $_SERVER['DOCUMENT_ROOT']."/db.php"; ?>
<!-- 위의 함수는 서버의 기본 경로를 알 수 있으며, 파일 경로 작성시 사용한다. 실행 되는 위치를 말함 -->
<!doctype html>
<head>
    <meta charset = "UTF-8">
    <title> 탁솔 게시판 </title>
    <link rel="stylesheet" type = "text/css" href="/css/mystyle.css" />
</head>

<body>
    <div id = "board_area">
        <h1> 탁솔 게시판 </h1>
        <h4> 자유롭게 글을 쓸 수 있는 게시판입니다.</h4>
        <!-- 테이블 함수, thead: 테이블 제목, tbody: 테이블 내용, tr : td, th태그를 행으로 묶어줌 th: 제목, td: 실제 데이터-->
        <table class="list-table">
            <thead>
                <tr>
                    <th width="70"> 번호 </th>
                    <th width="500"> 제목 </th>
                    <th width="120"> 글쓴이 </th>
                    <th width="100"> 작성일 </th>
                    <th width="100"> 조회수 </th>
                </tr>
            </thead>
        <!-- php로 db에 연결을 해 query문을 전달 하고, while문을 통해 변수 하나씩 받아, table에 넣으며 loop -->
        <?php
            $sql = mq("select * from board order by idx desc limit 0,5");
            while($board = $sql->fetch_array()){
                $title = $board["title"];
                $idx = $board["idx"];
                $name = $board["name"];
                $date = $board["date"];
                $hit = $board["hit"];
                if(strlen($title) > 30){
                    $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                }
                //댓글 개수 세기
                $sql2 = mq("select * from reply where con_num = $idx");
                $rep_count = mysqli_num_rows($sql2);
            ?>
        <tbody>
            <tr>
                <td width="70"> <?php echo $idx ?></td>
                <td width="500"> <?php
                    //get lock image
                    $lockimg = "<img src = '/img/lock.png' alt='lock' width = '20' height = '20' />";
                    //만약 1이면 ch_read로 이동하고, 사진을 띄운다
                    if($board['lock_post'] == "1"){
                        ?> <a href = '/page/board/ck_read.php?idx=<?php echo $board["idx"];?>'> <?php echo $title, $lockimg;
                        }
                    else{ ?> 
                        <a href="/page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $title; 
                    }?> 
                    <span class ="re_ct"> [ <?php echo $rep_count; ?> ] </span>
                    </a></td>
                <td width="120"><?php echo $name ?></td>
                <td width="100"><?php echo $date?></td>
                <td width="100"><?php echo $hit ?></td>
            </tr>
        </tbody>
        <!--여기가 while의 끝 } -->
        <?php } ?>
        </table>
        <div id="write_btn">
            <a href="/page/board/write.php"><button>글쓰기</button></a>
        </div>
    </div>
</body>
</html>