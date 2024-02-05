<!DOCTYPE html> 
<html lang="ja"> 
<head> 
    <meta charset="UTF-8"> 
    <title>mission_5-1-1</title> 
</head> 
<body> 
    
    <?php 
        //DB接続 
        $dsn = 'mysql:dbname=XXXDB;host=localhost'; 
        $user = 'XXXUSER'; 
        $password = 'XXXPASSWORD'; 
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 
         
         
        //テーブル作成 
        $sql = "CREATE TABLE IF NOT EXISTS techtb" 
        ." (" 
        . "id INT AUTO_INCREMENT PRIMARY KEY," 
        . "name CHAR(32)," 
        . "comment TEXT," 
        . "Postedtime TEXT," 
        . "password TEXT" 
        .");"; 
        $stmt = $pdo->query($sql); 
         
         
         
         
             
         
        $edit_name = ""; 
        $edit_comment = ""; 
        $postnumber = ""; 
         
         
        // 投稿チェック 
        if(!empty($_POST["comment"]) && !empty($_POST["password"])) 
        {    
            //名前が入力されない場合名無しとして扱う 
            if(isset($_POST["name"]) && !empty($_POST["name"])){ 
                $name = $_POST["name"]; 
            }else{ 
                $name = "名無し"; 
            }    
             
            $comment = $_POST["comment"]; 
            $Postedtime = date("Y/m/d H:i:s"); 
            $password = $_POST["password"]; 
             
             
            //編集or新規で分岐 
            if(empty($_POST["postnum"])){ 
                //新規 
                $sql = "INSERT INTO techtb (name, comment, Postedtime, password) VALUES (:name, :comment, :Postedtime, :password)"; 
                $stmt = $pdo->prepare($sql); 
                $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR); 
                $stmt->bindParam(':Postedtime', $Postedtime, PDO::PARAM_STR); 
                $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
                $stmt->execute(); 
                 
            }else if(!empty($_POST["postnum"]) && !empty($_POST["password"])){ 
                //編集 
                $id = $_POST["postnum"]; 
                 
                $sql = 'UPDATE techtb SET name=:name,comment=:comment,password=:password,Postedtime=:Postedtime WHERE id=:id'; 
                $stmt = $pdo->prepare($sql); 
                $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR); 
                $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
                $stmt->bindParam(':Postedtime', $Postedtime, PDO::PARAM_STR); 
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
                $stmt->execute(); 
                 
            } 
        } 
         
         
        //削除の機能 
        if(!empty($_POST["dnumber"]) && !empty($_POST["dpass"])){ 
           $dnumber = $_POST["dnumber"]; 
           $dpass = $_POST["dpass"]; 
            
           $sql = 'SELECT * FROM techtb WHERE id=:id'; 
           $stmt = $pdo->prepare($sql); 
           $stmt->bindParam(':id', $dnumber, PDO::PARAM_INT);  
           $stmt->execute(); 
           $results = $stmt->fetchAll(); 
            
           foreach ($results as $row) { 
            if($dpass == $row["password"]){ 
                $sql = 'DELETE FROM techtb WHERE id=:id'; 
                $stmt = $pdo->prepare($sql); 
                $stmt->bindParam(':id', $dnumber, PDO::PARAM_INT); 
                $stmt->execute(); 
            }else{ 
                echo "パスワードが違います！<br>"; 
            } 
           } 
        } 
         
         
        //編集の機能 
        if(!empty($_POST["enumber"])){ 
           $enumber = $_POST["enumber"]; 
           $epass = $_POST["epass"]; 
            
           $sql = 'SELECT * FROM techtb WHERE id=:id'; 
           $stmt = $pdo->prepare($sql); 
           $stmt->bindParam(':id', $enumber, PDO::PARAM_INT);  
           $stmt->execute(); 
           $results = $stmt->fetchAll(); 
            
           foreach ($results as $row) { 
            if($epass == $row["password"]){ 
                $edit_name = $row["name"]; 
                $edit_comment = $row["comment"]; 
                $postnumber = $row["id"]; 
            }else{ 
                echo "パスワードが違います！<br>"; 
            } 
           } 
        } 
         
         
     
         
    ?> 
     
    <!-- フォーム作成 --> 
    <form action="" method="post"> 
        <input type="text"name="name" value="<?php echo $edit_name; ?>" placeholder="名前"> 
        <input type="text"name="comment" value="<?php echo $edit_comment; ?>" placeholder="コメント" > 
        <input type="hidden"name="postnum" value="<?php echo $postnumber; ?>" placeholder="投稿番号"> 
        <input type="text" name="password" placeholder="パスワード" > 
        <input type="submit"name="submit"> 
    </form> 
    <br> 
    <form action="" method="post"> 
        <input type="number"name="dnumber" placeholder="削除対象番号" > 
        <input type="hidden" name="dele"> 
        <input type="text" name="dpass" placeholder="パスワード" > 
        <input type="submit"name="delete" value="削除"> 
    </form> 
    <form action="" method="post"> 
        <input type="number" name="enumber" placeholder="編集対象番号" > 
        <input type="text" name="epass" placeholder="パスワード" > 
        <input type="submit"name="edit" value="編集"> 
    </form> 
    <br> 
    <br> 
     
    <?php 
        //データベースの内容をブラウザに表示 
        $sql = 'SELECT * FROM techtb'; 
        $stmt = $pdo->query($sql); 
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){ 
            echo $row['id'].'・'; 
            echo $row['name'].'・'; 
            echo $row['comment'].'・'; 
            echo $row['Postedtime'].'<br>'; 
        echo "<hr>"; 
    } 
    ?> 
</body> 
</html> 
