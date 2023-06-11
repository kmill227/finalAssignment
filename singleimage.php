<!DOCTYPE html> 
<html>
    <head>
        <title>Images</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="style.css"> 
    </head>
    <body>
        <?php
            require_once("navbar.php");
            require_once("classes.php"); 
            require_once('boxes.php'); 
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 mt-5">
                    <?php
                        $travelImage = new travelImage(); 
                        $res = $travelImage->getImageandUser($_GET['id']); 
                        foreach($res as $row){
                            $modalTitle = $row["Title"]; 
                            $modalBy = $row["FirstName"] . " " . $row["LastName"]; 
                            echo '<h1>' . $row["Title"] . '</h1>'; 
                            echo '<h5>By ' . $row["FirstName"] . " " . $row["LastName"] . '</h5>';
                        }
                        if(count($res) == 0){
                            header("Location: error.php"); 
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php
                        $res = $travelImage->getImagebyID($_GET['id']); 
                        foreach($res as $row){
                            $modalPath = $row["Path"]; 
                            echo '<div class="img-container d-inline-block p-1" data-toggle="modal" data-target="#imageModal">'; 
                            echo '<img src="travel-images/medium/' . $row["Path"] . '">'; 
                            echo '</div>';
                        }
                        if(isset($_SESSION["userID"]) || isset($_COOKIE['userID'])){
                            echo '<div class="mt-3">';
                            echo  '<form action="submitreview.php" method="post">';
                            echo '<input type="hidden" name="imageID" value="'. $_GET['id'] .'"> '; 
                            echo '<label for="rating">Rating: </label>';
                            echo '<input type="number" name="rating" id="rating" min="1" max="5" required>';
                            echo '<label for="review">Review:</label>';
                            echo '<input type="text" name="review" id="review">';
                            echo  '<input type="submit" value="submit" class="btn btn-primary">';
                            echo  '</form>';
                            echo '</div>'; 
                        }
                ?>

                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel"><?php echo $modalTitle . " By " . $modalBy; ?> </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="travel-images/large/<?php echo $modalPath ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Other Images From This Country</h3>
                            <?php 
                            require_once('boxes.php'); 
                            countryImages($_GET['id']); 
                            ?>
                        </div>
                        </div>
                    <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Other Images For This Post</h3>
                        <?php 
                        postImages($_GET['id']);            
                        ?>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                <form method="post" action="addtofavorites.php">
                <input type="hidden" name="favType" value="image">
                <?php
                    if(isset($_SESSION['favImages'])){
                        if(in_array($_GET['id'], $_SESSION['favImages'])){
                            echo '<button class="btn btn-outline-secondary text-primary mb-3" type="submit" name="favorite" value="' . $_GET['id'] . '"><span class="material-symbols-outlined">collections_bookmark</span>Added to Favorites</button>';
                        }
                        else{
                            echo '<button class="btn btn-outline-secondary text-primary mb-3" type="submit" name="favorite" value="' . $_GET['id'] . '"><span class="material-symbols-outlined">collections_bookmark</span>Add to Favorites</button>';
                        }
                    }
                    else{
                        echo '<button class="btn btn-outline-secondary text-primary mb-3" type="submit" name="favorite" value="' . $_GET['id'] . '"><span class="material-symbols-outlined">collections_bookmark</span>Add to Favorites</button>';
                    }
                ?>
                </form>
                    <div class="card mb-2">
                        <div class="card-header bg-info text-primary">
                            Rating
                        </div>
                        <div class="card-body border border-info pb-4">
                            <?php
                                $res = $travelImage->avgRating($_GET['id']); 
                                foreach($res as $row){
                                    echo '<span class="avg">' . $row["average"] . '</span>';
                                    echo '<span class="rate"> [' . $row["rating"] . ' votes]</span>';
                                }
                            ?> 
                            
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header">Reviews</div>
                        <div class="card-body">
                        <?php 
                            $res = $travelImage->getRatingsForImage($_GET['id']); 
                            foreach($res as $row){
                                echo '<h5>' . $row['Rating'] . '/5 - ' .$row['FirstName'] . ' ' . $row['LastName'] . ' on ' . $row['ReviewTime'] . '</h5>';
                                echo '<p>' . $row['Review'] . '</p>'; 
                            }
                        ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Image Details
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php
                                    $city = new cities(); 
                                    $res = $city->getCityForImage($_GET['id']); 
                                    foreach($res as $row){
                                        echo '<li class="list-group-item"><strong>Country:</strong><span class="float-right">' . $row["countryname"] . '</span></li>';
                                        echo '<li class="list-group-item"><strong>City:</strong><span class="float-right">' . $row["asciiname"] . '</span></li>';
                                        $long = $row['Longitude']; 
                                        $lat = $row['Latitude']; 
                                    }  
                                ?>
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Google Maps
                                            </button>
                                        </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <iframe src="https://maps.google.com/maps?q=<?php echo $lat; ?> , <?php echo $long; ?> &z=15&output=embed"  frameborder="0" style="width:100%; height:100%; border:0"></iframe>
                                        </div>
                                        </div>
                                    </div>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        




        </body>
</html>