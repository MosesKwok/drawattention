<?php
    $dbhost = 'localhost:3306';
    $dbuser = 'helper';
    $dbpass = 'BGuyLg_E5lxoQds8x';
    $dbname = 'TestForSQL';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if(!$conn){
        die('Database Connection Failed: ' . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM Customer";
    $result = $conn->query($sql);
    
    $resultArray = array();
    $tempArray = array();
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $tempArray = $row;
            array_push($resultArray, $tempArray);
        }
        echo json_encode($resultArray);
    }
    
    mysqli_close($con);
    
?>
