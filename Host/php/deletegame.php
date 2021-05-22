<?php
    require_once 'db.php';

    $userid = $_SESSION['login_id'];
    $username = $_SESSION['login_username'];
    $contentid = $_POST['id'];

    if((isset($userid) && !empty($userid)) && (isset($contentid) && !empty($contentid))){
        $sql = "DELETE FROM ContentList WHERE contentid='$contentid' AND userid='$userid';";
        $query = mysqli_query($_SESSION['link'], $sql);
    
        if($query){
            if(mysqli_affected_rows($_SESSION['link']) == 1){
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