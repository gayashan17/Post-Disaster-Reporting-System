<?php
    $con = mysqli_connect("localhost","root","","post_disaster_management_db");

    if(!$con) {
        header("Location:Error.html");
        die();
    }
?>