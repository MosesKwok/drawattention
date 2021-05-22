<?php
    require_once 'db.php';

    $username = $_POST['un'];
    $password = $_POST['pw'];
    $password = md5($password);

    if((isset($username) && !empty($username)) && (isset($password) && !empty($password))){
        $sql = "SELECT * FROM UserInfo WHERE username='$username' AND password='$password'";
        $query = mysqli_query($_SESSION['link'], $sql);
        
        if($query){
            if(mysqli_num_rows($query) >= 1){
                $user = mysqli_fetch_assoc($query);
                $_SESSION['is_login'] = TRUE;
                $_SESSION['login_id'] = $user['id'];
                $_SESSION['login_username'] = $user['username'];
                $_SESSION['login_name'] = $user['name'];
                echo "yes";
            }else{
                echo "no";
            }
        }else{
            console.log("Error with query: " + mysqli_error($_SESSION['link']));
            echo "error";
        }
    }else{
        echo "invalid input";
    }
?>