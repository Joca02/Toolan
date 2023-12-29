<?php       
require_once "database.php";

$dbc=createConnection();
try{
    if(isset($_GET['name']))
    {
        findNames($dbc,$_GET['name']);
    }
    else error_log("Get request not sent properly to filter_search.php");
}catch(Exception $e)
{
    error_log("Error in search name filter ".$e);
}finally{
    closeConnection($dbc);
}


?>