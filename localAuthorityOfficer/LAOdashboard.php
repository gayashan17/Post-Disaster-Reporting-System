<?php
    session_start();
    require_once '../classes/LocalAuthorityOfficer.php';
    include '../userData.php';
    include '../DBconnection.php';


    // 1. get Summary Counts
    try
    {

        $query = "SELECT
                      COUNT(dr.Report_ID) AS Total,
                      COUNT(CASE WHEN dr.Report_Status = 'Submitted' THEN 1 END) AS Pending,
                      COUNT(CASE WHEN dr.Report_Status = 'LAO Approved' THEN 1 END) AS Verified,
                      COUNT(CASE WHEN dr.Report_Status = 'LAO Rejected' THEN 1 END) AS Rejected
                  FROM disaster_report dr
                  JOIN local_authority_officer lao
                      ON dr.DS_ID = lao.Assigned_divisional_secretariat
                  WHERE dr.DS_ID = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $DSID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result))
        {
            $totReportCount = (int)$row['Total'];
            $submittedReportCount = (int)$row['Submitted'];
            $verifiedReportCount = (int)$row['Verified'];
            $rejectedReportCount = (int)$row['Rejected'];
        }
        else
        {
            $totReportCount = 0;
            $submittedReportCount = 0;
            $verifiedReportCount = 0;
            $rejectedReportCount = 0;
        }
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $totReportCount = 0;
        $submittedReportCount = 0;
        $verifiedReportCount = 0;
        $rejectedReportCount = 0;
    }

    // 3. get Table Data
    try
    {
        $query = "SELECT Report_ID, Report_Type, District, Report_Status, Report_Date FROM disaster_report WHERE DS_ID = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $DSID);
        mysqli_stmt_execute($stmt);

        $tableResult = mysqli_stmt_get_result($stmt);
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $tableResult = false;
    }
?>