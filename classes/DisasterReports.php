<?php

class DisasterReport
{
    protected $userId;
    protected $disasterTypeId;
    protected $district;
    protected $streetAddress;
    protected $description;
    protected $reportType;

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

class PropertyDamage extends DisasterReport
{
    private $propertyType;
    private $damageLevel;
    private $damageDescription;
    private $estimatedCost;
    
    ////setters
    
    public function setPropertyType($propertyType)
        {$this->propertyType = $propertyType;}
    public function setDamageLevel($damageLevel)
        {$this->damageLevel = $damageLevel;}
    public function setDamageDescription($damageDescription)
        {$this->damageDescription = $damageDescription;}
    public function setEstimatedCost($estimatedCost)
        {$this->estimatedCost = $estimatedCost;}


    ///// Insert to Property Damage Table

    public function insertPropertyDamage($con, $reportId)
    {
        $query = "INSERT INTO property_damage
        (Report_ID,Property_Type,Damage_Level,Damage_Description,Estimated_Cost)
        VALUES (?,?,?,?,?)";

        $stmt = mysqli_prepare($con,$query);

        mysqli_stmt_bind_param(
            $stmt,
            "issss",
            $reportId,
            $this->propertyType,
            $this->damageLevel,
            $this->damageDescription,
            $this->estimatedCost
        );

        return mysqli_stmt_execute($stmt);
    }
}

class DeathRecord extends DisasterReport
{

}

class InjuredPerson extends DisasterReport
{

}

class MissingPerson extends DisasterReport
{

}

?>