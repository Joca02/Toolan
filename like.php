<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');
$currentUser=$_SESSION['user'];

if(isset($_POST['postID']))
{
    $dbc=createConnection();
    $postID=$_POST['postID'];
    try
    {
        $query="SELECT * FROM likes WHERE id_user=$currentUser->id_user AND id_post=$postID";
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            if(mysqli_num_rows($result)==0)//ako post nije lajkovan
            {
                $query="INSERT INTO likes (id_user, id_post) VALUES ($currentUser->id_user, $postID)";
                $likeStatus="liked";
            }
            else
            {
                $query="DELETE FROM likes WHERE id_user=$currentUser->id_user AND id_post=$postID";
                $likeStatus="notLiked";
            }

            $result=mysqli_query($dbc,$query);
            if($result)
            {
                $query = "SELECT COUNT(*) AS likesCount FROM likes WHERE id_post=$postID";
                $result = mysqli_query($dbc, $query);
                $row = mysqli_fetch_assoc($result);
                $likesCount = $row['likesCount'];
                error_log($likesCount);
                $response = array(
                    "likeStatus" => $likeStatus,
                    "likesCount" => $likesCount
                );

                echo json_encode($response);

            }
            else error_log(mysqli_error($dbc));
        }
        else error_log(mysqli_error($dbc));

    }catch(Exception $e)
    {
        error_log($e);
    }finally{
        closeConnection($dbc);
    }


}
else error_log("Failed to fetch postID in like.php");


?>