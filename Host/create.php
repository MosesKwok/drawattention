<?php
    require_once 'php/db.php';
    
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        header("Location: login.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">
    <head>
        <title>CREATE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/create.css">
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script>
            var Qnum = 2, currentQ = 1;
            var currentelement = $("tr a:eq("+(currentQ-1)+")");
            var $newrow;
            var json = {
                "title": "",
                "content": [
                    {
                        "Q": "NEW",
                        "time": "none",
                        "type": "separate"
                    },{
                        "Q": "NEW",
                        "time": "none",
                        "type": "separate"
                    }
                ]
            };
            var photojson = [
                {
                    "photodata" : ""
                },{
                    "photodata" : ""
                }
            ];

            function addnewQ(){
                Qnum++;
                $newrow = $('<tr><th scope="row">'+Qnum+'</th>'+
                    '<td onclick="changecurrentQ(this)"><label class="Qchoice">Q'+Qnum+'</label>'+
                    '<button type="button" class="close" aria-label="Close" onclick="removeQ(this)">'+
                    '<span aria-hidden="true">&times;</span>'+
                    '</button></td></tr>');
                $(".Qtable").append($newrow);
                json.content.push({"Q": "Q"+Qnum, "time": "none", "type": "separate"});
                photojson.push({"photodata" : ""});
            }

            function removeQ(removeelement){
                if(Qnum>1){
                    $(removeelement).closest("tr").remove();
                    var removevalue = $(removeelement).closest("tr").find("th").text();
                    json.content.splice((removevalue-1),1);
                    photojson.splice((removevalue-1),1);
                    Qnum--;
                    
                    var i;
                    for (i = 0; i<Qnum; i++){
                        $("tr th:eq("+i+")").text(i+1);
                    }
                }
            }

            function changecurrentQ(changeelement){
                $(currentelement).closest("tr").removeClass("table-primary");
                var changevalue = $(changeelement).closest("tr").find("th").text();
                currentQ = changevalue;
                currentelement = changeelement;
                $(changeelement).closest("tr").addClass("table-primary");
                $("#question_name").val($(changeelement).find("label").text());
                $("#time_selector").val(json.content[currentQ-1].time);
                $("#typecheckbox").find("#"+json.content[currentQ-1].type).prop("checked",true);
                $(".gametype").not("#"+json.content[currentQ-1].type).prop('checked',false);
                if(photojson[currentQ-1].photodata!=""){
                    $("#defaultimage").css("display","none");
                    $("#imagepreview").css("display","block");
                    $("#imagepreview").attr("src", photojson[currentQ-1].photodata);
                }else{
                    $("#defaultimage").css("display","block");
                    $("#imagepreview").css("display","none");
                    $("#imagepreview").attr("src", "");
                }
            }

            function uploadimage(element){
                var file = element.files[0];

                if(file){
                    var reader = new FileReader();

                    $("#defaultimage").css("display","none");
                    $("#imagepreview").css("display","block");

                    reader.addEventListener("load", function(){
                        $("#imagepreview").attr("src", this.result);
                        photojson[currentQ-1].photodata = this.result;
                    });
                    reader.readAsDataURL(file);
                }else{
                    $("#defaultimage").css("display","block");
                    $("#imagepreview").css("display","none");
                    $("#imagepreview").attr("src", "");
                    photojson[currentQ-1].photodata = "";
                }
            }

            function finish(){
                if(json.title!=""){
                    $(window).unbind('beforeunload');
                    jsonstring = JSON.stringify(json, null, '\t');
                    console.log(jsonstring);
                    var request = $.ajax({
                        type : "POST",
                        url : "php/creategame.php",
                        data : {
                            title : json.title,
                            jsondata : jsonstring,
                            photodata : photojson
                        },

                        success : function(data){
                            console.log(data);
                            document.location.href = "index.php";
                        },
                        error : function(jqXHR, textStatus, errorThrown){
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        }
                    });
                }else{
                    alert("標題是空白的!");
                }
            }

            $(window).bind('beforeunload',function(){
                return "你確定要離開?還沒結束呢!";
            });

            $(document).ready(function(){
                $("#question_name").on("keyup", function(){
                    var keyin_value = $(this).val();
                    $(".Qchoice:eq("+(currentQ-1)+")").text(keyin_value);
                    json.content[currentQ-1].Q = keyin_value;
                });

                $("#MainTitle").on("keyup", function(){
                    var keyin_value = $(this).val();
                    json['title'] = keyin_value;
                });

                $("#time_selector").on("change",function(){
                    var keyin_value = $(this).val();
                    json.content[currentQ-1].time = keyin_value;
                });

                $(".gametype").on("change",function(){
                    $(".gametype").not(this).prop('checked',false);
                    var keyin_value = $(this).val();
                    json.content[currentQ-1].type = keyin_value;
                });
            });
            
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark justify-content-center" >
            <div class="navbar-brand d-flex w-50 mr-auto">
                <a href="index.php"><img src="img/logo.png" width="180"></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="navbar-item">
                        <input type="text" id="MainTitle" class="form-control" placeholder="Enter A Title"> 
                    </li>
                </ul>
                
                <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <a href="javascript:void(0)" onclick="finish()" class="mr-sm-2"><img src="img/finish.jpg" width="98"></a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="my-2 my-sm-0"><img src="img/exit.jpg" width="98"></a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="container custom-container-width">
            <div class="row">
                <div class="col-3" style="background-color:white;height:650px;overflow:auto" >
                    
                    <table class="table table-hover Qtable">
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td onclick="changecurrentQ(this)">
                                    <label class="Qchoice">NEW</label>
                                    <button type="button" class="close" aria-label="Close" onclick="removeQ(this)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td onclick="changecurrentQ(this)">
                                    <label class="Qchoice">NEW</label>
                                    <button type="button" class="close" aria-label="Close" onclick="removeQ(this)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>        
                    <div style="text-align:center;">
                        <button class="addnewQbutton" onclick="addnewQ()" style="font-family:Amatic">
                            Add New Question
                        </button>  
                    </div> 
    
                </div>

                <div class="col-9">
                    <div style="text-align:center;">
                        <input type="text" class="inputtextfield" id="question_name" name="question_name" placeholder="Click to start typing your question">
                    </div>
                    <div class="row">
                        <div class="col-3" style="height:100px">
                            <label>Time 時間</label>
                            <select class="custom-select" id="time_selector">
                                <option value="none">None 沒有</option>
                                <option value="10">10s</option>
                                <option value="15">15s</option>
                                <option value="20">20s</option>
                                <option value="30">30s</option>
                                <option value="60">1min</option>
                            </select>
                            <br><br>

                            <div id="typecheckbox">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" value="separate" class="gametype custom-control-input" id="separate">
                                    <label class="custom-control-label" for="separate">Separate分開</label>
                                </div>

                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" value="cooperation" class="gametype custom-control-input" id="cooperation">
                                    <label class="custom-control-label" for="cooperation">Cooperation合作</label>
                                </div>
                            </div>
                        </div>
                            
                        <div class="col-9">
                            <input id="uploadfile" type="file" onchange="uploadimage(this)" style="display: none">
                            <div class="uploaddiv">
                                <a class="uploadimage" onclick="uploadfile.click()">
                                    <img id="defaultimage" src="img/upload.jpg">
                                    <img id="imagepreview" alt="Image Preview">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>