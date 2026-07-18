<?php

class EvidenceFile
{
    private $File_ID;
    private $Uploaded_Date;
    private $File_Type;
    private $File_Name;
    private $File_Path;

    // Setters
    public function setFileID($File_ID)
    {
        $this->File_ID = $File_ID;
    }

    public function setUploadedDate($Uploaded_Date)
    {
        $this->Uploaded_Date = $Uploaded_Date;
    }

    public function setFileType($File_Type)
    {
        $this->File_Type = $File_Type;
    }

    public function setFileName($File_Name)
    {
        $this->File_Name = $File_Name;
    }

    public function setFilePath($File_Path)
    {
        $this->File_Path = $File_Path;
    }

    // Getters
    public function getFileID()
    {
        return $this->File_ID;
    }

    public function getUploadedDate()
    {
        return $this->Uploaded_Date;
    }

    public function getFileType()
    {
        return $this->File_Type;
    }

    public function getFileName()
    {
        return $this->File_Name;
    }

    public function getFilePath()
    {
        return $this->File_Path;
    }

    
    ///inset to evidence file and photo table and Uploads/evidence folder

    public function uploadFiles($con, $reportId, $userId)
    {
        try
        {
            $uploadDir = "../uploads/evidence/ReportID_" . $reportId . "/";

            if (!is_dir($uploadDir))
            {
                mkdir($uploadDir, 0777, true);
            }

            foreach($_FILES['report-attachments']['tmp_name'] as $key => $tmpName)
            {
                $originalName = $_FILES['report-attachments']['name'][$key];
                $this->File_Type = $_FILES['report-attachments']['type'][$key];

                $this->File_Name =
                    $userId . "_" . uniqid() . "_" . basename($originalName);

                $this->File_Path = $uploadDir . $this->File_Name;

                if(move_uploaded_file($tmpName, $this->File_Path))
                {
                    $query = "INSERT INTO evidence_file_and_photos
                    (Report_ID, File_Name, File_Type, File_Path)
                    VALUES (?,?,?,?)";

                    $stmt = mysqli_prepare($con, $query);

                    if(!$stmt)
                    {
                        throw new Exception("Failed to prepare statement.");
                    }

                    mysqli_stmt_bind_param(
                        $stmt,
                        "isss",
                        $reportId,
                        $this->File_Name,
                        $this->File_Type,
                        $this->File_Path
                    );

                    if(!mysqli_stmt_execute($stmt))
                    {
                        throw new Exception("Failed to insert evidence file.");
                    }
                }
            }

            return true;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
}

?>