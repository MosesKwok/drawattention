<?php
    ini_set('display_errors','1');
    error_reporting(E_ALL);
?>

<?php
    require_once 'php/db.php';
    
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        header("Location: login.php");
    }

    $userid = $_SESSION["login_id"];
    $username = $_SESSION['login_username'];
    $noresult = true;
    $norecord = true;
    
    $recordchoice = 0;

    $sql = "SELECT * FROM ContentList WHERE userid='$userid' AND username='$username' ORDER BY last_edit DESC";
    $query = mysqli_query($_SESSION['link'], $sql);
    $totalresult = mysqli_num_rows($query);
    if($totalresult<=0){
        $noresult = true;
    }else{
        $noresult = false;
        $listarray = array();
        $i = 0;
        while ($result = mysqli_fetch_array($query)) {
            $listarray[$i] = $result;
            $i++;
        }
    }

    function getrecord($contentid, $userid, $username){
        global $norecord, $totalrecord, $recordarray;

        $sql = "SELECT * FROM RecordList WHERE userid='$userid' AND username='$username' AND contentid='$contentid' ORDER BY record_time DESC";
        $query = mysqli_query($_SESSION['link'], $sql);
        $totalrecord = mysqli_num_rows($query);
        if($totalrecord<=0){
            $norecord = true;
        }else{
            $norecord = false;
            $recordarray = array();
            $i = 0;
            while ($record = mysqli_fetch_array($query)) {
                $recordarray[$i] = $record;
                $i++;
            }
        }
    }

    function getdetail(&$recordarray, $recordchoice){
        global $contentcount, $json, $recordid;

        $recordid = $recordarray[$recordchoice]['recordid'];
        $jsonstring = $recordarray[$recordchoice]['content_setting'];
        $json = json_decode($jsonstring, true);
        $contentcount = count($json["content"]);
    }

    if (isset($_GET['contentid'])) {
        $contentid = $_GET['contentid'];
        getrecord($contentid, $userid, $username);
        if (isset($_GET['recordchoice'])) {
            $recordchoice = $_GET['recordchoice'];
            if(!$norecord){
                getdetail($recordarray, $recordchoice);
            }
        }
    }

    
    
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
        <title>records</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/records.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <script>
            
            $(document).on('change','#detail_selector',function(){
                var recordchoice = $(this).val();
                window.location.href = "records.php?contentid=<?php echo $_GET['contentid'];?>&recordchoice="+recordchoice;
            });

            $(document).on('change','.playerselector',function(){
                var imglink = $(this).val();
                var contentid = <?php echo $contentid; ?>;
                $(this).closest('tr').find('img').attr("src",'php/readrecordimage.php?contentid='+contentid+'&img='+imglink);
            });


        </script>
    </head>

    <body>
        
        <?php include_once 'php/navbar.php'; ?>

        <div class="container custom-container-width">
            <div class="row">
                <div class="col-3" style="background-color:white;height:650px;overflow:auto" >
                    <table class="table table-hover">
                        <tbody>
                            <?php
                                for($i=0; $i<$totalresult; $i++){
                                    echo '<tr>';
                                    echo '<th scope="row">'.($i+1).'</th>';
                                    echo '<td>';
                                    if($norecord){
                                        echo '<a href="records.php?contentid='.$listarray[$i]['contentid'].'" >';
                                    }else{
                                        echo '<a href="records.php?contentid='.$listarray[$i]['contentid'].'&recordchoice=0'.'" >';
                                    }
                                    echo '<span class="titletext">'.$listarray[$i]['content_title'].'</span>';
                                    echo '</a></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
              
                <div class="col-9">
                    <div class="row">
                        <?php if($norecord) { ?>
                            <div class="empty page col-12"  >
                                <div class="row">
                                    <div class="col-12"> 
                                        <div style="text-align:center;margin-top:100px;">
                                            <img src="img/graph.png" class="graph" width="200" >     
                                        </div>                             
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"> 
                                        <div style="text-align:center;"> 
                                            <br>
                                            <span class="text2">Uncharted territory:</span>
                                            <br>
                                            <span class="text2">there are no records… yet!</span>                                     
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }else{  ?>

                            <div class="record page col-12 text-center">
                                <select class="form-control m-4 w-50" id="detail_selector">
                                    <?php
                                        for($i=0; $i<$totalrecord; $i++){
                                            $recordtime = $recordarray[$i]['record_time'];
                                            if($recordchoice==$i){
                                                echo '<option value="'.$i.'" selected>'.($i+1)."\t".$recordtime.'</option>';
                                            }else{
                                                echo '<option value="'.$i.'">'.($i+1)."\t".$recordtime.'</option>';
                                            }
                                            
                                        }
                                    ?>
                                </select>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">title</th>
                                            <th scope="col">image</th>
                                            <th scope="col">player</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(isset($_GET['recordchoice'])){
                                                for($i=0; $i<$contentcount; $i++){
                                                    if($json['content'][$i]['type']=="cooperation"){
                                                        $imagelink = '../../drawattentionphoto/recordphoto/'.$contentid.'/'.$recordid.'_Q'.($i+1).'.png';
                                                    }else if($json['content'][$i]['type']=="separate"){
                                                        $playerlist = array();
                                                        $matchesfile = glob('../../drawattentionphoto/recordphoto/'.$contentid.'/'.$recordid.'_Q'.($i+1).'_'.'*'.'.png');
                                                        for($j=0; $j<count($matchesfile); $j++){
                                                            $playername = str_replace('../../drawattentionphoto/recordphoto/'.$contentid.'/'.$recordid.'_Q'.($i+1).'_','',$matchesfile[$j]);
                                                            $playername = str_replace('.png','',$playername);
                                                            $playerlist[$j] = $playername;
                                                        }
                                                        $imagelink = $matchesfile[0];
                                                    }
                                                    
                                                    $imagefile = file_get_contents($imagelink);
                                                    $base64 = base64_encode($imagefile);
                                                    echo '<tr>';
                                                    echo '<td>'.($i+1).'</td>';
                                                    echo '<td>'.$json['content'][$i]['Q'].'</td>';
                                                    echo '<td><img src="data:image/jpg;base64,'.$base64.'" height="100px"></td>';
                                                    if($json['content'][$i]['type']=="separate"){
                                                        echo '<td><select class="playerselector form-control m-4 w-50">';
                                                        for($j=0; $j<count($matchesfile); $j++){
                                                            $optionvalue = str_replace('../../drawattentionphoto/recordphoto/'.$contentid.'/','',$matchesfile[$j]);
                                                            $optionvalue = str_replace('.png','',$optionvalue);
                                                            echo '<option value="'.$optionvalue.'">'.$playerlist[$j].'</option>';
                                                        }
                                                        echo '</td>';
                                                    }else{
                                                        echo '<td></td>';
                                                    }
                                                    echo '</tr>';
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>     
        </div>


    </body>
</html>