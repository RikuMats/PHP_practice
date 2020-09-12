<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>
           PHP bulletin bord 
        </title>
        <meta charset="UTF-8">
    </head>
    <body>
        <form method="post" action="PHP_BulletinBord.php">
            <h2>新規投稿</h2>
            名前:
            <input type="text" name = "name">
            <br>
            コメント:
            <input type ="text" name="comment">
            <br>
            <hr>
            <h2>削除</h2>
            削除対象番号:
            <input type="text" name = "rmIndex" >
            <br>

            <hr>
            <h2>編集</h2>
            編集したい番号:
            <input type="text" name="editIndex">
            <br>
            新しいコメント:
            <input type="text" name="newComment">
            <br>
            <hr>
            パスワード:
            <input type="password" name="pass">
            <input type="submit" value="submit">
        </form>

        <?php
        //POSTから受け取ったもの
        $name = $_POST["name"];
        $pass = $_POST["pass"];
        $comment = $_POST["comment"];
        $newComment = $_POST["newComment"];
        $rmIdx = $_POST["rmIndex"];
        $editIdx=$_POST["editIndex"];
        $date = date("Y/m/d H:i:s");

        //SQL準備
        $dsn = 'mysql:dbname=****;host=localhost';
        $user = '****';
        $password = '****';
        $pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        //投稿
        if(!empty($name)&&!empty($pass)&&!empty($comment)){
            $sql = $pdo -> prepare("INSERT INTO mission5 (name,password,comment,date) VALUES (:name,:password,:comment,:date)");
            $sql->bindParam(':name',$name,PDO::PARAM_STR);
            $sql->bindParam(':password',$pass,PDO::PARAM_STR);
            $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
            $sql->bindParam(':date',$date,PDO::PARAM_STR);
            $sql->execute();
        }
        //削除
        if(!empty($rmIdx)&&!empty($pass)){
            $sql = 'DELETE FROM mission5 WHERE id=:rmid AND password=:password';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':rmid',$rmIdx,PDO::PARAM_STR);
            $stmt->bindParam(':password',$pass,PDO::PARAM_STR);
            $stmt ->execute();
            

        }

        //編集
        if(!empty($editIdx)&&!empty($pass)&&!empty($newComment)){
            $sql = 'UPDATE mission5 SET comment=:comment , date=:date WHERE id=:editid AND password=:password';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':editid',$editIdx,PDO::PARAM_STR);
            $stmt->bindParam(':password',$pass,PDO::PARAM_STR);
            $stmt->bindParam(':comment',$newComment,PDO::PARAM_STR);
            $stmt->bindParam(':date',$date,PDO::PARAM_STR);
            $stmt->execute();
        }

        //表示
        $sql = "SELECT * FROM mission5";
        $stmt = $pdo->query($sql);
        $result =$stmt->fetchAll();
        foreach($result as $row){
            echo $row['id']." ";
            echo $row['name']." ";
            echo $row['comment']." ";
            echo $row['date']." ";
            echo "<br>";
        }
        echo "<hr>";

        ?>
    </body>
</html>
