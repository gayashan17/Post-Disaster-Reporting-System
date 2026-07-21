<?php


// ================================================================//
//                          Admin CLASS                            //
// ================================================================//

class Admin extends User
{
    private $adminRole;

    //// Setters

    public function setAdminRole($adminRole)
    {
        $this->adminRole = $adminRole;
    }

    //// Getters

    public function getAdminRole()
    {
        return $this->adminRole;
    }

    ////// Insert Admin table

    public function addAdmin($con)
    {
        try
        {
            $query = "INSERT INTO admin (User_ID, Admin_Role)
                    VALUES (?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "is",
                $this->userID,
                $this->adminRole
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert admin record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Admin registration failed: " . $e->getMessage());
        }
    }
}

?>