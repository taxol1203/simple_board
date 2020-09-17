<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include $_SERVER['DOCUMENT_ROOT']."/db.php";
?> 
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>검색 결과 게시판</title>
    <link rel = "stylesheet" type = "text/css" href="/css/mystyle.css" />
</head>

<body>
<!-- 변수 받기 -->
<?php
    $category = $_GET['catgo'];
    $search_con = $_GET['search'];
?>
<div id = "board_area">
    <h1> <?php echo $category; ?>에서 <?php echo $search_con; ?>의 검색결과 </h1>
    <h4 style = "margin-top:30px;"><a href="/index.php">홈으로</a><h4>
        <table class = "list-table">
            <thead>
                <tr>
                    <th width = "70">번호</th>
                    <th width = "500">제목</th>
                    <th width = "120">글쓴이</th>
                    <th width = "100">작성일</th>
                    <th width = "100">조회수</th>
                </tr>
            </thead>
            <?php
                $sql2 = mq("select * from board where $category like '%$search_con%' order by idx desc" );
                while($board = $sql2->fetch_array()){
                    $title = $board['title'];
                    if(strlen($title)>30){ 
                        $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                    }
                    $sql3 = mq("select * from reply where con_num= ".$board['idx']."  ");
                    $rep_count = mysqli_num_rows($sql3);    
            ?>
            <tbody>
                <tr>
                    <td width="70"><?php echo $board['idx']; ?></td>
                    <td width="500"> <?php
                            //get lock image
                            $lockimg = "<img src = '/img/lock.png' alt='lock' width = '20' height = '20' />";
                            //만약 1이면 ch_read로 이동하고, 사진을 띄운다
                            $boardtime = $board['date'];
                            $timeNow = date("Y-m-d");
                            if($boardtime == $timeNow){
                                $img = "<img src = '/img/new.png' alt = 'new' title='new' />";
                            }else{
                                $img = "";
                            }
                            if($board['lock_post'] == "1"){
                                ?> 
                                <a href = '/page/board/ck_read.php?idx=<?php echo $board["idx"];?>'> 
                                <?php echo $title, $lockimg;
                            }else{ 
                                ?> 
                                <a href="/page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $title; 
                            }?> 
                            <span class ="re_ct"> [ <?php echo $rep_count; ?> ]<?php echo $img; ?> </span>
                            </a>
                        </td>
                    <td width="120"><?php echo $board['name']?></td>
                    <td width="100"><?php echo $board['date']?></td>
                    <td width="100"><?php echo $board['hit']; ?></td>
                </tr>
            </tbody>
            <?php }?>
        </table>
        
        <div id = "search_box2">
            <form action = "/page/board/search_result.php" method = "get">
            <select name= "catgo">
                <option value="title">제목</option>
                <option value="name">글쓴이</option>
                <option value="content">내용</option>
            </select>
            <input text = "text" name = "search" size = "40" required = "required" />
            <button> 검색 </button>
            </form>
        </div>
</body> 