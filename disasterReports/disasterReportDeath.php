<?php
    include '../userData.php';
    include '../DBconnection.php';

    $district = $_POST['district-input'];
    $streetAddress = $_POST['stAdd-input'];
    $disasterDate = $_POST['date-input'];
    $desc = $_POST['prReportDesc-input'];

    $reportType = "Death Record";
    $dName = $_POST['name-input'];
    $dAge = $_POST['age-input'];
    $dGender = $_POST['gender-input'];
    $dCause = $_POST['cause-input'];

    $dlec   = $_POST['declaration-input'];

    switch ($_POST['disaster-input']) {
        case 'flood':
            $disasterTypeId = 22;
            break;
        case 'landslide':
            $disasterTypeId = 23;
            break;
        case 'cyclone':
            $disasterTypeId = 24;
            break;
        case 'earthquake':
            $disasterTypeId = 25;
            break;
        case 'fire':
            $disasterTypeId = 26;
            break;
        case 'tsunami':
            $disasterTypeId = 27;
            break;
        case 'other':
        default:
            $disasterTypeId = 28;
            break;
    }

    if(isset($_POST['declaration-input']))
    {
        try
        {
          $query = "INSERT INTO disaster_report (User_ID,Disaster_Type_ID,Report_Type,District,Street_Address,Description) VALUES (?,?,?,?,?,?)";

          $stmt = mysqli_prepare($con,$query);

          mysqli_stmt_bind_param($stmt,"iissss",$userId,$disasterTypeId,$reportType,$district,$streetAddress,$desc);

          $query_execute = mysqli_stmt_execute($stmt);

          if($query_execute)
          {
                $newReportId = mysqli_stmt_insert_id($stmt);

                $query2 = "INSERT INTO death_record (Report_ID,Full_Name,Age,Gender,Cause_Of_Death) VALUES (?,?,?,?,?)";

                $stmt2 = mysqli_prepare($con,$query2);

                mysqli_stmt_bind_param($stmt2,"issss",$newReportId,$dName,$dAge,$dGender,$dCause);

                $query2_query_execute = mysqli_stmt_execute($stmt2);

                 if($query2_query_execute)
                  {
                          $uploadDir = "../uploads/evidence/ReportID_" . $newReportId . "/";
                          foreach($_FILES['report-attachments']['tmp_name'] as $key => $tmpName)
                          {
                             if (!is_dir($uploadDir))
                             {
                                     mkdir($uploadDir, 0777, true);
                             }

                              $originalName = $_FILES['report-attachments']['name'][$key];

                              $fileType = $_FILES['report-attachments']['type'][$key];

                              $fileSize = $_FILES['report-attachments']['size'][$key];

                              // Generate unique filename
                              $newName = $userId . "_" . uniqid() . "_" . basename($originalName);

                              $destination = $uploadDir . $newName;

                              if(move_uploaded_file($tmpName, $destination))
                              {
                                //insert file path intodatabase evidence_files_and_reports table
                                try
                                {
                                    $fquery = "INSERT INTO evidence_file_and_photos (Report_ID,File_Name,File_Type,File_Path) VALUES (?,?,?,?)";

                                    $fstmt = mysqli_prepare($con,$fquery);

                                    mysqli_stmt_bind_param($fstmt,"isss",$newReportId,$newName,$fileType,$destination);

                                    mysqli_stmt_execute($fstmt);

                                    echo"success";

                                }
                                catch(Exception $e)
                                {
                                    echo "Failed to Insert Report Evidence: ". $e->getMessage();
                                }
                              }
                          }
                  }
                else
                {
                    echo "failed to insert into property_damage";
                }

          }
          else
          {
            echo "failed to insert into disaster_report";
          }


        }
        catch(Exception $e)
        {
            echo "Failed to Insert Report Data: ". $e->getMessage();
        }

    }
    else
    {
        echo "unauthorized";
    }

?>