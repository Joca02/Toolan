<?php
require_once "database.php";
header('Content-Type: application/json');

if(isset($_POST['banDate'])&&isset($_POST['userID'])&&isset($_POST['banReason']))
{
    $dbc=createConnection();
    $banDate=$_POST['banDate'];
    $userID=$_POST['userID'];
    $banReason=$_POST['banReason'];
    error_log($banDate);
    try{
        $query="INSERT INTO bans (id_user, date_end, ban_reason) VALUES ($userID, '$banDate', '$banReason')";
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            echo json_encode("success");
        }
        else
        {
            error_log(mysqli_error($dbc));
            echo json_encode("fail");
        }

    }catch(Exception $e)
    {
        error_log($e);
    }finally{
        closeConnection($dbc);
    }



}
else error_log("Error sending data to set_ban.php");




?>