<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');
$currentUser=$_SESSION['user']; 
if(isset($_GET['followed']))
{
    $query="SELECT * FROM following WHERE id_followed_user=".$_GET['followed']." AND id_follower=$currentUser->id_user";

    $dbc=createConnection();
    try
    {
        $res=mysqli_query($dbc,$query);
        if($res)
        {
            if(mysqli_num_rows($res)==1)
                echo json_encode("FOLLOWING");
            else
            {
                $query="SELECT * FROM following WHERE id_follower=".$_GET['followed']." AND id_followed_user=$currentUser->id_user";
                $res=mysqli_query($dbc,$query);
                if(mysqli_num_rows($res)==1)
                    echo json_encode("FOLLOWING ME");
                else echo json_encode("NOT FOLLOWING");  
            }
                
        }
        else
            error_log(mysqli_error($dbc));

    }
    catch (Exception $e){
        error_log($e);
    }finally{
        closeConnection($dbc);
    }
    exit();
}


if(isset($_POST['followed']))
{
    $query="SELECT * FROM following WHERE id_followed_user=".$_POST['followed']." AND id_follower=$currentUser->id_user";

    $dbc=createConnection();
    try
    {
        $res=mysqli_query($dbc,$query);
        if($res)
        {
            $query;
            if(mysqli_num_rows($res)==1)
            {
                $query="DELETE FROM following WHERE id_followed_user=".$_POST['followed']." AND id_follower=$currentUser->id_user";
            }
            else
            {
                $query="INSERT INTO following (id_followed_user, id_follower) VALUES (".$_POST['followed'].",$currentUser->id_user)";
 
            }
            $res=mysqli_query($dbc,$query);
                if(!$res)
                    error_log(mysqli_error($dbc));
                else
                    echo json_encode("success");
                
        }
        else
            error_log(mysqli_error($dbc));

    }
    catch (Exception $e){
        error_log($e);
    }finally{
        closeConnection($dbc);
    }
    exit();
}



?>