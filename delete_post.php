<?php
require_once "database.php";
header('Content-Type: application/json');

if(isset($_POST['postID']))
{
    $dbc=createConnection();
    $postID=$_POST['postID'];
    try{
        $query="DELETE FROM posts WHERE id_post=$postID";
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
    }finally{
        closeConnection($dbc);
    }
}
else 
{
    echo json_encode("fail");
    error_log('Error passing postID to delete_post.php');
}


?>