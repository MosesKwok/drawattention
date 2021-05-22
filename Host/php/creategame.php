<?php
    require_once 'db.php';

    define('UPLOAD_DIR', '../../../drawattentionphoto/gamephoto/');
    $userid = $_SESSION['login_id'];
    $username = $_SESSION['login_username'];
    $title = $_POST['title'];
    $jsondata = $_POST['jsondata'];
    $photodata = $_POST['photodata'];
    $timevalue = date("Y-m-d H:i:s");

    if((isset($userid) && !empty($userid)) && (isset($jsondata) && !empty($jsondata))){
        $sql = "INSERT INTO ContentList (userid, username, content_title, last_edit, content_setting) VALUE ('$userid', '$username', '$title', '$timevalue', '$jsondata')";
        $query = mysqli_query($_SESSION['link'], $sql);
    
        if($query){
            if(mysqli_affected_rows($_SESSION['link']) == 1){
                $returnsql = "SELECT LAST_INSERT_ID()";
                $returnresult = mysqli_query($_SESSION['link'], $returnsql);
                $insertvalue = mysqli_fetch_row($returnresult);

                for($i=0; $i<count($photodata); $i++){
                    if($photodata[$i]['photodata']!=""){
                        $imgdata = $photodata[$i]['photodata'];
                        $imgdata = str_replace('data:image/png;base64,', '', $imgdata);
                        $imgdata = str_replace('data:image/jpeg;base64,', '', $imgdata);
                        $imgdata = str_replace(' ', '+', $imgdata);
                        $data = base64_decode($imgdata);
                        $file = UPLOAD_DIR . $insertvalue[0] . '_Q' . ($i+1) .'.png';
                        $success = file_put_contents($file, $data);
                    }
                }
                echo $success ? 'yes and save photo' : 'yes but no photo';
            }
        }else{
            console.log("Error with query: " + mysqli_error($_SESSION['link']));
            echo "no";
        }
    }else{
        echo "invalid input";
    }
    
?>