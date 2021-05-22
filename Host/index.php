<?php
    require_once 'php/db.php';
    
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        header("Location: login.php");
    }

    $userid = $_SESSION["login_id"];
    $username = $_SESSION['login_username'];
    $gamelisthide = false;
    
    $sql = "SELECT * FROM ContentList WHERE userid='$userid' AND username='$username' ";
    $query = mysqli_query($_SESSION['link'], $sql);
    $totalresult = mysqli_num_rows($query);
    if($totalresult<1){
        $gamelisthide = true;
    }else{
        $listarray = array();
        $i = 0;
        while ($result = mysqli_fetch_array($query)) {
            $listarray[$i] = $result;
            $i++;
        }
    }

    $sql = "SELECT * FROM RecordList WHERE userid='$userid' AND username='$username' ";
    $query = mysqli_query($_SESSION['link'], $sql);
    $totalrecordresult = mysqli_num_rows($query);
?>

<html>
    <head>
        <title>DrawAttention互動遊戲-首頁</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/index.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        
        <?php include_once 'php/navbar.php'; ?>

        <div class="container custom-container-width">
            <div class="row m-4">
                <div class="col-3">
                    <div class="userinfo text-center">
                        <a href="#" class="m-4">
                            <img class="m-2" src="img/user.png" width="60%">
                            <div>
                                <?php echo $_SESSION['login_name'] ?>
                            </div>
                        </a>
                        <div class="infobox">
                            <div class="row m-3">
                                <label>Plays of your D.ttention:</label>
                                <div class="text-center recordresult"> <?php echo $totalrecordresult; ?> </div>
                            </div>
                        </div>
                        <div class="infobox">
                            <div class="row m-3">
                                <label>Total players:</label> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col" >
                            <div class="list">
                                <div class="p-2">
                                    <span class="word1"> Get started :</span>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="junior">
                                        <img  src="img/account.png" width="125">
                                        </div>
                                        <div class="step">
                                        <span>Step 1:</span><br>
                                        <span>create an account</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="junior">
                                        <img  src="img/question.png" width="125">
                                        </div>
                                        <div class="step">
                                        <span>Step 2:</span><br>
                                        <span>create question</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="junior">
                                        <img  src="img/social.png" width="125">
                                        </div>
                                        <div class="step">
                                        <span>Step 3:</span><br>
                                        <span>host game</span>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        
                        <!--唔好搞-->
                        <div class="col-12" ><div class="block"></div></div>
                        <!--唔好搞-->

                        <div class="col-12" >
                            <div class="list_1" >
                                <div class="p-2">
                                    <span class="word1"> My </span><span class="word2">D.ttention :</span>
                                    <a href="create.php" class="float-right"><img src="img/create.png" width="100" height="40"></a> 
                                </div>
                                <hr>
                                <div class="gamelist text-center">
                                <table class="table table-hover"  <?php if($gamelisthide){echo 'style="display:none"';} ?>>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <img class="pic" src="img/pic.png" width="30">
                                                <label class="title"> <?php echo $listarray[$i-1]['content_title'] ?> </label>
                                                <a href="<?php echo 'http://test.moseskwok.com/host.php?contentid='.$listarray[$i-1]['contentid'].'&userid='.$userid.'&username='.$username; ?>" class="playbutton">
                                                    <img src="img/game-controller.png" width="40">
                                                    <span>Play</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr <?php if($totalresult==1){echo 'style="display:none"';} ?>>
                                            <td class="text-center">
                                                <img class="pic" src="img/pic.png" width="30">
                                                <label class="title"> <?php echo $listarray[$i-2]['content_title'] ?> </label>
                                                <a href="<?php echo 'http://test.moseskwok.com/host.php?contentid='.$listarray[$i-2]['contentid'].'&userid='.$userid.'&username='.$username; ?>" class="playbutton">
                                                    <img src="img/game-controller.png" width="40">
                                                    <span>Play</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="no-hover" <?php if($totalresult<3){echo 'style="display:none"';} ?>>
                                            <td class="text-center">
                                                <a href="dttention.php">More</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <label <?php if($totalresult>0){echo 'style="display:none"';} ?>>
                                    Create a new game now!
                                </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="list2">
                        <div class="p-2">
                            <span class="word1"> Latest records:  </span>
                        </div>
                        <hr>
                        <div class="lasterreport">    
                            <span class="word2">Since you haven’t hosted any<br>
                            games yet, we’re showing you a<br>
                            sample report so you can get the<br>
                            gist of it.<br></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>