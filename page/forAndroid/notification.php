<?php
    //push notification to app, which made web when new post written through
    $ch = curl_init("https://fcm.googleapis.com/fcm/send");
    $header = array("Content-Type:application/json", "Authorization:key=AAAAajj_oGw:APA91bGJ40Fuzn3x7xz2UZt4cBKHduzt6K-U28Swo09IPOEzCdCD7RMwR5dVcpOy7zDL-nM9JTXsZ1b4rb2_c3_pN_QyyjNOW4Hfxdrf-dwVWUa3NNzOb8TH6ZOivwXwwsbxtYx1PNxG");
    $data = json_encode(array(
        "to" => "d7trLq1GRNKB-et4A9F1W9:APA91bH6kYG6m2hZZmC___UPk-ld2L_Pp_aAovCW5umgxriwxV8DQsIqi-d_Q3x0f2jX5uITxWaDJrU9LSVEj3zC4x8-zwhwSDMEQY8pCxxIv0pzWG2mKsgffSYZRUu_hY6OP4RNa73P",
        "notification" => array(
            "title"   => "New Post!",
            "body" => "Web made new Post. Plz check")
            ));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_exec($ch);

    echo   "<script>
                location.href='/index.php';
            </script>";
?>