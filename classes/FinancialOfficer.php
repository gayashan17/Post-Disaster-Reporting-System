<?php
require_once 'User.php';
// ================================================================//
//                    FinancialOfficer CLASS                       //
// ================================================================//

class FinancialOfficer extends User
{
    private $financialOfficerID;
    private $department;
    private $bankName;
    private $bankAccountNo;

    //// Setters

    public function setFinancialOfficerID($financialOfficerID)
    {
        $this->financialOfficerID = $financialOfficerID;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    public function setBankAccountNo($bankAccountNo)
    {
        $this->bankAccountNo = $bankAccountNo;
    }

    //// Getters

    public function getFinancialOfficerID()
    {
        return $this->financialOfficerID;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getBankName()
    {
        return $this->bankName;
    }

    public function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    ///// insert into fianacila officer table

    public function addFinancialOfficer($con)
    {
        try
        {
            $query = "INSERT INTO financial_officer
                    (User_ID, Financial_Officer_ID, Department, Bank_Name, Bank_Account_No)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "issss",
                $this->userID,
                $this->financialOfficerID,
                $this->department,
                $this->bankName,
                $this->bankAccountNo
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Financial Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Financial Officer registration failed: " . $e->getMessage());
        }
    }


    // ================================================================
    //        GET ALL DS APPROVED REPORTS FOR FINANCIAL OFFICER
    // ================================================================

    public function getDSApprovedReports($con)
    {
        try
        {
            $query = "SELECT
                        dr.Report_ID,
                        dr.District,
                        ds.Office_Name,
                        vr.Estimated_Amount,
                        c.Beneficiary_Bank_Account_No AS Bank_Account_No

                    FROM disaster_report dr

                    INNER JOIN verification_report vr
                        ON dr.Report_ID = vr.Report_ID

                    INNER JOIN district_secretary ds
                        ON vr.Created_By_Officer_User_ID = ds.User_ID

                    INNER JOIN citizen c
                        ON dr.User_ID = c.User_ID

                    WHERE dr.Report_Status = 'DS Approved'
                    AND vr.Report_Status = 'Verified'

                    ORDER BY dr.Report_ID DESC";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to retrieve DS Approved reports.");
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
                "Failed to load DS Approved reports: " . $e->getMessage()
            );
        }
    }


    // ================================================================
    //        GET FULL APPROVED REPORT DETAILS
    // ================================================================

    public function getDSApprovedReportDetails($con, $Report_ID)
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
                        AND vr.Report_Status = 'Verified'

                    INNER JOIN users vu
                        ON vr.Created_By_Officer_User_ID = vu.User_ID
                        AND vu.Role_ID = 5

