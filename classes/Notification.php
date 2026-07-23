<?php
    require_once '../classes/LocalAuthorityOfficer.php';
class Notification
{

    public static function createLAONotification(mysqli $con,int $DSID,int $reportId,string $title,string $message,string $type)
    {
        try
        {
            $LAOID = LocalAuthorityOfficer::getDSLAO($con,$DSID);

            $query="INSERT INTO notification(User_ID,Report_ID,Notification_Title,Notification_Message,Notification_Type) VALUES(?,?,?,?,?)";

            $stmt = mysqli_prepare($con,$query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt,"iisss",$LAOID,$reportId,$title,$message,$type);

            return mysqli_stmt_execute($stmt);
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Unable to Insert LAO notification into Notification table: " .
                $e->getMessage()
            );
        }
    }

    public function loadNotification()
    {




    }



}














?>