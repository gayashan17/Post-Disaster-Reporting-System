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






    ///// Insert to Disaster Report Table
    public function insertReport($con)
    {
        try
        {
            $query = "INSERT INTO disaster_report
            (User_ID,Disaster_Type_ID,Report_Type,District,Street_Address,Description)
            VALUES (?,?,?,?,?,?)";

            $stmt = mysqli_prepare($con,$query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "iissss",
                $this->userId,
                $this->disasterTypeId,
                $this->reportType,
                $this->district,
                $this->streetAddress,
                $this->description
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
}

// ================================================================//
//                        PropertyDamage CLASS                     //
// ================================================================//

class PropertyDamage extends DisasterReport
{
    private $propertyType;
    private $damageLevel;
    private $damageDescription;
    private $estimatedCost;
    private $latitude;
    private $longitude;
    
    ////setters
    
    public function setPropertyType($propertyType)
        {$this->propertyType = $propertyType;}
    public function setDamageLevel($damageLevel)
        {$this->damageLevel = $damageLevel;}
    public function setDamageDescription($damageDescription)
        {$this->damageDescription = $damageDescription;}
    public function setEstimatedCost($estimatedCost)
        {$this->estimatedCost = $estimatedCost;}
    public function setLatitude($latitude)
        {$this->latitude = $latitude;}
    public function setLongitude($longitude)
        {$this->longitude = $longitude;}


    ///// Insert to Property Damage Table

    public function insertPropertyDamage($con, $reportId)
    {
        $query = "INSERT INTO property_damage
        (
            Report_ID,
            Property_Type,
            Damage_Level,
            Damage_Description,
            Estimated_Cost,
            Latitude,
            Longitude
        )
        VALUES (?,?,?,?,?,?,?)";

        $stmt = mysqli_prepare($con,$query);

        mysqli_stmt_bind_param(
            $stmt,
            "issssdd",
            $reportId,
            $this->propertyType,
            $this->damageLevel,
            $this->damageDescription,
            $this->estimatedCost,
            $this->latitude,
            $this->longitude
        );

        return mysqli_stmt_execute($stmt);
    }
}

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
}

?>