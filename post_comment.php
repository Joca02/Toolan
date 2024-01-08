<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');

$currentUser=$_SESSION['user'];

if(isset($_POST['postID'])&&isset($_POST['comment']))
{
    $dbc=createConnection();
    $postID=$_POST['postID'];
    $comment=$_POST['comment'];
    $userID=$currentUser->id_user;
    try{
        $query="INSERT INTO comments (id_user, id_post, comment) VALUES ($userID, $postID, '$comment')";
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
else
error_log("failed to send data to post_comments.php");


?>