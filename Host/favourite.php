<!DOCTYPE html>
<html lang="en" >
    <head>
        <title>favourite</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/favourite.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    </head>


    <body>
        
        <?php include_once 'php/navbar.php'; ?>
        

        <div class="container custom-container-width">
            <div class="row">
                <div class="col-3" style="background-color:white;height:650px;overflow:auto" >
                      <table class="table table-borderless">
                          <tbody>
                            <tr><th scope="row"></th></tr>
                            <tr><th scope="row"></th></tr>
                            <tr><th scope="row"></th></tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/user.png" width="55"></th>                           
                                 <td><a href="dttention.php"><span class="text">My D.ttention</span></a></td>
                            </tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/star.png" width="55"></th>
                              <td><a href="favourite.php"><span class="text">Favourite</span></a></td>
                            </tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/share.png" width="55"></th>
                              <td><a href="share.php"><span class="text">Share to me</span></a></td>
                            </tr>
                            <tr><th scope="row"></th></tr>
                            <tr>
                              <th scope="row"><img src="img/edit.png" width="55"></th>
                              <td><a href="draft.php"><span class="text">My draft</span></a></td>
                            </tr>
                          </tbody>
                      </table>
                </div>
              
                <div class="col-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group" style="text-align:center;margin-top:60px;margin-bottom:30px;">
                                <input type="text" class="inputtextfield" id="search" name="search" placeholder="&emsp;Search">
                                <a href="#" ><img src="img/search.png"  width="45" ></a> 
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <span class="text">Favourite</span>
                                </div>
                                <div class="col-6">
                                    <div class="sort" style="text-align:center;margin-bottom:30px;">
                                        <span class="text2">Sort by:</span>
                                        <select class="custom-select" id="time_selector">
                                            <option value="none">Most Resent</option>
                                            <option value="Oldest">Oldest</option>
                                            <option value="Name(a-z)">Name(a-z)</option>
                                            <option value="Name(z-a)">Name(z-a)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1"></div>
                                    <div class="col-5">
                                        <span class="text3">D.ttentions (0)</span>
                                    </div>
                                    <div class="col-6">
                                    </div>
                            </div>
 
                            <div class="row">
                                <div class="col-12"> 
                                    <div style="text-align:center;margin-top:100px;">
                                        <span class="text4">Keep track of your favorite kahoots!</span>       
                                    </div>                             
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