<?php
require_once 'User.php';
// ================================================================//
//                  LocalAuthorityOfficer CLASS                    //
// ================================================================//

class LocalAuthorityOfficer extends User
{
    private $localOfficerID;
    private $position;
    private $assigned_divisional_secretariat;

    //// Setters

    public function setLocalOfficerID($localOfficerID)
    {
        $this->localOfficerID = $localOfficerID;
    }

    public function setAssigned_divisional_secretariat($assigned_divisional_secretariat)
    {
        $this->assigned_divisional_secretariat = $assigned_divisional_secretariat;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }
    //// Getters

    public function getLocalOfficerID()
    {
        return $this->localOfficerID;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getAssigned_divisional_secretariat()
    {
        return $this->assigned_divisional_secretariat;
    }
    ///// Insert into Local Authority Officer table

    public function addLocalAuthorityOfficer($con)
    {
        try
        {
            $query = "INSERT INTO local_authority_officer
                    (User_ID, Local_Officer_ID, Position, Assigned_divisional_secretariat)
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
                $this->localOfficerID,
                $this->position,
                $this->assigned_divisional_secretariat
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Local Authority Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Local Authority Officer registration failed: " . $e->getMessage());
        }
    }

    ///////get divishionaln sectryryru
    
    public function getDivisionalSecretariats($con)
    {
        try
        {
            $result = [];

            $query = "SELECT DS_ID, District, DS_Name
                    FROM divisional_secretariat
                    ORDER BY District, DS_Name";

            $res = mysqli_query($con, $query);

            if (!$res)
            {
                throw new Exception(
                    "Failed to retrieve Divisional Secretariats: " .
                    mysqli_error($con)
                );
            }

            while ($row = mysqli_fetch_assoc($res))
            {
                $result[] = $row;
            }

            return $result;
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Error retrieving Divisional Secretariats: " .
                $e->getMessage()
            );
        }
    }


}

?>