<?php
require_once 'User.php';

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


    /////////// get all users data
    
    public function getAllUsers()
    {
        try {
            include '../DBconnection.php';

            $sql = "SELECT 
                        u.User_ID,
                        u.Username,
                        u.Full_Name,
                        u.Gender,
                        u.NIC,
                        u.Email,
                        u.Phone_Number,
                        u.Address,
                        u.Role_ID,
                        u.User_Status,
                        u.Created_Date,
                        r.Role_Name
                    FROM users u
                    INNER JOIN roles r ON u.Role_ID = r.Role_ID
                    ORDER BY u.User_ID DESC";

            $result = mysqli_query($con, $sql);

            if (!$result) {
                throw new Exception("Failed to retrieve users.");
            }

            $users = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }

            return [
                "success" => true,
                "users" => $users
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        } finally {
            if (isset($con)) {
                mysqli_close($con);
            }
        }
    }


    /////////// Update user status

    public function updateUserStatus($userId, $status)
    {
        try {

            include '../DBconnection.php';

            $sql = "UPDATE users
                    SET User_Status = ?
                    WHERE User_ID = ?";

            $stmt = mysqli_prepare($con, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "si",
                $status,
                $userId
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update status.");
            }

            return [
                "success" => true,
                "message" => "Status updated successfully."
            ];

        } catch (Exception $e) {

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        } finally {

            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }

            if (isset($con)) {
                mysqli_close($con);
            }
        }
    }

        /////get one User data

    public function getUserById($userId)
    {
        try {

            include '../DBconnection.php';

            $sql = "SELECT
                        u.*,
                        r.Role_Name
                    FROM users u
                    INNER JOIN roles r
                        ON u.Role_ID = r.Role_ID
                    WHERE u.User_ID = ?";

            $stmt = mysqli_prepare($con, $sql);

            mysqli_stmt_bind_param($stmt, "i", $userId);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            $user = mysqli_fetch_assoc($result);

            $user['Profile_Pic'] =
                $this->getUserProfilePicture($userId);

            return [
                "success" => true,
                "user" => $user
            ];

        } catch (Exception $e) {

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    
}

?>