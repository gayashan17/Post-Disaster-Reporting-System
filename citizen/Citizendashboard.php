<?php
    session_start();
    include '../userData.php';
    include '../DBconnection.php';


    // 1. get Summary Counts
    try
    {
        $query = "SELECT COUNT(Report_ID) AS total,
        SUM(Report_Status IN ('submitted', 'LAO Pending','DMO Pending','DS Pending','FO Pending')) AS pending,
        SUM(Report_Status IN ('DS Approved')) AS approved,
        SUM(Report_Status IN ('FO Paid')) AS pCompleted
        FROM disaster_report WHERE User_ID = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result))
        {
            $totReportCount = (int)$row['total'];
            $pendigReportCount = (int)$row['pending'];
            $approvedReportCount = (int)$row['approved'];
            $pCompletedReportCount = (int)$row['pCompleted'];
        }
        else
        {
            $totReportCount = 0;
            $pendigReportCount = 0;
            $approvedReportCount = 0;
            $pCompletedReportCount = 0;
        }
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $totReportCount = 0;
        $pendigReportCount = 0;
        $approvedReportCount = 0;
        $pCompletedReportCount = 0;
    }

    // Initialize Chart Count Variables
    $deathReportCount = 0;
    $injReportCount = 0;
    $missingReportCount = 0;
    $prDmgReportCount = 0;

    // 2. get Report Types Count
    try
    {
        $query = "SELECT Report_Type, COUNT(Report_ID) as type_count FROM disaster_report WHERE User_ID = ? GROUP BY Report_Type";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($result))
        {
            $count = (int)$row['type_count'];
            switch ($row['Report_Type'])
            {
                case 'Death Record':
                case 'Death Report':
                    $deathReportCount = $count;
                    break;
                case 'Injured Person':
                    $injReportCount = $count;
                    break;
                case 'Missing Person Record':
                case 'Missing Person':
                    $missingReportCount = $count;
                    break;
                case 'Property Damage':
                    $prDmgReportCount = $count;
                    break;
            }
        }
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
    }

    // 3. get Table Data
    try
    {
        $query = "SELECT Report_ID, Report_Type, District, Report_Status, Report_Date FROM disaster_report WHERE User_ID = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $tableResult = mysqli_stmt_get_result($stmt);
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $tableResult = false;
    }
?>