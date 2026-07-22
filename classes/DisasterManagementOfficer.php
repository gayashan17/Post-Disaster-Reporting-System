<?php

// ================================================================//
//               DisasterManagementOfficer CLASS                   //
// ================================================================//

class DisasterManagementOfficer extends User
{
    private $managementOfficerID;
    private $department;
    private $regionAssigned;

    //// Setters

    public function setManagementOfficerID($managementOfficerID)
    {
        $this->managementOfficerID = $managementOfficerID;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function setRegionAssigned($regionAssigned)
    {
        $this->regionAssigned = $regionAssigned;
    }

    //// Getters

    public function getManagementOfficerID()
    {
        return $this->managementOfficerID;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getRegionAssigned()
    {
        return $this->regionAssigned;
    }

    /////// Inset intom Disaster management officer

    public function addDisasterManagementOfficer($con)
    {
        try
        {
            $query = "INSERT INTO disaster_management_officer
                    (User_ID, Management_Officer_ID, Department, Region_Assigned)
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
                $this->managementOfficerID,
                $this->department,
                $this->regionAssigned
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Disaster Management Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Disaster Management Officer registration failed: " . $e->getMessage());
        }
    }
}

?>