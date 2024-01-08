<?php
require_once "classes.php";
require_once "database.php";
header('Content-Type: application/json');

if(isset($_GET['postID']))
{
    $dbc=createConnection();
    $postID=$_GET['postID'];
    try{
        $query="SELECT id_user FROM likes WHERE id_post=$postID";
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
}
else error_log("Couldt pass postID to get_likers.php");

?>