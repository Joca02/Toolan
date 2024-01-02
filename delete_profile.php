<?php
session_start();
require_once "database.php";
if($_SERVER["REQUEST_METHOD"]=="GET")
{
    header('Content-Type: application/json');
    $dbc=createConnection();
    try
    {
        $query="DELETE FROM users WHERE id_user=".$_GET['id'];
        $result = mysqli_query($dbc, $query);

    if ($result) {
        echo json_encode("success");
        session_destroy();
    } else {
        echo json_encode("failure");
    }
    }
    catch (Exception $e){
        error_log($e);
        echo json_encode("failure");
    }
    finally{
        closeConnection($dbc);
    }
}

?>