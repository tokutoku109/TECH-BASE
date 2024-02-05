<?php

//[サンプル]
//・データベース名:tb250626db
//・・ユーザー名:tb-250626
//・パスワード:VZ5ZbRuUex
//・の学生の場合:

// DB接続設定
    $dsn ='mysql:dbname=tb250626db;host=localhost';
    $user = 'tb-250626';
    $password = 'VZ5ZbRuUex';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name CHAR(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);

//テーブル一覧の表示
    $sql ='SHOW TABLES';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
?>