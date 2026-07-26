<?php
    require_once 'LocalAuthorityOfficer.php';
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

    public static function createCitizenNotification(mysqli $con,int $userId,int $reportId,string $title,string $message,string $type)
    {
        try
        {
            $query="INSERT INTO notification(User_ID,Report_ID,Notification_Title,Notification_Message,Notification_Type) VALUES(?,?,?,?,?)";

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
            throw new Exception(
                "Unable to Insert Citizen notification into Notification table: " .
                $e->getMessage()
            );
        }
    }

    public static function loadNotification($con,$userID)
    {
        try
        {
            $query = "SELECT
                          n.Notification_ID,
                          n.Report_ID,
                          n.Notification_Title,
                          n.Notification_Message,
                          n.Created_At,
                          dr.Report_Status
                      FROM notification n
                      JOIN disaster_report dr ON n.Report_ID = dr.Report_ID
                      WHERE n.Is_Read = 0
                        AND n.User_ID = ?
                      ORDER BY n.Notification_ID DESC;";

            $stmt = mysqli_prepare($con,$query);
            mysqli_stmt_bind_param($stmt,"i",$userID);
            mysqli_stmt_execute($stmt);

            $Result = mysqli_stmt_get_result($stmt);
            return $Result;
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Unable to Insert LAO notification into Notification table: " .
                $e->getMessage()
            );
        }
    }

    public static function isReadNotification($con, array $NotificationIDs)
    {
        if (empty($NotificationIDs)) {
            return true;
        }

        try
        {
            $query = "UPDATE notification SET Is_Read = 1 WHERE Notification_ID = ?";
            $stmt = mysqli_prepare($con, $query);

            foreach ($NotificationIDs as $NotificationID)
            {
                if ($NotificationID !== null)
                {
                    mysqli_stmt_bind_param($stmt, "i", $NotificationID);
                    mysqli_stmt_execute($stmt);
                }
            }

            mysqli_stmt_close($stmt);
            return true;
        }
        catch (Exception $e)
        {
            throw new Exception("Unable to mark notifications as read: " . $e->getMessage());
        }
    }

    public static function getNotificationCount($con,$userID)
    {
        try
        {
            $query = "SELECT COUNT(Notification_ID) AS Total FROM notification WHERE Is_Read = 0 AND User_ID = ?";

            $stmt = mysqli_prepare($con,$query);
            mysqli_stmt_bind_param($stmt,"i",$userID);
            mysqli_stmt_execute($stmt);

            $Result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($Result))
            {
                $Total = $row['Total'];
            }
            else
            {
                $Total = 1;
            }
            return $Total;
        }
        catch(Exception $e)
        {
            throw new Exception(
                "Unable to Insert LAO notification into Notification table: " .
                $e->getMessage()
            );
        }
    }





}














?>