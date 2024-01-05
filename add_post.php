<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');

$currentUser=$_SESSION['user'];

//upisuje post u bazu
if(isset($_GET['post_description']) && !isset($_GET['picture']))
{
    $dbc=createConnection();
    $description=$_GET['post_description'];
    try{
        $query="INSERT INTO posts (id_user,post_description) VALUES ($currentUser->id_user, '$description')";
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            echo json_encode("success");
        }
        else
        {
            echo json_encode("fail");
            error_log(mysqli_error($dbc));
        }

    }catch(Exception $e)
    {
        error_log($e);
    }
    finally{
        closeConnection($dbc);
    }
}



?>