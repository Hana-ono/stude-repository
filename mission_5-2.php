<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_5-1</title>
</head>
<body>
        <!--mission_1-20を使う　数値を扱うのでtype="text"からnumberへ-->
        <form action="" method="post">
            
            <input type="string" name="name" placeholder="Name">NAME<br>
            <input type="password" name="password" placeholder="PassWord">PASSWORD<br><br>
            <input type="string" name="comment" placeholder="Comment">
            <button type="submit" name="flag" value=1>投稿</button><br>
            <input type="number" name="dstep" placeholder="Delete Number">
            <button type="submit" name="dflag" value=1 >削除</button><br>
            <input type="number" name="estep" placeholder="Edit Number">
            <button type="submit" name="eflag" value=1>編集</button>
        </form>
        <?php
        //Mysqlに接続
        $dsn = 'mysql:dbname=*********;host=**********';
	    $user = '************';
	    $password = '***********';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //ログインデータ
            $name = $_POST["name"];
            $pass = $_POST["password"];
            $submitDate = date("Y/m/d/ H:i:s");
        //新規投稿関係 
            $comment = $_POST["comment"];
            $flag    = $_POST["flag"];
        //削除関係
            $dstep = $_POST["dstep"];
            $dflag = $_POST["dflag"];
        //編集関係
            $estep = $_POST["estep"];
            $eflag = $_POST["eflag"];
        //メッセージ
            $message = "Display";
            
    /*---------------------------------------------------------------------------------*/
        //削除
            if($dflag == 1){
                $sql  = 'SELECT * FROM mission51 WHERE id=:id';
                $stmt = $pdo->prepare($sql);//queryからprepareに変更した
	            $stmt -> bindParam(':id', $dstep);
	            $stmt -> execute();
	            $results = $stmt->fetchAll();
	            foreach($results as $row){
	                if($row['password'] == $pass){
	                    $sql = $pdo -> prepare("DELETE FROM mission51 WHERE id = :id");
	                    $sql -> bindParam(':id', $dstep, PDO::PARAM_STR);
                        $sql -> execute();
                        $message = "Delete"."$dstep";
	                }
	            }
	            
	    //編集
            }elseif($eflag == 1){
                $sql  = 'SELECT * FROM mission51 WHERE id=:id';
                $stmt = $pdo->prepare($sql);//queryからprepareに変更した
	            $stmt -> bindParam(':id', $estep);
	            $stmt->execute();
	            $results = $stmt->fetchAll();
	            foreach($results as $row){
	                if($row['password'] == $pass){
	                    $sql = 'UPDATE mission51 SET name=:name,comment=:comment WHERE id=:id';
	                    $stmt = $pdo->prepare($sql);
	                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	                    $stmt->bindParam(':id', $estep, PDO::PARAM_INT);
	                    $stmt->execute();
	                    $message = "Edit"."$estep";
	                }
	            }
	            
	    //投稿
            }elseif($flag == 1){
                if(!empty($name&&$comment&&$pass)){
	                $sql = $pdo -> prepare("INSERT INTO mission51 (name, comment, submitDate, password) VALUES (:name, :comment, :submitDate, :password)");
	                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	                $sql -> bindParam(':submitDate', $submitDate, PDO::PARAM_STR);
	                $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
	                $sql -> execute();
	                $message = "New Post";
                }
            }
            
    /*-------------------------------------------------------------------------------------*/        
        
        //表示
            echo $message."<br>";
            $sql = 'SELECT * FROM mission51 ';
	        $stmt = $pdo->query($sql);
	        $stmt->execute();
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		        echo "<hr>";
		        echo $row['id'].' ';
		        echo $row['name'].' ';
		        echo $row['submitDate'].'<br><br>';
		        echo '  '.$row['comment'].'<br><br>';
	        }
	        echo "<hr>";
        ?>
</body>
</html>