<!DOCTYPE html>
<?php
    session_start();
    if($_POST['favType'] == 'image'){
        if(!isset($_SESSION['favImages'])){
            $_SESSION['favImages'] = array(); 
        }
        if(in_array($_POST['favorite'], $_SESSION['favImages'])){
            $i = array_search($_POST['favorite'], $_SESSION['favImages']); 
            unset($_SESSION['favImages'][$i]); 
        }
        else{
            $_SESSION['favImages'][] = $_POST['favorite']; 
        }
    }
    elseif($_POST['favType'] == 'post'){
        if(!isset($_SESSION['favPosts'])){
            $_SESSION['favPosts'] = array(); 
        }
        if(in_array($_POST['favorite'], $_SESSION['favPosts'])){
            $i = array_search($_POST['favorite'], $_SESSION['favPosts']); 
            unset($_SESSION['favPosts'][$i]); 
        }
        else{
            $_SESSION['favPosts'][] = $_POST['favorite']; 
        }
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);

?>