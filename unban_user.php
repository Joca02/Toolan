<?php
require_once "database.php";
header('Content-Type: application/json');

if(isset($_POST['userID']))
{
    $dbc=createConnection();
    $userID=$_POST['userID'];
    try{
        $query="DELETE FROM bans WHERE id_user=$userID";
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
else error_log("Error sending data to unban_user.php");



?>