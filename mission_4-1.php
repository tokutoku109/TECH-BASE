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

?>