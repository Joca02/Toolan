<?php
require_once "database.php";
$dbc=createConnection();
    try{
        $query = "DELETE FROM bans WHERE date_end <= CURDATE()";
        $result=mysqli_query($dbc,$query);
        if(!$result)
        {
            error_log(mysqli_error($dbc));
        }

    }catch(Exception $e)
    {
        error_log($e);
    }finally{
        closeConnection($dbc);
    }



?>