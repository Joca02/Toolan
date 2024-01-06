<?php
require_once "classes.php";
require_once "database.php";
session_start();
$currentUser=$_SESSION['user'];

if(isset($_POST['pageID'])&&isset($_POST['postsLimit'])&&isset($_POST['offset']))
{
    //treba mi provera ako je currUserID==pageID da mogu da deletujem

    $dbc=createConnection();
    $userID=$_POST['pageID'];
    $limit=$_POST['postsLimit'];
    $offset=$_POST['offset'];
    $user=findUserById($userID);
    try{
        $query="SELECT * FROM posts WHERE id_user=$userID ORDER BY id_post DESC LIMIT $limit OFFSET $offset";
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                
                echo "<div class='the-post' id='".$row['id_post']."'>
                    <div class='post-header'>
                        <img class='pfpNav' src='$user->profile_picture'>
                        <span class='username'>$user->username</span>
                        <span class='timestamp'>".$row['date']."</span>
                    </div>
                    <div class='post-content'>
                        <p>".$row['post_description']."
                        </p>
                    </div>
                    <div class='post-footer'>
                        <div class='like-comment-icons'>
                            <i class='like fa fa-heart-o fa-2x' ></i> 
                            <i class='comment fa fa-comment-o fa-2x' ></i> 
                        </div>
                        <div class='comment-count'>
                            <span class='likesCount'></span>
                            <span class='commentsCount'>10 comments</span>
                        </div>
                    </div>
                </div>";
            }
        }
        else error_log(mysqli_error($dbc));

    }catch(Exception $e)
    {
        error_log($e);
    }
    finally{
        closeConnection($dbc);
    }
    
}
else
    error_log("Error sending post request to load_posts.php");


?>