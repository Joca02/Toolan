<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');





if(isset($_POST['pageID'])&&isset($_POST['postsLimit'])&&isset($_POST['offset']))
{
    //treba mi provera ako je currUserID==pageID da mogu da deletujem

    $dbc=createConnection();
    $userID=$_POST['pageID'];
    $limit=$_POST['postsLimit'];
    $offset=$_POST['offset'];
    $query;
    $isUserOwner=false;
    
    if(isset($_SESSION['user']))
    {
        $currentUser=$_SESSION['user'];
        if($userID==$currentUser->id_user)
            $isUserOwner=true;   
    }
   
    if($userID==0)//postovi na home stranici
    {
        $query = "SELECT posts.id_post, users.profile_picture, users.username, posts.post_description, following.id_followed_user, posts.date,posts.picture
        FROM users
        JOIN posts ON users.id_user = posts.id_user
        JOIN following ON following.id_followed_user = users.id_user
        WHERE following.id_follower = $currentUser->id_user
        ORDER BY posts.id_post DESC LIMIT $limit OFFSET $offset";
    }
    else if($userID==0.123)//svi postovi koje vidi samo admin
    {
        $query="SELECT posts.id_post, users.profile_picture, users.username, posts.post_description, users.id_user, posts.date,posts.picture
        FROM users
        JOIN posts ON users.id_user = posts.id_user
        ORDER BY posts.id_post DESC LIMIT $limit OFFSET $offset";
    }
    else
    {
        $user=findUserById($userID);
        $query="SELECT * FROM posts WHERE id_user=$userID ORDER BY id_post DESC LIMIT $limit OFFSET $offset";
    }
    
    try{
       
        $result=mysqli_query($dbc,$query);
        if($result)
        {
            $id_posts=array();
            $profile_pictures=array();
            $usernames=array();
            $post_descriptions=array();
            $dates=array();
            $pictures=array();
            $id_users=array();
            while($row=mysqli_fetch_assoc($result))
            {
                if($userID==0)  //ako je home page
                    $user=findUserById($row['id_followed_user']);
                else if($userID==0.123)
                    $user=findUserById($row['id_user']);
                $id_posts[]=$row['id_post'];
                $profile_pictures[]=$user->profile_picture;
                $usernames[]=$user->username;
                $post_descriptions[]=$row['post_description'];
                $dates[]=$row['date'];
                $pictures[]=$row['picture'];
                $id_users[]=$user->id_user;
                
            }
 
            $response=array(
                "id_posts"=>$id_posts,
                "profile_pictures"=>$profile_pictures,
                "usernames"=>$usernames,
                "post_descriptions"=>$post_descriptions,
                "dates"=>$dates,
                "pictures"=>$pictures,
                "isUserOwner"=>$isUserOwner,
                "id_users"=>$id_users
            );
            
            echo json_encode($response);
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