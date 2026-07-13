<?php
    session_start();
    include '../userData.php';
    include '../DBconnection.php';


    $district = $_POST['district-input'];
    $streetAddress = $_POST['stAdd-input'];
    $disasterDate = $_POST['date-input'];
    $desc = $_POST['prReportDesc-input'];
    $propertyType = $_POST['prType-input'];
    $damageLevel = $_POST['dmgLevel-input'];
    $damageEstCost = $_POST['cost-input'];
    $damageDescription = $_POST['prDmgDesc-input'];
    $dlec   = $_POST['declaration-input'];

    if($_POST['disaster-input'] === "flood")
    {
        $disasterTypeId = 22;
    }
    if($_POST['disaster-input'] === "landslide")
    {
        $disasterTypeId = 23;
    }
    if($_POST['disaster-input'] === "cyclone")
    {
        $disasterTypeId = 24;
    }
    if($_POST['disaster-input'] === "earthquake")
    {
        $disasterTypeId = 25;
    }
    if($_POST['disaster-input'] === "fire")
    {
        $disasterTypeId = 26;
    }
    if($_POST['disaster-input'] === "tsunami")
    {
        $disasterTypeId = 27;
    }
    if($_POST['disaster-input'] === "other")
    {
        $disasterTypeId = 28;
    }

    if(isset($_POST['declaration-input']))
    {
        try
        {
              $uploadDir = "../uploads/evidence/";

              $query = "INSERT INTO disaster_report (District,Street_Address,Description,Damage_Level,Damage_EstCost,Damage_Description,Property_Type,Disaster_Date,User_ID,Disaster_Type_ID) VALUES (?,?,?,?,?,?,?,?,?,?)";

              $stmt = mysqli_prepare($con,$query);

              mysqli_stmt_bind_param($stmt,"ssssdsssii",$district,$streetAddress,$desc,$damageLevel,$damageEstCost,$damageDescription,$propertyType,$disasterDate,$_SESSION['user_Id'],$disasterTypeId);

              $query_execute = mysqli_stmt_execute($stmt);

              if($query_execute)
              {
                  fwrite(STDOUT, "This prints directly to the terminal console.\n");
                  foreach($_FILES['report-attachments']['tmp_name'] as $key => $tmpName)
                  {

                      $originalName = $_FILES['report-attachments']['name'][$key];

                      $fileType = $_FILES['report-attachments']['type'][$key];

                      $fileSize = $_FILES['report-attachments']['size'][$key];

                      // Generate unique filename
                      $newName = $_SESSION['user_Id'] . "_" . uniqid() . "_" . basename($originalName);

                      $destination = $uploadDir . $newName;

                      if(move_uploaded_file($tmpName, $destination))
                      {

                      }
                  }
              }
              else
              {
                echo"data insert failed";

              }
        }
        catch(Exception $e)
        {
            $_SESSION['message']="db insert failed". $e->getMessage();
            header('Location:../Error.php');
            die();
        }

    }
    else
    {
        
    }

?>