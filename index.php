<!DOCTYPE HTML> 
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>
        
        <?php 
            require_once("navbar.php");
            require_once("boxes.php"); 
         ?>
        <div class="container-fluid ml-2 pl-0">
            <div class="row">
                <div class="col-md-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner mt-5">
                            <?php
                                $travelImage = new travelImage(); 
                                $res = $travelImage->carouselImages(); 
                                $i = 1; 
                                foreach($res as $row){
                                    $active = ($i == 1) ? ' active' : '';
                                    echo('<div class="carousel-item' . $active . '">');
                                    echo('<img class="d-block w-100" src="travel-images/large/' . $row['Path'] . '">'); 
                                    echo('<div class="carousel-caption d-none d-md-block">'); 
                                    echo('<h4>'. $row['Title'] . '</h4>'); 
                                    echo('<h5>'. $row['CountryName'] . '</h5>'); 
                                    echo('</div>');  
                                    echo('</div>'); 
                                    $i++; 
                                }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>Recently Added</h2>
                    <?php newlyAddedImages(); ?>
                </div>

                <div class="row ml-2">
                <div class="col-md-6">
                    <h2>Highest Rated</h2>
                    <?php highestRatedImages(); ?>
                </div>
                <div class="col-md-6 mt-2">
                    <h2>Recent Reviews</h2>
                    <?php
                        recentReviews(); 
                    ?>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>