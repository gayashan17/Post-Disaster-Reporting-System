<?php
require_once 'User.php';

// ================================================================//
//                          Citizen CLASS                          //
// ================================================================//

class Citizen extends User
{
    private $beneficiaryName;
    private $beneficiaryBank;
    private $beneficiaryBankAccountNo;

    //// Setters

    public function setBeneficiaryName($beneficiaryName)
    {
        $this->beneficiaryName = $beneficiaryName;
    }

    public function setBeneficiaryBank($beneficiaryBank)
    {
        $this->beneficiaryBank = $beneficiaryBank;
    }

    public function setBeneficiaryBankAccountNo($beneficiaryBankAccountNo)
    {
        $this->beneficiaryBankAccountNo = $beneficiaryBankAccountNo;
    }

    //// Getters

    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
    }

    public function getBeneficiaryBank()
    {
        return $this->beneficiaryBank;
    }

    public function getBeneficiaryBankAccountNo()
    {
        return $this->beneficiaryBankAccountNo;
    }

    //// Insert userID to citizen table

    public function addCitizen($con)
    {
        try
        {
            $query = "INSERT INTO citizen (User_ID)
                    VALUES (?)";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $this->userID
            );

            return mysqli_stmt_execute($stmt);
        }
        catch(Exception $e)
        {
            throw new Exception("failed: " . $e->getMessage());
        }

    }

    //// full citizen data add

    public function addFullCitizen($con)
    {
        try
        {
            $query = "INSERT INTO citizen 
                        (User_ID, Beneficiary_Name, Beneficiary_Bank, Beneficiary_Bank_Account_No)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if (!$stmt)
            {
                throw new Exception("Failed to prepare statement: " . mysqli_error($con));
            }

            mysqli_stmt_bind_param(
                $stmt,
                "isss",
                $this->userID,
                $this->beneficiaryName,
                $this->beneficiaryBank,
                $this->beneficiaryBankAccountNo
            );

            $result = mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            return $result;
        }
        catch(Exception $e)
        {
            throw new Exception("Failed to add citizen: " . $e->getMessage());
        }
    }


    ///// Insert Users bank details to Citizen table

    public function updateBankDetails($con)
    {
        try
        {
            $query = "UPDATE citizen
                    SET Beneficiary_Name = ?,
                        Beneficiary_Bank = ?,
                        Beneficiary_Bank_Account_No = ?
                    WHERE User_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "sssi",
                $this->beneficiaryName,
                $this->beneficiaryBank,
                $this->beneficiaryBankAccountNo,
                $this->userID
            );

            return mysqli_stmt_execute($stmt);
        }
        catch(Exception $e)
        {
            throw new Exception("failed: " . $e->getMessage());
        }

    }
}

?>