                    WHERE dr.Report_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $Report_ID
            );

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception(
                    "Failed to retrieve report details."
                );
            }

            $result = mysqli_stmt_get_result($stmt);

            $report = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            if(!$report)
            {
                throw new Exception(
                    "Report not found."
                );
            }

            return $report;
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Failed to load report details: " . $e->getMessage()
            );
        }
    }

    // ================================================================
    //        Add Compensation Report DETAILS
    // ================================================================

    public function addCompensationReport(
        $con,
        $reportID,
        $financialOfficerUserID
    )
    {
        try
        {
            $query = "
                INSERT INTO compensation_report
                (
                    Report_ID,
                    Financial_Officer_User_ID,
                    Estimate_Amount,
                    Approved_Amount,
                    Paid_Amount,
                    Description,
                    Receipt_File_Path,
                    Payment_Status,
                    Payment_Date,
                    Created_Date
                )
                SELECT
                    ?,
                    ?,

                    (
                        SELECT vr.Estimated_Amount
                        FROM verification_report vr
                        INNER JOIN users u
                            ON u.User_ID = vr.Created_By_Officer_User_ID
                        WHERE vr.Report_ID = ?
                        AND vr.Report_Status = 'Verified'
                        AND u.Role_ID = 2
                        LIMIT 1
                    ),

                    (
                        SELECT vr.Estimated_Amount
                        FROM verification_report vr
                        INNER JOIN users u
                            ON u.User_ID = vr.Created_By_Officer_User_ID
                        WHERE vr.Report_ID = ?
                        AND vr.Report_Status = 'Verified'
                        AND u.Role_ID = 5
                        LIMIT 1
                    ),

                    NULL,
                    NULL,
                    NULL,
                    'Processing',
                    NULL,
                    NOW()
            ";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "iiii",
                $reportID,
                $financialOfficerUserID,
                $reportID,
                $reportID
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to create compensation report.");
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Compensation report creation failed: "
                . $e->getMessage()
            );
        }
    }

    // ================================================================
    //        Update Report_Status To FO Pending in Disaster_Report
    // ================================================================
    public function updateReportStatusToFOPending($con, $reportID)
    {
        try
        {
            $query = "UPDATE disaster_report
                    SET Report_Status = 'FO Pending'
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
    //        GET ALL FO Pending Reports FOR FINANCIAL OFFICER
    // ================================================================

    public function getFOPendingReports($con, $financialOfficerUserID)
    {
        try
        {
            $query = "SELECT
                        cr.Compensation_ID,
                        dr.Report_ID,
                        dr.District,
                        dr.DS_ID,
                        ds.DS_Name,
                        cr.Estimate_Amount,
                        cr.Approved_Amount,
                        cu.Beneficiary_Bank_Account_No
                    FROM compensation_report cr

                    INNER JOIN disaster_report dr
                        ON cr.Report_ID = dr.Report_ID

                    LEFT JOIN divisional_secretariat ds
                        ON dr.DS_ID = ds.DS_ID

                    INNER JOIN citizen cu
                        ON dr.User_ID = cu.User_ID

                    WHERE cr.Financial_Officer_User_ID = ?
                    AND dr.Report_Status = 'FO Pending'

                    ORDER BY dr.Report_ID DESC";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception('Failed to prepare statement.');
            }

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $financialOfficerUserID
            );

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception(
                    'Failed to retrieve FO Pending reports.'
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
                "Failed to load FO Pending reports: "
                . $e->getMessage()
            );
        }
    }

    // ================================================================
    //        Update Compensation Reports FOR FINANCIAL OFFICER
    // ================================================================

    public function markAsPaid(
        $con,
        $compensationID,
        $paidAmount,
        $description,
        $receiptFilePath
    )
    {
        try
        {
            $query = "UPDATE compensation_report
                    SET
                        Paid_Amount = ?,
                        Description = ?,
                        Receipt_File_Path = ?,
                        Payment_Status = 'Paid',
                        Payment_Date = NOW()
                    WHERE Compensation_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception(
                    'Failed to prepare statement.'
                );
            }

            mysqli_stmt_bind_param(
                $stmt,
                'dssi',
                $paidAmount,
                $description,
                $receiptFilePath,
                $compensationID
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception(
                'Failed to update compensation report.'
            );
        }
        catch(Exception $e)
        {
            throw new Exception(
                'Payment update failed: ' .
                $e->getMessage()
            );
        }
    }

    // ================================================================
    //        Update Report_Status To FO Paid in Disaster_Report
    // ================================================================
    public function updateReportStatusToFOPaid($con, $reportID)
    {
        try
        {
            $query = "UPDATE disaster_report
                    SET Report_Status = 'FO Paid'
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
    //        GET ALL Paid Compensation Reports FOR FINANCIAL OFFICER
    // ================================================================

    public function getPaidCompensationReports($con, $financialOfficerUserID)
    {
        try
        {
            $query = "SELECT *
                    FROM compensation_report
                    WHERE Financial_Officer_User_ID = ?
                    AND Payment_Status = 'Paid'
                    ORDER BY Compensation_ID DESC";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception('Failed to prepare statement.');
            }

            mysqli_stmt_bind_param(
                $stmt,
                'i',
                $financialOfficerUserID
            );

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception(
                    'Failed to retrieve paid compensation reports.'
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
                'Failed to load paid compensation reports: ' .
                $e->getMessage()
            );
        }
    }

    // ================================================================
    //        GET ALL Dashboard status
    // ================================================================

    public function getFODashboardStats($con, $financialOfficerUserID)
    {
        try
        {
            $stats = [];

            $r1 = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM disaster_report WHERE Report_Status = 'DS Approved'");
            $stats['ds_approved_count'] = $r1 ? (int) mysqli_fetch_assoc($r1)['cnt'] : 0;

            $q2 = "SELECT COUNT(*) AS cnt FROM compensation_report cr
                INNER JOIN disaster_report dr ON cr.Report_ID = dr.Report_ID
                WHERE cr.Financial_Officer_User_ID = ? AND dr.Report_Status = 'FO Pending'";
            $stmt2 = mysqli_prepare($con, $q2);
            mysqli_stmt_bind_param($stmt2, "i", $financialOfficerUserID);
            mysqli_stmt_execute($stmt2);
            $stats['fo_pending_count'] = (int) mysqli_stmt_get_result($stmt2)->fetch_assoc()['cnt'];
            mysqli_stmt_close($stmt2);

            $q3 = "SELECT COUNT(*) AS cnt, COALESCE(SUM(Paid_Amount),0) AS total
                FROM compensation_report
                WHERE Financial_Officer_User_ID = ? AND Payment_Status = 'Paid'";
            $stmt3 = mysqli_prepare($con, $q3);
            mysqli_stmt_bind_param($stmt3, "i", $financialOfficerUserID);
            mysqli_stmt_execute($stmt3);
            $row3 = mysqli_stmt_get_result($stmt3)->fetch_assoc();
            $stats['paid_count'] = (int) $row3['cnt'];
            $stats['total_paid_amount'] = (float) $row3['total'];
            mysqli_stmt_close($stmt3);

            $q4 = "SELECT DATE_FORMAT(Payment_Date, '%Y-%m') AS ym, COALESCE(SUM(Paid_Amount),0) AS total
                FROM compensation_report
                WHERE Financial_Officer_User_ID = ? AND Payment_Status = 'Paid'
                AND Payment_Date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY ym ORDER BY ym ASC";
            $stmt4 = mysqli_prepare($con, $q4);
            mysqli_stmt_bind_param($stmt4, "i", $financialOfficerUserID);
            mysqli_stmt_execute($stmt4);
            $res4 = mysqli_stmt_get_result($stmt4);
            $monthly = [];
            while ($r = mysqli_fetch_assoc($res4)) { $monthly[] = $r; }
            $stats['monthly'] = $monthly;
            mysqli_stmt_close($stmt4);

            $q5 = "SELECT Compensation_ID, Report_ID, Paid_Amount, Payment_Date
                FROM compensation_report
                WHERE Financial_Officer_User_ID = ? AND Payment_Status = 'Paid'
                ORDER BY Payment_Date DESC LIMIT 5";
            $stmt5 = mysqli_prepare($con, $q5);
            mysqli_stmt_bind_param($stmt5, "i", $financialOfficerUserID);
            mysqli_stmt_execute($stmt5);
            $res5 = mysqli_stmt_get_result($stmt5);
            $recent = [];
            while ($r = mysqli_fetch_assoc($res5)) { $recent[] = $r; }
            $stats['recent'] = $recent;
            mysqli_stmt_close($stmt5);

            return $stats;
        }
        catch (Exception $e)
        {
            throw new Exception("Failed to load dashboard stats: " . $e->getMessage());
        }
    }


}
?>