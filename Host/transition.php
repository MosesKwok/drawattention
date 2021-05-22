<html>
    <head>
        <title>Loading</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/transition.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <div class="container custom-container-width">
            <div class="mouse original"></div>
                <div class="row">
                    <div class="col-4" >

                    </div>
                    <div class="col-4">
                        <div id="draw">
                            <img src="img/draw.gif" >
                                <script>
                                    setTimeout(function(){
                                    document.getElementById("draw").style.visibility = "hidden"; 
                                    window.location.replace('game.php')
                                    }, 2000);
                                </script>
                        </div>
                    </div>
                    <div class="col-4">
                    
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>