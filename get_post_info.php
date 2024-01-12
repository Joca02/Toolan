<?php
require_once "classes.php";
require_once "database.php";

session_start(); 
    
header('Content-Type: application/json');
if(isset($_SESSION['user']))
    $currentUser=$_SESSION['user'];

function isPostLiked($dbc,$postID)
{
    global $currentUser;
    $query="SELECT * FROM likes WHERE id_user=$currentUser->id_user AND id_post=$postID";
    $result=mysqli_query($dbc,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==0)//post nije lajkovan
            return false;
        return true;
    }
    else error_log(mysqli_error($dbc));

}

function postLikesCount($dbc,$postID)
{
    $query = "SELECT COUNT(*) AS likesCount FROM likes WHERE id_post=$postID";
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_assoc($result);
    $likesCount = $row['likesCount'];
    return $likesCount;
}//dodati postCommentCount

function postCommentsCount($dbc,$postID)
{
    $query="SELECT COUNT(*) AS commentsCount FROM comments WHERE id_post=$postID";
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_assoc($result);
    $commentsCount=$row['commentsCount'];
    return $commentsCount;
}

if(isset($_POST['postID']))
{
    $dbc=createConnection();
    $postID=$_POST['postID'];
    try{
        $isLiked=false;
        if(isset($currentUser))
            $isLiked=isPostLiked($dbc,$postID);
        $likesCount=postLikesCount($dbc,$postID);
        $commentsCount=postCommentsCount($dbc,$postID);
        $response=array(
            "isLiked"=>$isLiked,
            "likesCount"=>$likesCount,
            "commentsCount"=>$commentsCount
        );
        echo json_encode($response);
    }catch(Exception $e)
    {
        error_log($e);
    }
    finally{
        closeConnection($dbc);
    }
}
else error_log("Error passing postID to get_post_info.php");


?>