<?php
    require_once 'db.php';

    $result = null;
    $username = $_POST["name"];
    $sql = "SELECT * FROM UserInfo WHERE username='$username'";
    $query = mysqli_query($_SESSION['link'], $sql);

    if ($query){
        if (mysqli_num_rows($query) >= 1){
            $result = true;
        }
        mysqli_free_result($query);
    }else{
        echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }

    if($result){
        echo 'no';
    }else{
        echo 'yes';	
    }

?>