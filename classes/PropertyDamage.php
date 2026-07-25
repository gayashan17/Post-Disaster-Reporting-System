<?php
    include '../userData.php';  //user data is stored here
    include '../DBconnection.php';


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

        //Property Damage Report data
        public static function getPropertyDamageReport($con,$reportID)
        {
            try
            {
                $query= "SELECT Property_Type,Damage_Level,Damage_Description,Estimated_Cost FROM property_damage WHERE Report_ID = ?";

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