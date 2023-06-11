<?php
    require_once("config.php");
    class countries{
        function getUniqueCountries(){
            global $cnxn;
            $sql = "select distinct(a.CountryCodeISO), b.CountryName from travelimagedetails a inner join geocountries b on a.CountryCodeISO = b.ISO";
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function getCountryDetails($cc){
            global $cnxn; 
            $sql = "SELECT CountryName, Capital, Area, Population, CurrencyCode, CountryDescription, ISO from geocountries where ISO = ?";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $cc);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
    }

    class cities{
        function getUniqueCities(){
            global $cnxn; 
            $sql = "select distinct(a.CityCode), b.AsciiName, b.CountryCodeISO from travelimagedetails a inner join geocities b on a.CityCode = b.GeoNameID;";
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchall(PDO::FETCH_ASSOC);
            return $res; 
        }
        function getCityForImage($imageID){
            global $cnxn; 
            $sql = "select a.Latitude, a.Longitude, b.asciiname, c.countryname, c.ISO from travelimagedetails a inner join geocities b on b.GeoNameID = a.cityCode inner join geocountries c on c.ISO = a.CountryCodeISO where a.imageID = ?;";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $imageID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getCityByID($cityId){
            global $cnxn; 
            $sql = 'select asciiname, population, elevation, latitude, longitude from geocities where GeoNameID = ?'; 
            $curs = $cnxn->prepare($sql);
            $curs->bindParam(1, $cityId);  
            $curs->execute(); 
            $res = $curs->fetchall(PDO::FETCH_ASSOC);
            return $res; 
            $sql = 'select asciiname, population, elevation, latitude, longitude from geocities where GeoNameID = ?'; 
        }
    }

    class continents{
        function getAllNames(){
            global $cnxn; 
            $sql = "select ContinentName, ContinentCode from geocontinents"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
    }

    class travelPost{
        function getTitleMsgByID($id){
            global $cnxn; 
            $sql = "select Title, Message from travelpost where PostID = ?;";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $id); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC);
            return $res; 
        }
        function getPostByUserExclCurrent($userID, $postID){
            global $cnxn;
            $sql = "select title, message, postid from travelpost where uid = ? and postid <> ?"; 
            $curs = $cnxn->prepare($sql);
            $curs->bindParam(1, $userID); 
            $curs ->bindParam(2, $postID); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function listPosts(){
            global $cnxn;
            $sql = "select PostID, Title, Message from travelpost order by title asc;";
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getPostFromImage($imageID){
            global $cnxn; 
            $sql = "select * from travelpostimages where ImageID = ?"; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $imageID); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getLikeTitle($title, $order){
            global $cnxn; 
            $title = "%$title%"; 
            $sql = "Select * from travelpost where Title like :title order by PostID $order";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(':title', $title);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getLikeMessage($msg, $order){
            global $cnxn; 
            $msg = "%$msg%"; 
            $sql = "Select * from travelpost where Message like :msg order by PostID $order";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(':msg', $msg);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC);
            return $res; 
        }
        function fetchAll(){
            global $cnxn; 
            $sql = "Select * from travelpost";
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }

    }

    class travelUser{
        function getUserFromPost($postID){
            global $cnxn; 
            $sql = "select a.UID, a.PostTime, b.FirstName, b.LastName, b.Email from travelpost a inner join traveluserdetails b on a.UID = b.UID where a.postid = ?;";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $postID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getUserByID($id){
            global $cnxn; 
            $sql = "select * from traveluserdetails where UID = ?"; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $id);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function listUsers(){
            global $cnxn;
            $sql = "select UID, FirstName, LastName, Email from traveluserdetails"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getLogin($userName){
            global $cnxn; 
            $sql = "select a.UID, a.Pass, a.State, b.FirstName, b.LastName from traveluser a inner join traveluserdetails b on a.UID = b.UID where a.userName = ?"; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $userName); 
            $curs->execute();
            $user = $curs->fetch();  
            return $user;
        }
        function createUser($username, $password, $fname, $lname, $address, $city, $region, $country, $zip, $phone, $email, $privacy){
            global $cnxn; 
            $curr = date('Y-m-d H:i:s');
            $sql = "insert into traveluser (userName, Pass, State, DateJoined, DateLastModified) values (?, ?, 1, ?, ?)"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute([$username, $password, $curr, $curr]);
            $sql = "select * from traveluser where username = ?";
            $curs = $cnxn->prepare($sql); 
            $curs->bindparam(1, $username); 
            $curs->execute(); 
            $user = $curs->fetch(); 
            $uid = $user['UID']; 
            $sql = "insert into traveluserdetails (UID, FirstName, LastName, Address, City, Region, Country, Postal, Phone, Email, Privacy) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $curs = $cnxn->prepare($sql); 
            $curs->execute([$uid, $fname, $lname, $address, $city, $region, $country, $zip, $phone, $email, $privacy]); 
        }
    }

    class travelImage{
        function getImagesforPost($postID){
            global $cnxn; 
            $sql = "SELECT a.ImageID, b.Path, c.Title FROM travelpostimages a INNER JOIN travelimage b ON a.ImageID = b.ImageID INNER JOIN travelimagedetails c ON b.ImageID = c.ImageID WHERE a.PostID = ?;";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $postID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC);
            return $res; 
        }
        function getImagesforUser($userID){
            global $cnxn;
            $sql = 'select ImageID, Path from travelimage where UID = ?'; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $userID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC);
            return $res; 
        }
        function getImageandUser($imageID){
            global $cnxn; 
            $sql = "SELECT a.Title, c.FirstName, c.LastName FROM `travelimagedetails` a INNER JOIN travelimage b ON a.ImageID = b.ImageID INNER JOIN traveluserdetails c ON b.UID = c.UID WHERE a.ImageID = ?;";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $imageID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getImagebyID($imageID){
            global $cnxn; 
            $sql = "Select b.Title, a.Path from travelimage a inner join travelimagedetails b on a.ImageID = b.ImageID where a.ImageID = ?"; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $imageID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function avgRating($imageID){
            global $cnxn; 
            $sql = "select ROUND(AVG(rating), 1) as average, count(*) as rating from travelimagerating where ImageID = ?;";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $imageID);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function carouselImages(){
            global $cnxn; 
            $sql = "select a.ImageID, AVG(a.Rating) as av, b.Path, c.Title, d.CountryName, e.AsciiName from travelimagerating a 
            inner join travelimage b on a.ImageID = b.ImageID 
            inner join travelimagedetails c on c.ImageID = a.ImageID 
            inner join geocountries d on d.ISO = c.CountryCodeISO
            inner join geocities e on e.GeoNameID = c.CityCode
            group by a.ImageID order by av DESC limit 3"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute();
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function listImages(){
            global $cnxn; 
            $sql = "select a.ImageID, a.Path, b.Title from travelimage a inner join travelimagedetails b on a.ImageID = b.ImageID;"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function getImagesforCountry($cc, $order){
            global $cnxn; 
            $sql = "select a.ImageID, a.Path, b.Title, b.Description from travelimage a inner join travelimagedetails b on a.ImageID = b.ImageID where b.CountryCodeISO = ? order by a.ImageID $order"; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $cc); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function getImagesforContinent($cont){
            global $cnxn; 
            $sql = 'select a.ImageID, a.Path, b.Title from travelimage a inner join travelimagedetails b on a.ImageID = b.ImageID inner join geocountries c on c.ISO = b.CountryCodeISO where c.Continent = ?';
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $cont); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function getLatest(){
            global $cnxn; 
            $sql = 'select * from travelimage order by imageID desc limit 6';
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function highestRated(){
            global $cnxn; 
            $sql = 'SELECT b.ImageID,b.Path, avg(a.Rating) as av FROM `travelimagerating` a inner join travelimage b on a.ImageID = b.ImageID group by a.ImageID order by av desc limit 6'; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function getImagesforCity($cityId, $order){
            global $cnxn; 
            $sql = "SELECT a.ImageID, a.Path, b.Description, b.Title FROM travelimage a inner join travelimagedetails b on a.ImageID = b.ImageID where b.CityCode = ? order by a.ImageID $order"; 
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $cityId); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res;
        }
        function getLikeTitle($title, $order){
            global $cnxn; 
            $title = "%$title%"; 
            $sql = "Select * from travelimagedetails a inner join travelimage b on a.ImageID = b.ImageID where a.Title like :title order by a.ImageID $order";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(':title', $title);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getLikeDescription($description, $order){
            global $cnxn; 
            $description = "%$description%"; 
            $sql = "Select * from travelimagedetails a inner join travelimage b on a.ImageID = b.ImageID where a.Description like :description order by a.ImageID $order";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(':description', $description);
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function addRating($imageID, $rating, $review, $uid){
            global $cnxn; 
            $curr = date('Y-m-d H:i:s'); 
            $sql = "insert into travelimagerating (ImageID, Rating, uid, review, reviewtime) values (?,?,?,?,?)"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute([$imageID, $rating, $uid, $review, $curr]);
        }
        function getRatingsForImage($imageID){
            global $cnxn; 
            $sql = "select a.Rating, a.Review, a.ImageID, b.FirstName, b.LastName, a.ReviewTime from travelimagerating a inner join traveluserdetails b on a.UID = b.UID where a.imageid = ?";
            $curs = $cnxn->prepare($sql); 
            $curs->bindParam(1, $imageID); 
            $curs->execute(); 
            $res = $curs->fetchAll(PDO::FETCH_ASSOC); 
            return $res; 
        }
        function getRecentReviews(){
            global $cnxn; 
            $sql = "select review, ImageID from travelimagerating order by ReviewTime desc limit 2"; 
            $curs = $cnxn->prepare($sql); 
            $curs->execute(); 
            $res = $curs->fetchALL(PDO::FETCH_ASSOC); 
            return $res; 
        }
    }
?>

