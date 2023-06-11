<!DOCTYPE html>
<html>
    <head>
        <title>Image List</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php 
        require_once("navbar.php");
        require_once("classes.php"); 
    ?>
    <div class="container-fluid">
        <div class="container pl-4 pt-5 pr-4 ml-0 border-bottom text-left">
            <h1 class="text-left">Images List</h1>
        </div>
        <div class="container align-left ml-0 p-0 pt-4">
            <form method="get" action="imagelist.php">
                <div class="form-group ml-4">
                    <label for="type">Search By:</label>
                    <select id="type" name="type" class="form-control">
                        <option value=""></option>
                        <option value="country">Country</option>
                        <option value="continent">Continent</option>
                    </select>
                </div>
                <div class="form-group d-none ml-4" id="countryDiv">
                    <label for="country">Country:</label>
                    <select id="country" name="country" class="form-control">
                        <option value=""></option>
                        <?php
                            $country = new countries(); 
                            $res = $country->getUniqueCountries(); 
                            foreach($res as $row){
                                echo '<option value="'. $row['CountryCodeISO'] . '">' . $row['CountryName'] . '</option>';
                            }
                        ?>
                        
                    </select>
                </div>
                <div class="form-group d-none ml-4" id="continentDiv">
                    <label for="continent">Continent:</label>
                    <select id="continent" name="continent" class="form-control">
                        <option value=""></option>
                        <?php
                            $continent = new continents(); 
                            $res = $continent->getAllNames(); 
                            foreach($res as $row){
                                echo '<option value="' . $row['ContinentCode'] . '">' . $row['ContinentName'] . '</option>'; 
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary ml-4">Search</button>
            </form>

        <script>
            const mainDrop = document.getElementById("type");
            const countryDrop = document.getElementById("countryDiv"); 
            const continentDrop = document.getElementById("continentDiv"); 
            mainDrop.addEventListener("change", function() {
                // code to execute when dropdown value changes
                if(mainDrop.value == 'country'){
                    countryDrop.classList.remove('d-none'); 
                    continentDrop.classList.add('d-none'); 
                    continentDrop.value = ""; 
                }
                else if (mainDrop.value == 'continent'){
                    continentDrop.classList.remove('d-none'); 
                    countryDrop.classList.add('d-none'); 
                    countryDrop.value = "";
                }
                else{
                    continentDrop.classList.add('d-none'); 
                    countryDrop.classList.add('d-none'); 
                    continentDrop.value = ""; 
                    countryDrop.value = ""; 
                }
            });
        </script>

        <ul>
            <?php
                $travelImage = new travelImage(); 
                $res = $travelImage->listImages(); 
                if(isset($_GET['type']) && $_GET['type'] != ""){
                    if($_GET['continent'] != ""){
                        $res = $travelImage->getImagesforContinent($_GET['continent']); 
                    }
                    elseif($_GET['country'] != ""){
                        $res = $travelImage->getImagesforCountry($_GET['country'], 'asc'); 
                    }
                }

                foreach($res as $row){
                    echo '<li class="mb-3">';
                    echo '<div class="row">';
                    echo '<div class="col-2 mt-1 ml-0 pl-0">';
                    echo '<a href="singleimage.php?id='. $row["ImageID"] . '">';
                    echo '<img src="travel-images/thumb/' . $row['Path'] . '" class="img-fluid"></a>';
                    echo '</div>';
                    echo '<div class="col-4 mt-1 ml-0 pl-0">';
                    echo '<a href="singleimage.php?id='. $row["ImageID"] . '">';
                    echo '<h4 class="mt-1">' . $row["Title"] . '</h4></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }
            ?> 
        </ul>



            </div>
        </div>
    </body>
</html>