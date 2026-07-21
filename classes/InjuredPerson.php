<?php
    include '../userData.php';  //user data is stored here
    include '../DBconnection.php';

// ================================================================//
//                       InjuredPerson CLASS                       //
// ================================================================//

class InjuredPerson extends DisasterReport
{
    private $fullName;
    private $age;
    private $gender;
    private $injuredLevel;

    public function setFullName($fullName)
        {$this->fullName = $fullName;}
    public function setAge($age)
        {$this->age = $age;}
    public function setGender($gender)
        {$this->gender = $gender;}
    public function setInjuredLevel($injuredLevel)
        {$this->injuredLevel = $injuredLevel;}
    
    ////// Insert into injurder record table

    public function insertInjuredPerson($con, $reportId)
    {
        try
        {
            $query = "INSERT INTO injured_person
                    (Report_ID, Full_Name, Age, Gender, Injured_Level)
                    VALUES (?,?,?,?,?)";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "isiss",
                $reportId,
                $this->fullName,
                $this->age,
                $this->gender,
                $this->injuredLevel
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert injured person record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Injured Person Record Insert Failed: " . $e->getMessage());
        }
    }
}


?>