<?php
    require_once '../classes/DisasterReport.php';
    require_once '../classes/PropertyDamage.php';
    require_once '../classes/EvidenceFile.php';
    require_once '../classes/Notification.php';
    include '../userData.php';
    include '../DBconnection.php';

    // ---------- AJAX: fetch DS list for a district ----------
    if (isset($_POST['action']) && $_POST['action'] === 'getDS')
    {
        header('Content-Type: application/json');

        $district = $_POST['district'] ?? null;

        if (!$district) {
            echo json_encode(['error' => 'No district provided']);
            exit;
        }

        try {
            $dsList = DisasterReport::getDivisionalSecretariat($con, $district);
            echo json_encode($dsList);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit; // stop here, don't fall through to report submission logic
    }

    // ---------- Normal report submission continues below ----------

    $district = $_POST['district-input'];
    $streetAddress = $_POST['stAdd-input'];
    $desc = $_POST['prReportDesc-input'];

    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    $reportType = "Property Damage";
    $propertyType = $_POST['prType-input'];
    $damageLevel = $_POST['dmgLevel-input'];
    $damageEstCost = $_POST['cost-input'];
    $damageDescription = $_POST['prDmgDesc-input'];

    $dlec = $_POST['declaration-input'];

    switch ($_POST['disaster-input']) {
        case 'flood': $disasterTypeId = 22; break;
        case 'landslide': $disasterTypeId = 23; break;
        case 'cyclone': $disasterTypeId = 24; break;
        case 'earthquake': $disasterTypeId = 25; break;
        case 'fire': $disasterTypeId = 26; break;
        case 'tsunami': $disasterTypeId = 27; break;
        case 'other':
        default: $disasterTypeId = 28; break;
    }

    if (isset($_POST['declaration-input']))
    {
        try
        {
            $report = new PropertyDamage();

            $report->setUserId($userId);
            $report->setDisasterTypeId($disasterTypeId);
            $report->setDistrict($_POST['district-input']);
            $report->setStreetAddress($_POST['stAdd-input']);
            $report->setDescription($_POST['prReportDesc-input']);
            $report->setReportType("Property Damage");

            // DS_ID now comes directly from the DS combo box the user picked
            $DSID = $_POST['ds-input'] ?? null;

            if (!$DSID || $DSID === 'default') {
                echo "Please select a Divisional Secretariat.";
                exit;
            }

            $report->setDSID($DSID);

            $report->setPropertyType($_POST['prType-input']);
            $report->setDamageLevel($_POST['dmgLevel-input']);
            $report->setDamageDescription($_POST['prDmgDesc-input']);
            $report->setEstimatedCost($_POST['cost-input']);
            $report->setLatitude($_POST['latitude'] ?? null);
            $report->setLongitude($_POST['longitude'] ?? null);

            $reportId = $report->insertReport($con);
            $report->insertPropertyDamage($con, $reportId);

            $evidence = new EvidenceFile();
            $evidence->uploadFiles($con, $reportId, $userId);

            Notification :: createLAONotification(
                $con, $DSID, $reportId,
                "New Property Damage Disaster Report",
                "A new disaster report has been submitted for your Divisional Secretariat and requires review.",
                "Report Submitted"
            );

            echo "success";
        }
        catch (Exception $e)
        {
            echo "Failed to Insert Report Data: " . $e->getMessage();
        }
    }
    else
    {
        echo "unauthorized";
    }
?>