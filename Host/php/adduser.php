<?php
    require_once 'db.php';

    $username = $_POST['un'];
    $password = $_POST['pw'];
    $name = $_POST['n'];
    $password = md5($password);

    if((isset($username) && !empty($username)) && (isset($password) && !empty($password)) && (isset($name) && !empty($name))){
        $sql = "INSERT INTO UserInfo (username, password, name) VALUE ('$username', '$password', '$name')";
        $query = mysqli_query($_SESSION['link'], $sql);
    
        if($query){
            if(mysqli_affected_rows($_SESSION['link']) == 1){
                echo "yes";
            }
        }else{
            console.log("Error with query: " + mysqli_error($_SESSION['link']));
            echo "no";
        }
    }else{
        echo "invalid input";
    }
    
?>