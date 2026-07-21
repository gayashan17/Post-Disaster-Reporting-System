<?php

// ================================================================//
//                    FinancialOfficer CLASS                       //
// ================================================================//

class FinancialOfficer extends User
{
    private $financialOfficerID;
    private $department;
    private $bankName;
    private $bankAccountNo;

    //// Setters

    public function setFinancialOfficerID($financialOfficerID)
    {
        $this->financialOfficerID = $financialOfficerID;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    public function setBankAccountNo($bankAccountNo)
    {
        $this->bankAccountNo = $bankAccountNo;
    }

    //// Getters

    public function getFinancialOfficerID()
    {
        return $this->financialOfficerID;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getBankName()
    {
        return $this->bankName;
    }

    public function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    ///// insert into fianacila officer table

    public function addFinancialOfficer($con)
    {
        try
        {
            $query = "INSERT INTO financial_officer
                    (User_ID, Financial_Officer_ID, Department, Bank_Name, Bank_Account_No)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "issss",
                $this->userID,
                $this->financialOfficerID,
                $this->department,
                $this->bankName,
                $this->bankAccountNo
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Financial Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Financial Officer registration failed: " . $e->getMessage());
        }
    }

}
?>