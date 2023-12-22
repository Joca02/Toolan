<?php

function createConnection()
{
    try
    {
        $dbc = @mysqli_connect("127.0.0.1", "root", "", "pva_projekat");
        if (!$dbc) {
            error_log("Connection failed: " . mysqli_connect_error());
            return false;
        }
        return $dbc;
    }
    catch(Exception $e)
    {
        error_log("There was a problem connecting to the database: " . $e->getMessage());

        return false;
    }
}

function closeConnection($dbc)
{
    if(!mysqli_close($dbc))
    {
        echo "Error closing connection";
    }
}


?>