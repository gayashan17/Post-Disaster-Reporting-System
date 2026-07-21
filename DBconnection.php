<?php
    if (session_status() === PHP_SESSION_NONE) // to fix session already started error
    {
        session_start();
    }

    $con = mysqli_connect("localhost","root","","post_disaster_management_db");

    if(!$con) {
        $_SESSION['message'] = "Failed to connect database";
        header("Location:Error.php");
        die();
    }
?>