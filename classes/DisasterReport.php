<?php
    include '../userData.php';  //user data is stored here
    include '../DBconnection.php';
// ================================================================//
//                        DisasterReport CLASS                     //
// ================================================================//

class DisasterReport
{
    protected $userId;
    protected $disasterTypeId;
    protected $district;
    protected $streetAddress;
    protected $description;
    protected $reportType;
    protected $reportCount;
    protected $DSID;

    ////setters

    public function setUserId($userId)
        {$this->userId = $userId;}
    public function setDisasterTypeId($disasterTypeId)
        {$this->disasterTypeId = $disasterTypeId;}
    public function setDistrict($district)
        {$this->district = $district;}
    public function setStreetAddress($streetAddress)
        {$this->streetAddress = $streetAddress;}
    public function setDescription($description)
        {$this->description = $description;}
    public function setReportType($reportType)
        {$this->reportType = $reportType;}
    public function setDSID($DSID)
        {$this->DSID = $DSID;}





    ///// Insert to Disaster Report Table
    public function insertReport($con)
    {
        try
        {
            $query = "INSERT INTO disaster_report
            (User_ID,Disaster_Type_ID,Report_Type,District,Street_Address,Description,DS_ID)
            VALUES (?,?,?,?,?,?,?)";

            $stmt = mysqli_prepare($con,$query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "iissssi",
                $this->userId,
                $this->disasterTypeId,
                $this->reportType,
                $this->district,
                $this->streetAddress,
                $this->description,
                $this->DSID
            );

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to execute query.");
            }

            return mysqli_insert_id($con);
        }
        catch(Exception $e)
        {
            throw $e;
            return false;
        }
    }

    //////////////// Total Reports
    public function getTotalReports($con)
    {
        try
        {
            $query = "SELECT COUNT(*) AS TotalReports FROM disaster_report";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            return (int)$row['TotalReports'];
        }
        catch(Exception $e)
        {
            throw $e;
            return false;
        }
    }


    ////////////// Monthly report count
    public function getMonthlyReportActivity($con)
    {
        try
        {
            $query = "SELECT MONTH(Report_Date) AS MonthNumber,
                            COUNT(*) AS TotalReports
                    FROM disaster_report
                    WHERE YEAR(Report_Date) = YEAR(CURDATE())
                    GROUP BY MONTH(Report_Date)
                    ORDER BY MONTH(Report_Date)";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            $monthlyData = array_fill(0, 12, 0);

            while($row = mysqli_fetch_assoc($result))
            {
                $monthIndex = $row['MonthNumber'] - 1;
                $monthlyData[$monthIndex] = (int)$row['TotalReports'];
            }

            return $monthlyData;
        }
        catch(Exception $e)
        {
            throw $e;
            return false;
        }        

    }

    public static function getDivisionalSecretariat($con,$district)
    {
        try
        {
            $query =  "SELECT DS_ID FROM divisional_secretariat WHERE DS_Name = ?";

            $stmt = mysqli_prepare($con,$query);

            mysqli_stmt_bind_param($stmt,"s",$district);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result))
            {
                $DSID = $row['DS_ID'];
                return $DSID;
            }
            else
            {
                throw new Exception ("Invalid District");
            }


        }
        catch(Exception $e)
        {
            throw $e;
            return false;
        }

    }

}

?>