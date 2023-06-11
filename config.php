<?php
    $server = "localhost"; 
    $user = "root"; 
    $db = "Assignment2"; 
    try{
        $cnxn = new PDO("mysql:host=$server;dbname=$db", $user); 
        $cnxn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }catch(PDOException $e){
        echo "Connection Failed";
    }
?>