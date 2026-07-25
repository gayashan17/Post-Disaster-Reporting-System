<?php
    include '../userData.php';  //user data is stored here
    include '../DBconnection.php';
    include 'DisasterReport.php';
    
// ================================================================//
//                       MissingPerson CLASS                       //
// ================================================================//

class MissingPerson extends DisasterReport
{
    private $fullName;
    private $age;
    private $gender;
    private $lastSeenLocation;
    private $lastSeenDate;
    private $lastSeenTime;
    private $relationshipToPerson;
    
        public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setLastSeenLocation($lastSeenLocation)
    {
        $this->lastSeenLocation = $lastSeenLocation;
    }

    public function setLastSeenDate($lastSeenDate)
    {
        $this->lastSeenDate = $lastSeenDate;
    }

    public function setLastSeenTime($lastSeenTime)
    {
        $this->lastSeenTime = $lastSeenTime;
    }

    public function setRelationshipToPerson($relationshipToPerson)
    {
        $this->relationshipToPerson = $relationshipToPerson;
    }
    ////// insret into missing person tab;e
    public function insertMissingPersonRecord($con, $reportId)
    {
        try
        {
            $query = "INSERT INTO missing_person_record
                    (Report_ID, Full_Name, Age, Gender,
                    Last_Seen_Location, Last_Seen_Date,
                    Last_Seen_Time, Relationship_to_Person)
                    VALUES (?,?,?,?,?,?,?,?)";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "isisssss",
                $reportId,
                $this->fullName,
                $this->age,
                $this->gender,
                $this->lastSeenLocation,
                $this->lastSeenDate,
                $this->lastSeenTime,
                $this->relationshipToPerson
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert missing person record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Missing Person Record Insert Failed: " . $e->getMessage());
        }
    }

        //Missing person Report data
        public static function getMissingPersonReport($con,$reportID)
        {
            try
            {
                $query= "SELECT Full_Name,Age,Gender,Last_Seen_Location,Last_Seen_Date,Last_Seen_Time,Status,Relationship_to_Person FROM missing_person_record WHERE Report_ID = ?";

                     $stmt = mysqli_prepare($con,$query);

                     mysqli_stmt_bind_param($stmt, "i", $reportID);

                     if(mysqli_stmt_execute($stmt))
                     {
                        $result = mysqli_stmt_get_result($stmt);
                        if ($result && mysqli_num_rows($result) > 0)
                        {
                            $row = mysqli_fetch_assoc($result);
                        }
                        else
                        {
                            $row = null;
                        }
                     }
                 return $row;
            }
            catch(Exception $e)
            {
                throw $e;
                return false;
            }
        }


}

?>