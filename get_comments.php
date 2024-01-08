<?php
require_once "classes.php";
require_once "database.php";
header('Content-Type: application/json');

if(isset($_GET['postID']))
{
    $dbc=createConnection();
    $postID=$_GET['postID'];
    try{
        $query="SELECT id_user, comment FROM comments WHERE id_post=$postID ORDER BY id_comment DESC";  //najnoviji komentari na vrhu
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            $users=array();
            $comments=array();
            while($row=mysqli_fetch_assoc($result))
            {
                $id_user=$row['id_user'];
                $users[]=findUserById($id_user);
                $comment=$row['comment'];
                $comments[]=$comment;
            }
            $response=array(
                "users"=>$users,
                "comments"=>$comments
            );
            echo json_encode($response);
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
else error_log("Couldt pass postID to get_comments.php");


?>