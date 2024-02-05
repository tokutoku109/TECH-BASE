<?php

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

//データを入力
    $name = '一郎';
    $comment = 'おはよう'; 

    $sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
//データ削除
$id = 3;
    $sql = 'delete from tbtest where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    
//入力したデータレコードを抽出し、表示する
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";
    }


?>