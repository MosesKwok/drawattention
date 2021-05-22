<?php
    require_once 'php/db.php';
?>
<html>
    <head>
        <title>DrawAttention互動遊戲-登入</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"/>
        <link rel="stylesheet" href="css/login.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            $(document).ready(function(){
                
                $("form.login").on("submit", function(e){

                    e.preventDefault();
                    var username = $("#username").val();
                    var password = $("#password").val();

                    if(username.length==0 || password.length==0){
                        $("#result").text("帳號或密碼還沒完成輸入");
                        $("#result").attr("class","alert alert-danger");
                    }else{
                        var request = $.ajax({
                            type : "POST",
                            url : "php/verify_user.php",
                            data : {
                                un : username,
                                pw : password
                            },
                            dataType : "html",

                            success : function(data) {
                                console.log(data);
                                if(data == "yes"){
                                    window.location.href = "index.php";
                                }else if(data == "no"){
                                    $("#result").html("Incorrect Account or Password<br>帳號或密碼有錯誤");
                                    $("#result").attr("class","alert alert-danger");
                                }else{
                                    alert("Login failed,please contact system personnel! 登入失敗，請與系統人員聯繫");
                                }
                            },

                            error : function(jqXHR, textStatus, errorThrown) {
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            }
                        });
                    }
                });
            });
        </script>
    </head>
    <body>
        <nav class="navbar">
            <ul class="nav navbar-nav">
                <a href="https://drawattention.moseskwok.com/"><img src="img/logo.png" width="180"></a>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <a href="register.php"><img src="img/signup.png" width="98"></a>
            </ul>
        </nav>
            
        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col-10 p-3 text-center">
                    <h1>Login 登入</h1>
                    <form class="login">
                        <div class="form-group">
                            <img src="img/user.png" height="42" width="42">
                            <input type="text" class="inputtextfield" id="username" name="username" placeholder="&emsp;&emsp;USERNAME">
                        </div>
                        <div class="form-group">
                            <img src="img/padlock.png" height="42" width="42">
                            <input type="password" class="inputtextfield" id="password" name="password" placeholder="&emsp;&emsp;PASSWORD">
                        </div>
                        <button type="submit" class="submitbutton" id="submit">Login 登入</button>
                    </form>
                    <a class="forgetpassword" href="#">Forget Password(未開放)</a>
                    <div id="result"></div>
                    <p class="line m-2">——————————or—————————</p>
                    
                    <button class="speciallogin" onclick="javascript:location.href='#'">
                        <p>
                            <img src="img/facebook.png">
                            Login With Facebook(未開放)
                        </p>
                    </button>

                    <button class="speciallogin" onclick="javascript:location.href='#'">
                        <p>
                            <img src="img/google.png">
                            Login With Google(未開放)
                        </p>
                    </button>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </body>
    
</html>