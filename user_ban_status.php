<?php
require_once "database.php";
header('Content-Type: application/json');

if(isset($_GET['userID']))
{
    $dbc=createConnection();
    $userID=$_GET['userID'];
    try{
        $query="SELECT * FROM bans WHERE id_user=$userID";
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            if(mysqli_num_rows($result)==0)
            {
                echo json_encode("not banned");
            }
            else
            {
                $row=mysqli_fetch_assoc($result);
                $date_end=$row['date_end'];
                $currentDate = date("Y-m-d");

                $todaysTimestamp=strtotime($currentDate);
                $banTimestamp=strtotime($date_end);
                        
                if($todaysTimestamp>=$banTimestamp)
                {
                    $query="DELETE FROM bans WHERE id_user=$userID";
                    mysqli_query($dbc,$query);
                    echo json_encode("not banned");
                }
                else
                    echo json_encode("banned");
            }
        }
        else
        {
            error_log(mysqli_error($dbc));
        }

    }catch(Exception $e)
    {
        error_log($e);
    }finally{
        closeConnection($dbc);
    }
}
else error_log("There was an error passing user ID to user_ban_status.php");



?>