<!DOCTYPE html>
<html>
    <head>
        <title>Post List</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
            require_once("navbar.php");
            require_once("classes.php"); 
        ?>
        <div class="container-fluid">
            <div class="container pl-4 pt-5 pr-4 ml-0 border-bottom text-left">
                <h1 class="text-left">Posts List (Part 1)</h1>
            </div>
            <div class="container align-left ml-0 p-0 pt-4">
            <ul class="text-left">
                <?php
                    $travelPost = new travelPost(); 
                    $res = $travelPost->listPosts(); 
                    foreach($res as $row){
                        echo '<li><a href="singlepost.php?id='. $row["PostID"] . '">' . $row["Title"] . '</a></li>';
                    }
                ?> 
            </ul>
            </div>
        </div>
    </body>
</html>