<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');

$dbc=createConnection();
    try{
        $query="SELECT id_user
        FROM users 
        WHERE id_user IN (SELECT id_user FROM bans)";
        $result=mysqli_query($dbc,$query);
        $users=array();
        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
              $id_user=$row['id_user'];
              $users[]=findUserById($id_user);
            } 
            echo json_encode($users);
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

?>