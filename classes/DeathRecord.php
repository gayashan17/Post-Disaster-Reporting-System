<?php
    include '../userData.php';  //user data is stored here
    include '../DBconnection.php';

// ================================================================//
//                        DeathRecord CLASS                        //
// ================================================================//

class DeathRecord extends DisasterReport
{
    private $fullName;
    private $age;
    private $gender;
    private $causeOfDeath;

    public function setFullName($fullName)
        {$this->fullName = $fullName;}
    public function setAge($age)
        {$this->age = $age;}
    public function setGender($gender)
        {$this->gender = $gender;}
    public function setCauseOfDeath($causeOfDeath)
        {$this->causeOfDeath = $causeOfDeath;}
    
    /////// Insert in to Death_record table

    public function insertDeathRecord($con, $reportId)
    {
        try
        {
            $query = "INSERT INTO death_record
                     (Report_ID, Full_Name, Age, Gender, Cause_Of_Death)
                     VALUES (?,?,?,?,?)";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "issss",
                $reportId,
                $this->fullName,
                $this->age,
                $this->gender,
                $this->causeOfDeath
            );

            if(!mysqli_stmt_execute($stmt))
            {
                throw new Exception("Failed to insert death record.");
            }

            return true;
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
}

?>