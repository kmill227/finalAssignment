<?php
    session_start(); 
    require_once('classes.php'); 
    if(isset($_POST['rating']) && isset($_POST['review'])){
        $travelImage = new travelImage();
        try{ 
            $travelImage->addRating($_POST['imageID'], $_POST['rating'], $_POST['review'], $_SESSION['userID']);
        }
        catch(exception $e){
            header('Location: singleimage.php?id=' .$_POST['imageID']); 
        }
    }
    header('Location: singleimage.php?id=' .$_POST['imageID']); 
?>