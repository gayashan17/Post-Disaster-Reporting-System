<?php
class Notification
{

    public static function createNotification(mysqli $con,int $userId,int $reportId,string $title,string $message,string $type)
    {
        try
        {
            $query="INSERT INTO notification(User_ID,Report_ID,Title,Message,Notification_Type) VALUES(?,?,?,?,?)";

            $stmt = mysqli_prepare($con,$query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt,"iisss",$userId,$reportId,$title,$message,$type);

            return mysqli_stmt_execute($stmt);
        }
        catch(Exception $e)
        {
            throw $e;
            return false;
        }
    }

    public function loadNotification()
    {




    }



}














?>