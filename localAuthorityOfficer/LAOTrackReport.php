<?php
    include 'LAOdashboard.php';
    require_once '../classes/DisasterReport.php';

    $selectedReport = null;
    $selectedReportID = $_GET['report_id'] ?? null;

    if (!empty($selectedReportID))
    {
        // Fetch report data from database
        $selectedReport = DisasterReport::getReport($con, $selectedReportID);

        $isRejected = false;

        if (!empty($selectedReport) && is_array($selectedReport)) {
            $status = $selectedReport['Report_Status'];
            $type = $selectedReport['Report_Type'];

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