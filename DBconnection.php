<?php
    $con = mysqli_connect("localhost","root","","post_disaster_management_db");

    if(!$con) {
        $_SESSION['message'] = "Failed to connect database";
        header("Location:Error.php");
        die();
    }
?>