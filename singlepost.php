<!DOCTYPE html>
<html>
    <head>
        <title>Post Details</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            session_start();
            require_once("navbar.php");
            require_once("classes.php"); 
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 mt-4">
                    <?php
                        $travelPost = new travelPost(); 
                        $res = $travelPost->getTitleMsgByID($_GET['id']); 
                        foreach($res as $row){
                            echo '<h1>'. $row["Title"] . '</h1>';
                            echo '<p>'. $row["Message"] . '</p>';
                        }
                        if(count($res) == 0){
                            header("Location: error.php"); 
                        }
                    
                    ?>
                </div>
                <div class="col-sm-3 mt-5">
                    <form method="post" action="addtofavorites.php">
                    <input type="hidden" name="favType" value="post">
                    <?php
                        if(isset($_SESSION['favPosts'])){
                            if(in_array($_GET['id'], $_SESSION['favPosts'])){
                                echo '<button class="btn btn-outline-primary btn-block fill mt-5" type="submit" name="favorite" value="' . $_GET['id'] . '"><span class="material-symbols-outlined">favorite</span> Saved </button>';
                            }
                            else{
                                echo '<button class="btn btn-outline-primary btn-block fill mt-5" type="submit" name="favorite" value="' . $_GET['id'] . '"><span class="material-symbols-outlined">favorite</span> Add to Favorites list</button>';
                            }
                        }
                        else{
                            echo '<button class="btn btn-outline-primary btn-block fill mt-5" type="submit" name="favorite" value="' . $_GET['id'] . '"><span class="material-symbols-outlined">favorite</span> Add to Favorites list</button>';
                        }
                        
                       
                    ?>
                    </form>
                    <div class="card mt-4">
                        <div class="card-header">
                            Post Details
                        </div>
                        <ul class="list-group list-group-flush">
                        <?php
                            $travelUser = new travelUser();
                            $res = $travelUser->getUserFromPost($_GET['id']);
                            foreach($res as $row){
                                $uid = $row['UID'];
                                echo '<li class="list-group-item"><strong>Date:</strong><span class="float-right">'  . date('M-d-Y', strtotime($row["PostTime"])) . '</span></li>'; 
                                echo '<li class="list-group-item"><strong>Posted By:</strong><span class="float-right">' . $row["FirstName"] . " " . $row["LastName"] . " " . '<a href="user.php?id=' .$row['UID'] . '">' . $row['Email'] . "</a>" . '</span></li>';
                            }
                        ?>
                        </ul>
                    </div>
                </div>    
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4>Travel images for this post</h4>
                </div>
            </div>
            <div class="row">
                <?php
                    $travelImage = new travelImage(); 
                    $res = $travelImage->getImagesforPost($_GET['id']);
                    foreach($res as $row){
                        echo '<div class="col-sm-3">';
                        echo '<div class="card d-flex align-items-center">';
                        echo '<div class="card-img-container p-1 ratio ratio-4x3">';
                        echo '<a href="singleimage.php?id='. $row["ImageID"] . '">';
                        echo '<img class="card-img-top" src="travel-images/thumb/' . $row["Path"] .'"></div></a>';
                        echo '<a class="card-text" href="singleimage.php?id='. $row["ImageID"] . '">' . $row["Title"] . '</a>';
                        echo '<div class="d-flex m-3">';
                        echo '<a class="btn btn-primary btn-sm mx-1" href="singleimage.php?id=' . $row["ImageID"] . '"><span class="material-symbols-outlined">info</span>view</a>';
                        echo '<form method="post" action="addtofavorites.php">';
                        echo '<input type="hidden" name="favType" value="image">'; 
                        if(isset($_SESSION['favImages'])){
                            if(in_array($row['ImageID'], $_SESSION['favImages'])){
                                echo '<button class="btn btn-success btn-sm mx-1" type="submit" name="favorite" value="' . $row['ImageID'] . '"><span class="material-symbols-outlined">favorite</span>Saved</button>';
                            }
                            else{
                                echo '<button class="btn btn-success btn-sm mx-1" type="submit" name="favorite" value="' . $row['ImageID'] . '"><span class="material-symbols-outlined">favorite</span>Favorite</button>';
                            }
                        }
                        else{
                            echo '<button class="btn btn-success btn-sm mx-1" type="submit" name="favorite" value="' . $row['ImageID'] . '"><span class="material-symbols-outlined">favorite</span>Favorite</button>';
                        }
                        echo '</form>'; 
                        echo '</div></div></div>';
                    }
                ?>  
            </div>     
                    
            <div class="row">
                <div class="col-sm-6">
                    <h4>Other Posts by User</h4>
                    <?php
                        require_once("boxes.php"); 
                        otherPostsbyUser($uid, $_GET['id']); 
                    ?>
                </div>
            </div>             
        </div>
    </body>
</html>