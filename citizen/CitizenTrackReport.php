<?php
    include 'Citizendashboard.php';
    require_once '../classes/DisasterReport.php';

    $selectedReport = null;
    $selectedReportID = $_GET['report_id'] ?? null;
    $currentStep = 1; // Default step

    if (!empty($selectedReportID))
    {
        // Fetch report data from database
        $selectedReport = DisasterReport::getReport($con, $selectedReportID);

        $isRejected = false;
        $currentStep = 1;

        if (!empty($selectedReport) && is_array($selectedReport)) {
            $status = $selectedReport['Report_Status'];
            $type = $selectedReport['Report_Type'];

            // Check for Rejected status first
            if (stripos($status, 'LAO Rejected') !== false || stripos($status, 'DMO Rejected') !== false || stripos($status, 'DS Rejected') !== false || stripos($status, 'FO Rejected') !== false) {
                $isRejected = true;
                $currentStep = -1;
            } elseif (stripos($status, 'Submitted') !== false) {
                $currentStep = 1;
            } elseif (stripos($status, 'LAO Pending') !== false) {
                $currentStep = 2;
            } elseif (stripos($status, 'DMO Pending') !== false || stripos($status, 'LAO Approved') !== false ) {
                $currentStep = 3;
            } elseif (stripos($status, 'DS Pending') !== false || stripos($status, 'DMO Approved') !== false ) {
                $currentStep = 4;
            } elseif (stripos($status, 'FO Pending') !== false || stripos($status, 'DS Approved') !== false ) {
                $currentStep = 5;
            }elseif (stripos($status, 'FO Paid') !== false) {
                $currentStep = 6;
            }

            switch($type)
            {
                case "Property Damage":
                $ReportData = PropertyDamage :: getPropertyDamageReport($con,$selectedReportID);
                break;

                case "Missing Person Record":
                $ReportData = MissingPerson :: getMissingPersonReport($con,$selectedReportID);
                break;

                case "Injured Person":
                $ReportData = InjuredPerson :: getInjuredPersonReport($con,$selectedReportID);
                break;

                case "Death Record":
                $ReportData = DeathRecord :: getDeathPersonReport($con,$selectedReportID);
                break;
            }

        }
    }
?>