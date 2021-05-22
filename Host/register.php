<?php
    require_once 'php/db.php';
?>
<html lang="zh-TW">
    <head>
        <title>會員註冊</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/register.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            $(document).ready(function() {

                $("#username").on("keyup", function(){
                    var keyin_value = $(this).val();
                    if(keyin_value != ''){
                        $.ajax({
                            type : "POST",
                            url : "php/check_username.php",
                            data : {
                                name : $(this).val()
                            },
                            dataType : 'html',

                            success : function(data){
                                if(data == "yes"){
                                    $("#usernamewarning").remove();
                                    $("#username").parent().removeClass("has-error").addClass("has-success");
                                    $("form.register button[type='submit']").removeClass('disabled');
                                }else{
                                    $("#username").after("<div class='alert alert-danger usernamewarning' id='usernamewarning'>帳號有重複，不可以註冊</div>");
                                    $("#username").parent().removeClass("has-success").addClass("has-error");
                                    $("form.register button[type='submit']").addClass('disabled');
                                }
                            },

                            error : function(jqXHR, textStatus, errorThrown) {
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            }
                        });
                    }else{
                        $("#username").parent().removeClass("has-success").removeClass("has-error");
                    }
                });

                $("form.register").on("submit", function(){
                    var username = $("#username").val();
                    var password = $("#password").val();
                    var confirmpassword = $("#confirm_password").val();
                    var name = $("#name").val();

                    if (password != confirmpassword) {
                        $("#password").parent().addClass("has-error");
                        $("#confirm_password").parent().addClass("has-error");
                        $("#result").text("密碼並不一致");
                        $("#result").attr("class","alert alert-danger");
                    }else{

                        if(username.length==0 || password.length==0 || name.length==0){
                            $("#result").text("有缺漏的資料還沒輸入");
                            $("#result").attr("class","alert alert-danger");
                        }else{
                            var request = $.ajax({
                                type : "POST",
                                url : "php/adduser.php",
                                data : {
                                    un : username,
                                    pw : password,
                                    n : name
                                },
                                dataType : "html",

                                success : function(data) {
                                    console.log(data);
                                    if(data == "yes"){
                                        alert("註冊成功，將自動前往登入頁。");
                                    }else if(data == "invalid input"){
                                        $("#submit").after("<br><br><div class='alert alert-danger'>Here");
                                        alert("錯誤輸入");
                                    }else{
                                        alert("註冊失敗，請與系統人員聯繫");
                                    }
                                },

                                error : function(jqXHR, textStatus, errorThrown) {
                                    alert("有錯誤產生，請看 console log");
                                    console.log(jqXHR.responseText);
                                }
                            });
                        }
                    }
                    return false;
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
                <a href="login.php" ><img src="img/login.png" width="100" ></a>
            </ul>
        </nav>

        <div class="content">
        <div class="container">
            <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                <h1>Register Account 註冊新帳號</h1>
                <form class="register">
                    <div class="form-group">
                        <label for="username">Account 帳號</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="請輸入帳號" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password 密碼</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password 確認密碼</label>
                        <input type="password" class="form-control" id="confirm_password" name="password" placeholder="請再次輸入密碼" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Username 名稱</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入您的名稱" required>
                    </div>
                    <button type="submit" class="btn btn-default" id="submit">
                        註冊
                    </button>
                    <button type="button" class="btn btn-default" onclick="window.location.href='login.php'">
                        返回
                    </button>
                </form>
                <div id="result"></div>
            </div>
            </div>
        </div>
        </div>
    </body>
</html>