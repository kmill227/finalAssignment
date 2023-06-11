<!DOCTYPE html>
<head>
    <title>Favorites</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
        <?php
            session_start(); 
            require_once("navbar.php"); 
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h1>Favorite Images</h1>
                    <ul class="list-unstyled">
                    <?php
                        if(isset($_SESSION['favImages']) && count($_SESSION['favImages']) > 0){
                            $travelImage = new travelImage(); 
                            foreach($_SESSION['favImages'] as $imageId){
                                $res = $travelImage->getImagebyID($imageId); 
                                foreach($res as $row){
                                    echo '<li class="media mb-3"><a href="singleimage.php?id=' . $imageId . '">' . '<img class="mr-3" src="travel-images/thumb/' . $row['Path'] . '" alt="' . $row['Title'] . '"><div class="media-body"><a href="singleimage.php?id=' . $imageId . '">' . $row['Title'] . '</a><form method="post" action="addtofavorites.php"><input type="hidden" name="favType" value="image"><button class="btn btn-danger btn-sm ml-0" type="submit" name="favorite" value="' . $imageId . '"><span class="material-symbols-outlined">close</span>Remove</button></form></div></li>';  
                                }
                            }
                        }
                        else{
                            echo '<p>No Favorite Images</p>'; 
                        }
                    ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h1>Favorite Posts</h1>
                    <ul class="list-unstyled">
                        <?php
                            if(isset($_SESSION['favPosts']) && count($_SESSION['favPosts']) > 0){
                                foreach($_SESSION['favPosts'] as $postId){
                                    $travelPost = new travelPost(); 
                                    $res = $travelPost->getTitleMsgByID($postId); 
                                    foreach($res as $row){
                                        echo '<li><div class="d-flex align-items-center"><a href="singlepost.php?id=' . $postId . '">' . $row['Title'] . '</a><form method="post" action="addtofavorites.php"><input type="hidden" name="favType" value="post"><button class="btn btn-danger btn-sm mx-1" type="submit" name="favorite" value="' . $postId . '"><span class="material-symbols-outlined">close</span>Remove</button></form></div></li>';                                    
                                    }
                                }
                            }
                            else{
                                echo '<p>No Favorite Posts</p>'; 
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
</html>