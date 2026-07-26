<?php
require_once 'User.php';


// ================================================================//
//                 DisasterManagementOfficer CLASS                 //
// ================================================================//
//
// Mirrors DistrictSecretary.php one step earlier in the approval
// chain:
//   - Own role:            Role_ID = 2   (was 5 for District Secretary)
//   - Previous role (LAO): Role_ID = 4   (was 2 for DMO, from DS's view)
//   - Incoming status:     'LAO Approved' (was 'DMO Approved')
//   - Own outgoing status: 'DMO Approved' / 'DMO Rejected'
//                          (was 'DS Approved' / 'DS Rejected')
//   - Own table:           disaster_management_officer
//                          (was district_secretary)
//   - Own join column:     Region_Assigned (was Office_Name)
// ================================================================//

class DisasterManagementOfficer extends User
{
    private $regionAssigned;

    //// Setters

    public function setRegionAssigned($regionAssigned)
    {
        $this->regionAssigned = $regionAssigned;
    }

    //// Getters

    public function getRegionAssigned()
    {
        return $this->regionAssigned;
    }


    // ================================================================
    //        GET ALL LAO APPROVED REPORTS FOR Disaster Management Officer
    // ================================================================

    public function getLAOApprovedReports($con, $DMOUserID)
    {
        try
        {
            $query = "SELECT
                        dr.Report_ID,
                        dr.Report_Type,
                        dr.District,
                        ds.DS_Name,
                        vr.Estimated_Amount,
                        c.Beneficiary_Bank_Account_No AS Bank_Account_No

                    FROM disaster_report dr

                    INNER JOIN disaster_management_officer dmo
                        ON dr.District = dmo.Region_Assigned

                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID

                    LEFT JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID
                        AND vr.Created_By_Officer_User_ID IN (
                            SELECT User_ID FROM users WHERE Role_ID = 4
                        )

                    LEFT JOIN citizen c
                        ON dr.User_ID = c.User_ID

                    WHERE dr.Report_Status = 'LAO Approved'
                        AND dmo.User_ID = ?

                    ORDER BY dr.Report_ID DESC";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception('Failed to prepare statement.');
            }

            mysqli_stmt_bind_param($stmt, "i", $DMOUserID);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $reports = [];

            while ($row = mysqli_fetch_assoc($result))
            {
                $reports[] = $row;
            }

            mysqli_stmt_close($stmt);
            return $reports;
        }
        catch (Exception $e)
        {
            throw new Exception("Error retrieving LAO approved reports: " . $e->getMessage());
        }
    }


    // ================================================================
    //   GET FULL LAO Approved REPORT DETAILS (single row, no multiplying joins)
    // ================================================================
    public function getLAOApprovedReportDetails($con, $Report_ID)
    {
        try
        {
            $query = "SELECT
                        dr.*,
                        u.User_ID,
                        u.Username,
                        u.Full_Name,
                        u.Gender,
                        u.NIC,
                        u.Email,
                        u.Phone_Number,
                        u.Address,
                        c.Beneficiary_Name,
                        c.Beneficiary_Bank,
                        c.Beneficiary_Bank_Account_No,
                        ds.DS_ID,
                        ds.DS_Name,
                        ds.District AS DS_District,
                        vr.*
                    FROM disaster_report dr
                    INNER JOIN users u
                        ON dr.User_ID = u.User_ID
                    LEFT JOIN citizen c
                        ON dr.User_ID = c.User_ID
                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID
                    LEFT JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID
                        AND vr.Created_By_Officer_User_ID IN (
                            SELECT User_ID
                            FROM users
                            WHERE Role_ID = 4
                        )
                        AND vr.Report_Status = 'Verified'
                    WHERE dr.Report_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $Report_ID);

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to retrieve report details.");
            }

            $result = mysqli_stmt_get_result($stmt);
            $report = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            if(!$report)
            {
                throw new Exception("Report not found.");
            }

            return $report;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to load report details: " . $e->getMessage());
        }
    }

    // ================================================================
    //   GET FULL DMO Approved REPORT DETAILS (single row, no multiplying joins)
    // ================================================================
    public function getDMOApprovedReportDetails($con, $Report_ID)
    {
        try
        {
            $query = "SELECT
                        dr.*,
                        u.User_ID,
                        u.Username,
                        u.Full_Name,
                        u.Gender,
                        u.NIC,
                        u.Email,
                        u.Phone_Number,
                        u.Address,
                        c.Beneficiary_Name,
                        c.Beneficiary_Bank,
                        c.Beneficiary_Bank_Account_No,
                        ds.DS_ID,
                        ds.DS_Name,
                        ds.District AS DS_District,
                        vr.*
                    FROM disaster_report dr
                    INNER JOIN users u
                        ON dr.User_ID = u.User_ID
                    LEFT JOIN citizen c
                        ON dr.User_ID = c.User_ID
                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID
                    LEFT JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID
                        AND vr.Created_By_Officer_User_ID IN (
                            SELECT User_ID
                            FROM users
                            WHERE Role_ID = 2
                        )
                        AND vr.Report_Status = 'Verified'
                    WHERE dr.Report_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $Report_ID);

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to retrieve report details.");
            }

            $result = mysqli_stmt_get_result($stmt);
            $report = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            if(!$report)
            {
                throw new Exception("Report not found.");
            }

            return $report;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to load report details: " . $e->getMessage());
        }
    }

    // ================================================================
    //   GET FULL DMO Reject REPORT DETAILS (single row, no multiplying joins)
    // ================================================================
    public function getDMORejectedReportDetails($con, $Report_ID)
    {
        try
        {
            $query = "SELECT
                        dr.*,
                        u.User_ID,
                        u.Username,
                        u.Full_Name,
                        u.Gender,
                        u.NIC,
                        u.Email,
                        u.Phone_Number,
                        u.Address,
                        c.Beneficiary_Name,
                        c.Beneficiary_Bank,
                        c.Beneficiary_Bank_Account_No,
                        ds.DS_ID,
                        ds.DS_Name,
                        ds.District AS DS_District,
                        vr.*
                    FROM disaster_report dr
                    INNER JOIN users u
                        ON dr.User_ID = u.User_ID
                    LEFT JOIN citizen c
                        ON dr.User_ID = c.User_ID
                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID
                    LEFT JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID
                        AND vr.Created_By_Officer_User_ID IN (
                            SELECT User_ID
                            FROM users
                            WHERE Role_ID = 2
                        )
                        AND vr.Report_Status = 'Rejected'
                    WHERE dr.Report_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $Report_ID);

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to retrieve report details.");
            }

            $result = mysqli_stmt_get_result($stmt);
            $report = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            if(!$report)
            {
                throw new Exception("Report not found.");
            }

            return $report;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to load report details: " . $e->getMessage());
        }
    }

    // ================================================================
    //   GET DMO-REJECTED REPORT DETAILS FOR RE-PROCESSING
    //   (pulls the LAO's original estimate, since the DMO's own
    //   rejected verification_report row has a NULL amount)
    // ================================================================
    public function getDMORejectedReportForProcessing($con, $Report_ID)
    {
        try
        {
            $query = "SELECT
                        dr.*,
                        u.User_ID,
                        u.Username,
                        u.Full_Name,
                        u.Gender,
                        u.NIC,
                        u.Email,
                        u.Phone_Number,
                        u.Address,
                        c.Beneficiary_Name,
                        c.Beneficiary_Bank,
                        c.Beneficiary_Bank_Account_No,
                        ds.DS_ID,
                        ds.DS_Name,
                        ds.District AS DS_District,
                        lao_vr.Estimated_Amount AS Estimated_Amount,
                        lao_vr.Description AS LAO_Description,
                        dmo_vr.Description AS Rejection_Reason
                    FROM disaster_report dr
                    INNER JOIN users u
                        ON dr.User_ID = u.User_ID
                    LEFT JOIN citizen c
                        ON dr.User_ID = c.User_ID
                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID
                    LEFT JOIN verification_report lao_vr
                        ON dr.Report_ID = lao_vr.Report_ID
                        AND lao_vr.Created_By_Officer_User_ID IN (
                            SELECT User_ID
                            FROM users
                            WHERE Role_ID = 4
                        )
                        AND lao_vr.Report_Status = 'Verified'
                    LEFT JOIN verification_report dmo_vr
                        ON dr.Report_ID = dmo_vr.Report_ID
                        AND dmo_vr.Created_By_Officer_User_ID IN (
                            SELECT User_ID
                            FROM users
                            WHERE Role_ID = 2
                        )
                        AND dmo_vr.Report_Status = 'Rejected'
                    WHERE dr.Report_ID = ?
                        AND dr.Report_Status = 'DMO Rejected'";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $Report_ID);

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to retrieve report details.");
            }

            $result = mysqli_stmt_get_result($stmt);
            $report = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            if(!$report)
            {
                throw new Exception("Report not found or is not currently DMO Rejected.");
            }

            return $report;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to load report details for processing: " . $e->getMessage());
        }
    }


    // ================================================================
    //   GET ALL EVIDENCE FILES FOR A REPORT (supports multiple files)
    //   (unchanged - shared reference data, not role specific)
    // ================================================================
    public function getEvidenceFilesByReportID($con, $Report_ID)
    {
        try
        {
            $query = "SELECT File_ID, File_Name, File_Type, File_Path, Uploaded_Date
                    FROM evidence_file_and_photos
                    WHERE Report_ID = ?
                    ORDER BY Uploaded_Date ASC";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $Report_ID);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $files = [];

            while($row = mysqli_fetch_assoc($result))
            {
                $files[] = $row;
            }

            mysqli_stmt_close($stmt);
            return $files;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to load evidence files: " . $e->getMessage());
        }
    }

    // ================================================================
    //   GET TYPE-SPECIFIC DAMAGE/CASUALTY DETAILS (supports multiples)
    //   (unchanged - shared reference data, not role specific)
    // ================================================================
    public function getReportTypeDetails($con, $Report_ID, $Report_Type)
    {
        try
        {
            switch ($Report_Type)
            {
                case 'Property Damage':
                    $query = "SELECT Property_Type, Damage_Level, Damage_Description,
                                    Estimated_Cost, Latitude, Longitude
                            FROM property_damage WHERE Report_ID = ?";
                    break;

                case 'Death Record':
                    $query = "SELECT Full_Name, Age, Gender, Cause_Of_Death
                            FROM death_record WHERE Report_ID = ?";
                    break;

                case 'Injured Person':
                    $query = "SELECT Full_Name, Age, Gender, Injured_Level
                            FROM injured_person WHERE Report_ID = ?";
                    break;

                case 'Missing Person Record':
                    $query = "SELECT Full_Name, Age, Gender, Last_Seen_Location,
                                    Last_Seen_Date, Last_Seen_Time, Status, Relationship_to_Person
                            FROM missing_person_record WHERE Report_ID = ?";
                    break;

                default:
                    return [];
            }

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $Report_ID);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $rows = [];

            while($row = mysqli_fetch_assoc($result))
            {
                $rows[] = $row;
            }

            mysqli_stmt_close($stmt);
            return $rows;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to load report type details: " . $e->getMessage());
        }
    }

    // ================================================================
    // Add Disaster Management Officer Verified Verification Report
    //   (unchanged logic - just inserts under whichever officer ID is passed in)
    // ================================================================

    public function addVerifiedVerificationReport(
        $con,
        $reportID,
        $dmoUserID,
        $description,
        $estimatedAmount
    )
    {
        try
        {
            $query = "
                INSERT INTO verification_report
                (
                    Report_ID,
                    Created_By_Officer_User_ID,
                    Description,
                    Report_Status,
                    Estimated_Amount,
                    Verification_Date
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    'Verified',
                    ?,
                    NOW()
                )
            ";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception(
                    'Failed to prepare statement.'
                );
            }

            mysqli_stmt_bind_param(
                $stmt,
                "iisd",
                $reportID,
                $dmoUserID,
                $description,
                $estimatedAmount
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception(
                'Failed to create verified verification report.'
            );
        }
        catch(Exception $e)
        {
            throw new Exception(
                'Verified verification report creation failed: '
                . $e->getMessage()
            );
        }
    }

    // ================================================================
    // Add Disaster Management Officer Rejected Verification Report
    // ================================================================

    public function addRejectedVerificationReport($con, $reportID, $dmoUserID, $description)
    {
        try
        {
            $query = "
                INSERT INTO verification_report
                (Report_ID, Created_By_Officer_User_ID, Description, Report_Status, Estimated_Amount, Verification_Date)
                VALUES (?, ?, ?, 'Rejected', NULL, NOW())
            ";

            $stmt = mysqli_prepare($con, $query);
            if(!$stmt) { throw new Exception('Failed to prepare statement.'); }

            mysqli_stmt_bind_param($stmt, "iis", $reportID, $dmoUserID, $description);

            if(mysqli_stmt_execute($stmt)) { return true; }
            throw new Exception('Failed to create rejected verification report.');
        }
        catch(Exception $e)
        {
            throw new Exception('Rejected verification report creation failed: ' . $e->getMessage());
        }
    }


    // ================================================================
    //        Update Report_Status To DMO Approved in Disaster_Report
    // ================================================================
    public function updateReportStatusToDMOApproved($con, $reportID)
    {
        try
        {
            $query = "UPDATE disaster_report
                    SET Report_Status = 'DMO Approved'
                    WHERE Report_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception(
                    'Failed to prepare statement.'
                );
            }

            mysqli_stmt_bind_param(
                $stmt,
                'i',
                $reportID
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception(
                'Failed to update report status.'
            );
        }
        catch(Exception $e)
        {
            throw new Exception(
                'Report status update failed: ' .
                $e->getMessage()
            );
        }
    }

    // ================================================================
    //        Update Report_Status To DMO Rejected in Disaster_Report
    // ================================================================
    public function updateReportStatusToDMORejected($con, $reportID)
    {
        try
        {
            $query = "UPDATE disaster_report
                    SET Report_Status = 'DMO Rejected'
                    WHERE Report_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception(
                    'Failed to prepare statement.'
                );
            }

            mysqli_stmt_bind_param(
                $stmt,
                'i',
                $reportID
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception(
                'Failed to update report status.'
            );
        }
        catch(Exception $e)
        {
            throw new Exception(
                'Report status update failed: ' .
                $e->getMessage()
            );
        }
    }


    // ================================================================
    //        Get DMO Verified Reports
    // ================================================================

    public function getDMOVerifiedReports($con, $DMOUserID)
    {
        try
        {
            $query = "SELECT
                        dr.Report_ID,
                        dr.Report_Type,
                        dr.District,
                        ds.DS_Name,
                        vr.Estimated_Amount,
                        vr.Description,
                        c.Beneficiary_Bank_Account_No AS Bank_Account_No

                    FROM disaster_report dr

                    INNER JOIN disaster_management_officer dmo
                        ON dr.District = dmo.Region_Assigned

                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID

                    INNER JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID
                        AND vr.Created_By_Officer_User_ID = dmo.User_ID
                        AND vr.Report_Status = 'Verified'

                    LEFT JOIN citizen c
                        ON dr.User_ID = c.User_ID

                    WHERE dmo.User_ID = ?

                    ORDER BY dr.Report_ID DESC";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception(
                    'Failed to prepare statement.'
                );
            }

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $DMOUserID
            );

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception(
                    'Failed to retrieve DMO verified reports.'
                );
            }

            $result = mysqli_stmt_get_result($stmt);

            $reports = [];

            while($row = mysqli_fetch_assoc($result))
            {
                $reports[] = $row;
            }

            mysqli_stmt_close($stmt);

            return $reports;
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Error retrieving DMO verified reports: "
                . $e->getMessage()
            );
        }
    }


    // ================================================================
    //        Get DMO Rejected Reports
    // ================================================================

    public function getDMORejectedReports($con, $DMOUserID)
    {
        try
        {
            $query = "SELECT
                        dr.Report_ID,
                        dr.Report_Type,
                        dr.District,
                        ds.DS_Name,
                        vr.Description AS Rejection_Reason,
                        c.Beneficiary_Bank_Account_No AS Bank_Account_No
                    FROM disaster_report dr
                    INNER JOIN disaster_management_officer dmo ON dr.District = dmo.Region_Assigned
                    LEFT JOIN divisional_secretariat ds ON dr.DS_ID = ds.DS_ID
                    INNER JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID
                        AND vr.Created_By_Officer_User_ID = dmo.User_ID
                        AND vr.Report_Status = 'Rejected'
                    LEFT JOIN citizen c ON dr.User_ID = c.User_ID
                    WHERE dr.Report_Status = 'DMO Rejected'
                        AND dmo.User_ID = ?
                    ORDER BY dr.Report_ID DESC";

            $stmt = mysqli_prepare($con, $query);
            if(!$stmt) { throw new Exception('Failed to prepare statement.'); }

            mysqli_stmt_bind_param($stmt, "i", $DMOUserID);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $reports = [];
            while ($row = mysqli_fetch_assoc($result)) { $reports[] = $row; }
            mysqli_stmt_close($stmt);
            return $reports;
        }
        catch (Exception $e)
        {
            throw new Exception("Error retrieving DMO rejected reports: " . $e->getMessage());
        }
    }

    // ================================================================
    //       Dashboard status
    // ================================================================

    public function getDMODashboardStats($con, $DMOUserID)
    {
        try
        {
            $stats = [];

            $q1 = "SELECT COUNT(*) AS cnt FROM disaster_report dr
                INNER JOIN disaster_management_officer dmo ON dr.District = dmo.Region_Assigned
                WHERE dr.Report_Status = 'LAO Approved' AND dmo.User_ID = ?";
            $stmt1 = mysqli_prepare($con, $q1);
            mysqli_stmt_bind_param($stmt1, "i", $DMOUserID);
            mysqli_stmt_execute($stmt1);
            $stats['pending_verify_count'] = (int) mysqli_stmt_get_result($stmt1)->fetch_assoc()['cnt'];
            mysqli_stmt_close($stmt1);

            $q2 = "SELECT COUNT(*) AS cnt FROM disaster_report dr
                INNER JOIN disaster_management_officer dmo ON dr.District = dmo.Region_Assigned
                WHERE dr.Report_Status = 'DMO Approved' AND dmo.User_ID = ?";
            $stmt2 = mysqli_prepare($con, $q2);
            mysqli_stmt_bind_param($stmt2, "i", $DMOUserID);
            mysqli_stmt_execute($stmt2);
            $stats['approved_count'] = (int) mysqli_stmt_get_result($stmt2)->fetch_assoc()['cnt'];
            mysqli_stmt_close($stmt2);

            $q3 = "SELECT COUNT(*) AS cnt FROM disaster_report dr
                INNER JOIN disaster_management_officer dmo ON dr.District = dmo.Region_Assigned
                WHERE dr.Report_Status = 'DMO Rejected' AND dmo.User_ID = ?";
            $stmt3 = mysqli_prepare($con, $q3);
            mysqli_stmt_bind_param($stmt3, "i", $DMOUserID);
            mysqli_stmt_execute($stmt3);
            $stats['rejected_count'] = (int) mysqli_stmt_get_result($stmt3)->fetch_assoc()['cnt'];
            mysqli_stmt_close($stmt3);

            $q4 = "SELECT COALESCE(SUM(Estimated_Amount),0) AS total FROM verification_report
                WHERE Created_By_Officer_User_ID = ? AND Report_Status = 'Verified'";
            $stmt4 = mysqli_prepare($con, $q4);
            mysqli_stmt_bind_param($stmt4, "i", $DMOUserID);
            mysqli_stmt_execute($stmt4);
            $stats['total_approved_amount'] = (float) mysqli_stmt_get_result($stmt4)->fetch_assoc()['total'];
            mysqli_stmt_close($stmt4);

            $q5 = "SELECT DATE_FORMAT(Verification_Date, '%Y-%m') AS ym, COUNT(*) AS cnt
                FROM verification_report
                WHERE Created_By_Officer_User_ID = ? AND Report_Status = 'Verified'
                AND Verification_Date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY ym ORDER BY ym ASC";
            $stmt5 = mysqli_prepare($con, $q5);
            mysqli_stmt_bind_param($stmt5, "i", $DMOUserID);
            mysqli_stmt_execute($stmt5);
            $res5 = mysqli_stmt_get_result($stmt5);
            $monthly = [];
            while ($r = mysqli_fetch_assoc($res5)) { $monthly[] = $r; }
            $stats['monthly'] = $monthly;
            mysqli_stmt_close($stmt5);

            $q6 = "SELECT Report_ID, Report_Status, Verification_Date FROM verification_report
                WHERE Created_By_Officer_User_ID = ?
                ORDER BY Verification_Date DESC LIMIT 5";
            $stmt6 = mysqli_prepare($con, $q6);
            mysqli_stmt_bind_param($stmt6, "i", $DMOUserID);
            mysqli_stmt_execute($stmt6);
            $res6 = mysqli_stmt_get_result($stmt6);
            $recent = [];
            while ($r = mysqli_fetch_assoc($res6)) { $recent[] = $r; }
            $stats['recent'] = $recent;
            mysqli_stmt_close($stmt6);

            return $stats;
        }
        catch (Exception $e)
        {
            throw new Exception("Failed to load dashboard stats: " . $e->getMessage());
        }
    }


}

?>
