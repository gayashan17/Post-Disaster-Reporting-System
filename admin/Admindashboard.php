<?php

    require_once '../DBconnection.php';
    require_once '../classes/User.php';
    require_once '../classes/DisasterReport.php';
    include '../userData.php';

    header('Content-Type: application/json');

    try
    {

        $userObj = new User();
        $reportObj = new DisasterReport();

        $response = [
            'success' => true,
            'totalUsers' => $userObj->getTotalUsers($con),
            'activeUsers' => $userObj->getTotalActiveUsers($con),
            'bannedUsers' => $userObj->getTotalBannedUsers($con),
            'totalReports' => $reportObj->getTotalReports($con),
            'roleCounts' => $userObj->getUserRoleCounts($con),
            'monthlyReportActivity' => $reportObj->getMonthlyReportActivity($con),
            'recentRegistrations' => $userObj->getRecentRegistrations($con)
        ];

        echo json_encode($response);
    }
    catch (Exception $e)
    {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }


    
?>