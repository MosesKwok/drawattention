<?php
    require_once 'db.php';

    define('UPLOAD_DIR', '../../../drawattentionphoto/gamephoto/');
    $userid = $_SESSION['login_id'];
    $username = $_SESSION['login_username'];
    $contentid = $_POST['id'];
    $title = $_POST['title'];
    $jsondata = $_POST['jsondata'];
    $photodata = $_POST['photodata'];
    $timevalue = date("Y-m-d H:i:s");

    if((isset($userid) && !empty($userid)) && (isset($jsondata) && !empty($jsondata))){
        $sql = "UPDATE ContentList SET content_title='$title', last_edit='$timevalue', content_setting='$jsondata' WHERE contentid='$contentid' ";
        $query = mysqli_query($_SESSION['link'], $sql);
    
        if($query){
            if(mysqli_affected_rows($_SESSION['link']) == 1){
                for($i=0; $i<count($photodata); $i++){
                    $file = UPLOAD_DIR . $contentid . '_Q' . ($i+1) .'.png';
                    if($photodata[$i]['photodata']!=""){
                        $imgdata = $photodata[$i]['photodata'];
                        $imgdata = str_replace('data:image/png;base64,', '', $imgdata);
                        $imgdata = str_replace('data:image/jpeg;base64,', '', $imgdata);
                        $imgdata = str_replace(' ', '+', $imgdata);
                        $data = base64_decode($imgdata);
                        $success = file_put_contents($file, $data);
                    }else{
                        $imagefiles = file_exists($file);
                        if($imagefiles){
                            $deletename = UPLOAD_DIR . 'delete_' . $contentid . '_Q' . ($i+1) .'.png';
                            $success = rename($file, $deletename);
                        }
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