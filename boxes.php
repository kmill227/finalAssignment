<?php
    require_once("classes.php");
function otherPostsbyUser($userID, $postID){
    $travelPost = new travelPost(); 
    $res = $travelPost->getPostByUserExclCurrent($userID, $postID); 
    if(count($res) > 0){
        echo '<div class="card-deck">';
        foreach($res as $row){
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<a href="singlepost.php?id=' . $row['postid'] . '"><h5 class="card-title">'. $row['title'] .'</h5></a>';
            echo '<p class="card-text">'. $row['message'] .'</p>';
            echo '</div>';
            echo '<div class="card-footer">';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
    else{
        echo 'User has no other posts';
    }
}


    function imagesByUser($userID){
        $travelImage = new travelImage(); 
        $res = $travelImage->getImagesforUser($userID); 

        foreach($res as $row){
            echo '<div class="card">';
            echo '<a href="singleimage.php?id=' .$row['ImageID'] .'">' . '<img class="card-img-top" src="travel-images/small/'. $row['Path'] . '"></a>'; 
            echo '</div>';
        }

    }
    

    function countryImages($imageID){
        $city = new cities(); 
        $res = $city->getCityForImage($imageID); 
        foreach($res as $row){
            $cc = $row['ISO'];
            $travelImage = new travelImage(); 
            $res2 = $travelImage->getImagesforCountry($cc, 'asc'); 
            echo '<div class="row">';
            foreach($res2 as $row){
                echo '<div class="col-sm-3">';
                echo '<div class="card">';
                echo '<div class="card-body p-0">';
                echo '<a href=singleimage.php?id=' . $row['ImageID'] . '"><img src="travel-images/thumb/'. $row['Path'] . '" class="card-img-top"></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
    

    function postImages($imageID){
        $travelPost = new travelPost(); 
        $res = $travelPost->getPostFromImage($imageID); 
        foreach($res as $row){
            $travelImage = new travelImage(); 
            $res2 = $travelImage->getImagesforPost($row['PostID']); 
            echo '<div class="row">';
            foreach($res2 as $row){
                echo '<div class="col-sm-3">';
                echo '<div class="card">';
                echo '<div class="card-body p-0">';
                echo '<a href=singleimage.php?id=' . $row['ImageID'] . '"><img src="travel-images/thumb/' . $row['Path'] . '" class="card-img-top"></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
    

    function newlyAddedImages(){
        $travelImage = new travelImage(); 
        $res = $travelImage->getLatest(); 
        foreach($res as $row){
            echo '<img src="travel-images/small/' . $row['Path'] . '">'; 
        }
    }
    function highestRatedImages(){
        $travelImage = new travelImage(); 
        $res = $travelImage->highestRated(); 
        foreach($res as $row){
            echo '<img src="travel-images/small/' . $row['Path'] . '">'; 
        }
    }
    function recentReviews(){
        $travelImage = new travelImage(); 
        $res = $travelImage->getRecentReviews();
        foreach($res as $row){
            echo '<a href="singleimage.php?id=' . $row['ImageID'] . '">' . $row['review'] . '</a></br>';
        }
    }
?>