<?php
    require_once 'php/db.php';
    
    if(!isset($_SESSION['is_login']) || !$_SESSION['is_login']){
        header("Location: login.php");
    }

    $userid = $_SESSION["login_id"];
    $username = $_SESSION['login_username'];
    $noresult = false;
    
    $sql = "SELECT * FROM ContentList WHERE userid='$userid' AND username='$username' ORDER BY last_edit DESC";
    $query = mysqli_query($_SESSION['link'], $sql);
    $totalresult = mysqli_num_rows($query);
    if($totalresult<1){
        $noresult = true;
    }else{
        $listarray = array();
        $i = 0;
        while ($result = mysqli_fetch_array($query)) {
            $listarray[$i] = $result;
            $i++;
        }
    }
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">
    <head>
        <title>dttention</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/dttention.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <script>
            function sortTable(n, dir) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("gamelist");
                switching = true;
                
                while (switching) {
                    switching = false;
                    rows = table.rows;
                
                    for (i=1; i<(rows.length-1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("td")[n];
                        y = rows[i + 1].getElementsByTagName("td")[n];
                    
                        if(dir=="asc"){
                            if(x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                                shouldSwitch = true;
                                break;
                            }
                        }else if(dir=="des"){
                            if(x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()){
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    if(shouldSwitch){
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount ++;
                    }else{
                        if(switchcount == 0 && dir == "asc"){
                            dir = "des";
                            switching = true;
                        }
                    }
                }

                for (i = 0; i<rows.length; i++){
                    $("#gamelist tbody th:eq("+i+")").text(i+1);
                }
            }

            $(document).ready(function(){
                $("#search").on("keyup", function() {
                    var searchvalue = $(this).val().toLowerCase();
                    $(".tablediv tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(searchvalue) > -1);
                    });
                });
                
                $("#sort_selector").on("change",function(){
                    var keyin_value = $(this).val();
                    if(keyin_value=="timedes"){
                        sortTable(4,"des");
                    }else if(keyin_value=="timeasc"){
                        sortTable(4,"asc");
                    }else if(keyin_value=="nameasc"){
                        sortTable(0,"asc");
                    }else if(keyin_value=="namedes"){
                        sortTable(0,"des");
                    }
                });

                $(".playbutton").on("click",function(){
                    var contentid = $(this).closest("tr").attr('data-id');
                    document.location.href = "http://test.moseskwok.com/host.php?contentid=" + contentid + "&userid=" + "<?php echo $userid; ?>" + "&username=" + "<?php echo $username; ?>";
                });

                $(".editbutton").on("click",function(){
                    var contentid = $(this).closest("tr").attr('data-id');
                    document.location.href = "edit.php?id=" + contentid;
                });

                $(".deletebutton").on("click",function(){
                    var contentid = $(this).closest("tr").attr('data-id');
                    var contenttitle = $(this).closest("tr").find("td").first().text();

                    var deleteconfirm = confirm("你確定要把這個"+contenttitle+"刪掉嗎");
                    if(deleteconfirm){
                        var request = $.ajax({
                            type : "POST",
                            url : "php/deletegame.php",
                            data : {
                                id : contentid
                            },

                            success : function(data){
                                console.log(data);
                                document.location.href = "dttention.php";
                            },
                            error : function(jqXHR, textStatus, errorThrown){
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
        
        <?php include_once 'php/navbar.php'; ?>
        
        <div class="container custom-container-width">
            <div class="row">
                <div class="col-3" style="background-color:white;height:650px;" >
                      <table class="table table-borderless">
                          <tbody>
                            <tr><th scope="row"></th></tr>
                            <tr><th scope="row"></th></tr>
                            <tr><th scope="row"></th></tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/user.png" width="40"></th>                           
                                 <td><a href="dttention.php"><span class="text">My D.ttention</span></a></td>
                            </tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/star.png" width="40"></th>
                              <td><a href="favourite.php"><span class="text">Favourite</span></a></td>
                            </tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/share.png" width="40"></th>
                              <td><a href="share.php"><span class="text">Share to me</span></a></td>
                            </tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/edit.png" width="40"></th>
                              <td><a href="draft.php"><span class="text">My draft</span></a></td>
                            </tr>
                          </tbody>
                      </table>
                </div>
              
                <div class="col-9">
                    <div class="row">
                        <div class="col-12" style="overflow-y: scroll;height: 100%;">
                            <div class="form-group" style="text-align:center;margin-top:60px;margin-bottom:30px;">
                                <input type="text" class="inputtextfield" id="search" name="search" placeholder="&emsp;Search">
                                <a href="#" ><img src="img/search.png"  width="40" ></a> 
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <span class="text">My D.ttentions</span>
                                </div>
                                <div class="col-6">
                                    <div class="sort" style="text-align:center;margin-bottom:30px;">
                                        <span class="text2">Sort by:</span>
                                        <select class="custom-select" id="sort_selector">
                                            <option value="timedes">Most Recent</option>
                                            <option value="timeasc">Oldest</option>
                                            <option value="nameasc">Name(a-z)</option>
                                            <option value="namedes">Name(z-a)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <span class="text3">D.ttentions (<?php echo $totalresult; ?>)</span>
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
 
                            <div class="row">
                                <div class="col-12">                         
                                    <div class="emptydiv" <?php if(!$noresult){echo 'style="display: none"';} ?>>
                                        <a href="create.php" button class="addnew">
                                          + add new
                                        </button></a>
                                    </div>
                                    <div class="tablediv" <?php if($noresult){echo 'style="display: none"';} ?>>
                                        <table class="table table-hover" id="gamelist">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Play</th>
                                                    <th scope="col">Edit</th>
                                                    <th scope="col">Delete</th>
                                                    <th scope="col">Last Edited</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    for($i=0; $i<$totalresult; $i++){
                                                        echo '<tr data-id="'.$listarray[$i]['contentid'].'">';
                                                        echo '<th scope="row">'.($i+1).'</th>';
                                                        echo '<td>'.$listarray[$i]['content_title'].'</td>';
                                                        echo '<td><button class="btn btn-success playbutton">Play</button></td>';
                                                        echo '<td><button class="btn btn-primary editbutton">Edit</button></td>';
                                                        echo '<td><button class="btn btn-danger deletebutton">Delete</button></td>';
                                                        echo '<td>'.$listarray[$i]['last_edit'].'</td>';
                                                        echo '</tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </body>
</html>