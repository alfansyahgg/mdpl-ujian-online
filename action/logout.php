<?php 

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    require_once('connection.php');
    session_start();
    session_destroy();

    header("Location: ".$baseURL.'login.php');
}else{
    die('Error');
}


?>