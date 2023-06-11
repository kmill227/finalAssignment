<!DOCTYPE html>
<html>
<head>
    <title>Location</title>
</head>
<body>
    <?php
        require_once("navbar.php"); 
        require_once("classes.php"); 

        if(isset($_GET['country'])){
            $country = new countries(); 
            $res = $country->getCountryDetails($_GET['country']); 
            foreach($res as $row){
                $countryName = $row['CountryName'];
                echo '<div class="card">';
                echo '<div class="card-header">' . $row['CountryName'] . '</div>';
                echo '<div class="card-body">';
                echo '<p class="card-text">';
                echo '<strong>Capital:</strong> ' . $row['Capital'] . '<br>';
                echo '<strong>Area:</strong> ' . $row['Area'] . '<br>';
                echo '<strong>Population:</strong> ' . $row['Population'] . '<br>';
                echo '<strong>Currency:</strong> ' . $row['CurrencyCode'] . '<br>';
                echo '<strong>Description:</strong> ' . $row['CountryDescription'] . '<br>';
                echo '<strong>Flag: </strong><img src="https://flagcdn.com/16x12/' . strtolower($row['ISO']) . '.png" srcset="https://flagcdn.com/32x24/' . strtolower($row['ISO']) . '.png 2x, https://flagcdn.com/48x36/' . strtolower($row['ISO']) . '.png 3x" width="16" height="12" alt="' . $row['CountryName'] . '">';
                echo '</p>';

                $travelImage = new travelImage(); 
                $res = $travelImage->getImagesforCountry($_GET['country'], 'asc'); 
                foreach($res as $row){
                    echo '<img src="travel-images/small/' . $row['Path'] . '" class="img-fluid">'; 
                }

                echo '</div></div>';
            }
        }
    ?>
    </div>
</div>
    <?php
        if(isset($_GET['city']) ){
            $city = new cities();
            $res = $city->getCityByID($_GET['city']); 
            foreach($res as $row){
                $lat = $row['latitude']; 
                $long = $row['longitude']; 
                echo '<div class="card">';
                echo '<div class="card-header">';
                echo $row['asciiname'] . ', ' . $countryName;
                echo '</div>';
                echo '<div class="card-body">';
                echo '<p class="card-text">';
                echo '<strong>Population:</strong> ' . $row['population'] . '<br>';
                echo '<strong>Elevation:</strong> ' . $row['elevation'] . '<br>';
                echo '</p>';
                $travelImage = new travelImage(); 
                $res = $travelImage->getImagesforCity($_GET['city'], 'asc'); 
                foreach($res as $row){
                    echo '<img src="travel-images/small/' . $row['Path'] . '" class="img-fluid mt-3">'; 
                }
            } 
        }
    ?>
        <iframe src="https://maps.google.com/maps?q=<?php echo $lat; ?> , <?php echo $long; ?> &z=15&output=embed"  frameborder="0" style="width:33%; height:75%; border:0" class="float-right"></iframe>
    </div>
</div>
</body>
</html>
