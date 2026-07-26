<?php
    require_once '../classes/LocalAuthorityOfficer.php';
    include '../userData.php';
    include '../DBconnection.php';
    require_once '../classes/Notification.php';

    require_once '../classes/MissingPerson.php';
    require_once '../classes/DeathRecord.php';
    require_once '../classes/InjuredPerson.php';
    require_once '../classes/PropertyDamage.php';

    $DSID = LocalAuthorityOfficer::getDSID($con,$userId);
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
            $submittedReportCount = (int)$row['Pending'];
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

    // 2. get Table Data
    try
    {
        $query = "SELECT d.Report_ID, d.Report_Type, d.District, d.Report_Status, d.Report_Date, u.Full_Name FROM disaster_report d JOIN users u ON d.User_ID = u.User_ID WHERE DS_ID = ?";

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

    // 3. get Verified Reports
    try
    {
        $query = "SELECT d.Report_ID, d.Report_Type, d.District, d.Report_Status, d.Report_Date, u.Full_Name FROM disaster_report d JOIN users u ON d.User_ID = u.User_ID WHERE DS_ID = ? AND d.Report_Status='LAO Approved'";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $DSID);
        mysqli_stmt_execute($stmt);

        $verifiedResult = mysqli_stmt_get_result($stmt);
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $tableResult = false;
    }

    // 4. get Rejected Reports
    try
    {
        $query = "SELECT d.Report_ID, d.Report_Type, d.District, d.Report_Status, d.Report_Date, u.Full_Name FROM disaster_report d JOIN users u ON d.User_ID = u.User_ID WHERE DS_ID = ? AND d.Report_Status='LAO Rejected'";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $DSID);
        mysqli_stmt_execute($stmt);

        $rejectedResult = mysqli_stmt_get_result($stmt);
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $tableResult = false;
    }

    // 4. get Pending Reports
    try
    {
        $query = "SELECT d.Report_ID, d.Report_Type, d.District, d.Report_Status, d.Report_Date, u.Full_Name FROM disaster_report d JOIN users u ON d.User_ID = u.User_ID WHERE DS_ID = ? AND d.Report_Status='Submitted'";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $DSID);
        mysqli_stmt_execute($stmt);

        $pendingResult = mysqli_stmt_get_result($stmt);
    }
    catch(Exception $e)
    {
        error_log($e->getMessage());
        $tableResult = false;
    }


    $Notifications = Notification::loadNotification($con,$userId);
    $NotificationCount = Notification::getNotificationCount($con,$userId);



    if (isset($_GET['action']) && isset($_GET['report_id']) && isset($_GET['User_ID']))
    {
        $action = strtolower(trim($_GET['action']));

        $reportId = (int)$_GET['report_id'];
        $citizenId = (int)$_GET['User_ID'];
        $newStatus = null;
        $title = '';
        $message = '';
        $type = '';

        if ($action === 'accept')
        {
            $newStatus = 'LAO Approved';
            $title = 'Report Approval';
            $message = 'Your Report Has Been Approved By a Local Authority Officer';
            $type = 'LAO Approval';

        } elseif ($action === 'reject')
        {
            $newStatus = 'LAO Rejected';
            $title = 'Report Rejection';
            $message = 'Your Report Has Been Rejected By a Local Authority Officer';
            $type = 'LAO Rejection';
        }

        if ($newStatus !== null)
        {
            $updateQuery = "UPDATE disaster_report SET Report_Status = ? WHERE Report_ID = ?";

            if ($stmt = mysqli_prepare($con, $updateQuery))
            {
                mysqli_stmt_bind_param($stmt, "si", $newStatus, $reportId);

                if (mysqli_stmt_execute($stmt))
                {
                    mysqli_stmt_close($stmt);

                    Notification::createCitizenNotification($con, $citizenId, $reportId, $title, $message, $type);
                } else
                {
                    mysqli_stmt_close($stmt);
                }
            }
        }

        header("Location: LAOPendingReportsForm.php");
        exit();
    }


?>