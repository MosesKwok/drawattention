<?php
    $contentid = $_GET['contentid'];
    $img = $_GET['img'];
    readfile("../../../drawattentionphoto/recordphoto/" . $contentid . "/" . $img . ".png");
?>