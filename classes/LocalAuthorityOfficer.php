<?php

// ================================================================//
//                  LocalAuthorityOfficer CLASS                    //
// ================================================================//

class LocalAuthorityOfficer extends User
{
    private $localOfficerID;
    private $position;

    //// Setters

    public function setLocalOfficerID($localOfficerID)
    {
        $this->localOfficerID = $localOfficerID;
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

    ///// Insert into Local Authority Officer table

    public function addLocalAuthorityOfficer($con)
    {
        try
        {
            $query = "INSERT INTO local_authority_officer
                    (User_ID, Local_Officer_ID, Position)
                    VALUES (?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "iss",
                $this->userID,
                $this->localOfficerID,
                $this->position
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
}

?>