<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    </head>
    <body>
        <?php 
            session_start(); 
            require_once("navbar.php"); 
            require_once("classes.php"); 
        ?>
        <div class="container-fluid">
            <div class="container pl-4 pt-5 pr-4 ml-0 border-bottom text-left">
                <h1 class="text-left">Search Results</h1>
            </div>
            <div class="jumbotron">
                <form method="GET" action="search.php">
                    <div class="formDiv">
                        <input type="radio" value="images" id="images" name="searchType" onClick="showSearchBar('imageSearch')" >
                        <label for="imagetitle">Filter Images </label>
                        <input type="text" id="imageSearch" class="searchBar" name="imagetitle">
                        <select id="type" name="type" class="d-none">
                            <option value="" selected></option>
                            <option value="country">Country</option>
                            <option value="city">City</option>
                        </select>
                    <select id="country" name="country" class="d-none">
                        <option value=""></option>
                        <?php
                            $country = new countries(); 
                            $res = $country->getUniqueCountries(); 
                            foreach($res as $row){
                                echo '<option value="'. $row['CountryCodeISO'] . '">' . $row['CountryName'] . '</option>';
                            }
                        ?>
                        
                    </select>
                    <select id="city" name="city" class="d-none">
                        <option value=""></option>
                        <?php
                            $city = new cities(); 
                            $res = $city->getUniqueCities(); 
                            foreach($res as $row){
                                echo '<option value="' . $row['CityCode'] . '">' . $row['AsciiName'] . '</option>'; 
                            }
                        ?>
                    </select>
                    <script>
                        const mainDrop = document.getElementById("type");
                        const countryDrop = document.getElementById("country"); 
                        const cityDrop = document.getElementById("city"); 
                        mainDrop.addEventListener("change", function() {
                        // code to execute when dropdown value changes
                            if(mainDrop.value == 'country'){
                                countryDrop.classList.remove('d-none'); 
                                cityDrop.classList.add('d-none'); 
                                continentDrop.value = ""; 
                            }
                            else if (mainDrop.value == 'city'){
                                cityDrop.classList.remove('d-none'); 
                                countryDrop.classList.add('d-none'); 
                                countryDrop.value = "";
                            }
                            else{
                                cityDrop.classList.add('d-none'); 
                                countryDrop.classList.add('d-none'); 
                                cityDrop.value = ""; 
                                countryDrop.value = ""; 
                            }
                        });
            </script>
                    </div>
                    <div class="formDiv">
                        <input type="radio" value="posts" id="message" name="searchType" onClick="showSearchBar('postSearch')">
                        <label for="posttitle" >Filter Posts </label>
                        <input type="text" id="postSearch" class="searchBar" name="posttitle">
                    </div>
                    <div class="formDiv">
                        <input type="submit" class="btn btn-primary" value="filter">
                    </div>

                    <script>
                        function showSearchBar(searchBarId) {
                            hideSearchBars();
                            document.getElementById(searchBarId).style.display = "block";

                            // Show or hide dropdowns based on the search type
                            const searchType = document.querySelector('input[name="searchType"]:checked').value;
                            const mainDrop = document.getElementById('type')
                            const countryDropdown = document.getElementById("country");
                            const cityDropdown = document.getElementById("city");

                            if (searchType === 'images') {
                                mainDrop.classList.remove('d-none'); 
                            } else {
                                mainDrop.classList.add('d-none'); 
                                countryDropdown.classList.add('d-none');
                                cityDropdown.classList.add('d-none');
                            }
                        }

                        function hideSearchBars() {
                            document.getElementById("imageSearch").style.display = "none";
                            document.getElementById("postSearch").style.display = "none";
                            document.getElementById("country").classList.add('d-none');
                            document.getElementById("city").classList.add('d-none');
                        }
                    </script>
                </form>
            </div>
            <div class="container-fluid">
                <?php
                    if(isset($_GET['searchType']) && $_GET['searchType'] == 'posts'){
                        if(isset($_GET["posttitle"])){
                            $title = $_GET["posttitle"]; 
                            $travelPost = new travelPost();
                            if(isset($_GET['order']) && $_GET['order'] == 'asc'){
                                $res = $travelPost->getLikeTitle($title, 'asc');
                            }
                            else{
                                $res = $travelPost->getLikeTitle($title, 'desc') ;
                            }
                            foreach($res as $row){
                                echo '<h4><a href="singlePost.php?id=' . $row["PostID"] . '">' . $row["Title"] . '</a></h4>'; 
                                if(isset($_SESSION['favPosts'])){
                                    if(in_array($row['PostID'], $_SESSION['favPosts'])){
                                        echo '<button class="btn btn-success btn-sm mx-1" type="submit" name="favorite" value="' . $row['PostID'] . '"><span class="material-symbols-outlined">favorite</span>Saved</button>';
                                    }
                                    else{
                                        echo '<button class="btn btn-success btn-sm mx-1" type="submit" name="favorite" value="' . $row['PostID'] . '"><span class="material-symbols-outlined">favorite</span>Favorite</button>';
                                    }
                                }
                                else{
                                    echo '<button class="btn btn-success btn-sm mx-1" type="submit" name="favorite" value="' . $row['PostID'] . '"><span class="material-symbols-outlined">favorite</span>Favorite</button>';
                                }
                                echo '<p>' . $row["Message"] . '</p>'; 
                            }
                        }  
                        else{
                            $travelPost = new travelPost(); 
                            $res = $travelPost->listPosts(); 
                            foreach($res as $row){
                                echo '<h4><a href="singlePost.php?id=' . $row["PostID"] . '">' . $row["Title"] . '</a></h4>'; 
                                echo '<p>' . $row["Message"] . '</p>'; 
                            }
                        }
                    }
                    elseif(isset($_GET['searchType']) && $_GET['searchType'] == 'images'){
                        if(isset($_GET['imagetitle']) && $_GET['imagetitle'] != ""){
                            $title = $_GET['imagetitle']; 
                            $travelImage = new travelImage(); 
                            if(isset($_GET['order']) && $_GET['order'] == 'asc'){
                                $res = $travelImage->getLikeTitle($title, 'asc'); 
                            }
                            else{
                                $res = $travelImage->getLikeTitle($title, 'desc'); 
                            }
                            foreach($res as $row){
                                echo '<h4><a href="singleImage.php?id=' . $row["ImageID"] . '">' . $row["Title"] . '<img src="travel-images/thumb/' .$row['Path'] . '"></a></h4>'; 
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
                                echo '<p>' . $row["Description"] . '</p>'; 
                            }
                        }
                        elseif(isset($_GET['country']) && $_GET['country'] != ""){
                            $cc = $_GET['country']; 
                            $travelImage = new travelImage(); 
                            if(isset($_GET['order']) && $_GET['order'] == 'asc'){
                                $res = $travelImage->getImagesforCountry($cc, 'asc'); 
                            }
                            else{
                                $res = $travelImage->getImagesforCountry($cc, 'desc'); 
                            }
                            foreach($res as $row){
                                echo '<h4><a href="singleImage.php?id=' . $row["ImageID"] . '">' . $row["Title"] . '<img src="travel-images/thumb/' .$row['Path'] . '"></a></h4>'; 
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
                                echo '<p>' . $row["Description"] . '</p>'; 
                            }
                        }
                        elseif(isset($_GET['city']) && $_GET['city'] != ""){
                            $cc = $_GET['city']; 
                            $travelImage = new travelImage(); 
                            if(isset($_GET['order']) && $_GET['order'] == 'asc'){
                                $res = $travelImage->getImagesforCity($cc, 'asc'); 
                            }
                            else{
                                $res = $travelImage->getImagesforCity($cc, 'desc'); 
                            }
                            foreach($res as $row){
                                echo '<h4><a href="singleImage.php?id=' . $row["ImageID"] . '">' . $row["Title"] . '<img src="travel-images/thumb/' .$row['Path'] . '"></a></h4>'; 
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
                                echo '<p>' . $row["Description"] . '</p>'; 
                            }
                        }
                        }

                ?>
            </div>
    </body>
</html>