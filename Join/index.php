<html>
    <head>
        <meta charset="UTF-8">
        <title>DrawAttention互動遊戲-加入</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/index.css">

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            $(document).ready(function() {

                $("form.join").on("submit", function(e){
                    e.preventDefault();
                    var pin = $("#pin").val();
                    var re = /^[0-9]+$/;

                    if(pin.length==0){
                        $("#result").text("還沒輸入號碼");
                        $("#result").attr("class","alert alert-danger");
                    }else if(!re.test(pin)){
                        $("#result").text("請輸入數字");
                        $("#result").attr("class","alert alert-danger");
                    }else{
                        window.location.href="http://test.moseskwok.com/join.php?pin="+pin;
                           
                        return false;
                    }
                });
            });
        </script>
    </head>
    <body>
        <nav class="navbar">
            <ul class="nav navbar-nav">
                <a href=""><img src="img/logo.png" width="180"></a>
            </ul>
        </nav>
        <!--  <?php include_once 'php/navbar.php'; ?> -->
        
        <div class="container">
            <div class="row">
                <div class="col p-3 text-center">
                    <h1>Join 加入</h1>
                    <h2>請輸入數字</h2>
                    <form class="join">
                        <input class="form-control text-center" id="pin" type="text" name="pin"><br>
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </form>
                    <div id="result"></div>
                </div>
            </div>
        </div>
    </body>
    <script>
        <?php
            $kick = $_GET['kick'];
            if(isset($kick) && !empty($kick)){
                if($kick=="timeout"){
                    echo '$("#result").text("被踢出房間");';
                    echo '$("#result").attr("class","alert alert-danger");';
                }else if($kick="wrongroom"){
                    echo '$("#result").text("房間不存在");';
                    echo '$("#result").attr("class","alert alert-danger");';
                }
            }
        ?>
    </script>
</html>