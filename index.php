<?php include $_SERVER['DOCUMENT_ROOT']."/db.php"; 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
?> <!-- 위의 함수는 서버의 기본 경로를 알 수 있으며, 파일 경로 작성시 사용한다. 실행 되는 위치를 말함, 에러코드 -->

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
            //page 값이 있으면 get으로 받아옴. else 1
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
            else{
                $page = 1;
            }
            $sql = mq("select * from board");
            $row_num = mysqli_num_rows($sql);   // 게시판 총 col 수
            $list = 5;                          //num to show on one page
            $block_cnt = 5;                     //num of pages to show per block

            $block_num = ceil($page/$block_cnt); //get current page block
            $block_start = (($block_num - 1) * $block_cnt) + 1; //start number of block
                                                                //if current page is 7 then, ((2 - 1) * 5) + 1 = 6
            $block_end = $block_start + $block_cnt - 1;         //last number of block
            $total_page = ceil($row_num/$list);                 //get num fo paged page
            
            if($block_end > $total_page)                        //if last block number is bigger than paged page num
                $block_end = $total_page;                       
            $total_block = ceil($total_page / $block_cnt);      //total num of blocks
            
            $start_num = ($page - 1) * $list;                   //start number of current page
            $sql3 = mq("select * from board order by idx desc limit $start_num, $list");

            while($board = $sql3->fetch_array()){ //get all data from db while loop
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
                        ?> 
                        <a href = '/page/board/ck_read.php?idx=<?php echo $board["idx"];?>'> 
                        <?php echo $title, $lockimg;
                    }else{ 
                        $boardtime = $board['date'];
                        $timeNow = date("Y-m-d");
                        
                        if($boardtime == $timeNow){
                            $img = "<img src = 'img/new.png' alt = 'new' title='new' />";
                        }else{
                            $img = "";
                        }?> 
                        <a href="/page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $title; 
                    }?> 
                    <span class ="re_ct"> [ <?php echo $rep_count; ?> ]<?php echo $img; ?> </span>
                    </a>
                </td>
                <td width="120"><?php echo $name ?></td>
                <td width="100"><?php echo $date?></td>
                <td width="100"><?php echo $hit ?></td>
            </tr>
        </tbody>
        <!--여기가 while의 끝 } -->
        <?php } ?>
        </table>
        <!-- 페이징 넘버 -->
        <div id = "page_num">
            <ul>
                <?php
                    if($page <= 1){ //현재 page가 1이면 처음 색을 빨간색으로 한다.
                        echo "<li class = 'fo_re'>처음</li>";
                    }else{  //if not, set 처음 button that go into page 1 if clicked
                        echo "<li><a href='?page = 1'>처음</a></li>";
                        //set 이전 button and if clicked page minus 
                        $pre = $page - 1;
                        echo "<li><a href='?page = $pre'>이전</a></li>";
                    } 
                    //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
                    for($i = $block_start; $i <= $block_end; $i++){
                        if($page == $i){
                            echo "<li class='fo_re'>[$i]</li>";
                        }else{
                            echo "<li><a href = '?page = $i'>[$i]</a></li>";
                        }
                    }
                    if($block_num >= $total_block){

                    }else{ //만약 현재 블록이 블록 총개수보다 작다면
                        $next = $page + 1;
                        echo "<li><a href= '?page = $next '> 다음 </a></li>";
                    }
                    if($page >= $total_page){
                        echo "<li class = 'fo_re'> 마지막 </li>";
                    }else{
                        echo "<li><a href = '?page=$total_page'>마지막</a></li>";
                    }
                ?>
            </ul>
        </div>
        <div id="write_btn">
            <a href="/page/board/write.php"><button>글쓰기</button></a>
        </div>
    </div>
</body>
</html>