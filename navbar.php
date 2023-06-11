
      <?php 
        session_start(); 
        require_once("classes.php"); 
      ?>
      
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <link rel="stylesheet" href="style.css">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand" href="#">Travel Site</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aboutus.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="search.php">Advanced Search</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Browse
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="postlist.php">Posts</a>
              <a class="dropdown-item" href="imagelist.php">Images</a>
              <a class="dropdown-item" href="userlist.php">Users</a>
            </div>
          </li>
        </ul>
        <div class="ml-auto mr-4">
        <form class="form-inline" action="search.php" method="GET">
          <input type="hidden" name="searchType" value="images">
          <input class="form-control mr-sm-2" type="text" placeholder="Search Images" name="imagetitle">
          <button type="submit" class="btn btn-primary">Search</button>
        </form>
        </div>
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-secondary" onclick="window.location.href='viewfavorites.php'">Favorites</button>
          <button type="button" class="btn btn-secondary">
            <?php
              if(isset($_COOKIE['userID'])){
                $_SESSION['userID'] = $_COOKIE['userID']; 
                $_SESSION['name'] = $_COOKIE['name']; 
              }
              if(isset($_SESSION['userID'])){
                echo $_SESSION['name']; 
              }
              else{
                echo "My Account"; 
              }
            ?>
          </button>
          <button type="button" class="btn btn-secondary" onclick="window.location.href='createAccount.php'">Register</button>
          <button type="button" class="btn btn-secondary" onclick="window.location.href='login.php'">Login</button>
        </div>
      </div>
    </nav>
    <div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <div class="row">
      <div class="col-sm-4">
        <h5>Countries</h5>
      <?php 
        $countries = new countries(); 
        $res = $countries->getUniqueCountries(); 
        foreach($res as $row){
          echo("<a href=\"location.php?country=" . $row['CountryCodeISO']. "\" class=\"nav-link\">". $row['CountryName'] . "</a>");
        }
        echo "</div>"; 
        echo '<div class="col-sm-4">';
        echo '<h5>Cities</h5>';
        $cities = new cities(); 
        $res = $cities->getUniqueCities(); 
        foreach($res as $row){
          echo("<a href=\"location.php?country=" . $row['CountryCodeISO']. "&city=" . $row['CityCode'] . "\" class=\"nav-link\">". $row['AsciiName'] . "</a>");
        }
        echo '</div>'; 
        echo '<div class="col-sm-4">';
        echo '<h5>Continents</h5>';
        $continents = new continents(); 
        $res = $continents->getAllNames(); 
        foreach($res as $row){
          echo("<a href=\"imagelist.php?type=continent&country=&continent=" . $row['ContinentCode'] ."\" class=\"nav-link\">" . $row['ContinentName'] . "</a>"); 
        }
        echo '</div>'; 
      ?> 
      </div>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <img src="travel-images\ads\074762829609d01702966fa121906d1e.jpg">
</div>

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
