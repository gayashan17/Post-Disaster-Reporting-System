<?php



// ================================================================//
//                   DistrictSecretary CLASS                       //
// ================================================================//

class DistrictSecretary extends User
{
    private $secretaryOfficerID;
    private $officeName;
    private $officeLocation;

    //// Setters

    public function setSecretaryOfficerID($secretaryOfficerID)
    {
        $this->secretaryOfficerID = $secretaryOfficerID;
    }

    public function setOfficeName($officeName)
    {
        $this->officeName = $officeName;
    }

    public function setOfficeLocation($officeLocation)
    {
        $this->officeLocation = $officeLocation;
    }

    //// Getters

    public function getSecretaryOfficerID()
    {
        return $this->secretaryOfficerID;
    }

    public function getOfficeName()
    {
        return $this->officeName;
    }

    public function getOfficeLocation()
    {
        return $this->officeLocation;
    }

    ////// Insrrt into District secretary table

    public function addDistrictSecretary($con)
    {
        try
        {
            $query = "INSERT INTO district_secretary
                    (User_ID, Secretary_Officer_ID, Office_Name, Office_Location)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "isss",
                $this->userID,
                $this->secretaryOfficerID,
                $this->officeName,
                $this->officeLocation
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert District Secretary record.");
        }
        catch(Exception $e)
        {
            throw new Exception("District Secretary registration failed: " . $e->getMessage());
        }
    }
}

?>