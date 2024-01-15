<?php
require_once "database.php";
header('Content-Type: application/json');

if(isset($_POST['name'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['gender']))
{
    $dbc=createConnection();
    $name=$_POST['name'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $gender=$_POST['gender'];

    $query="SELECT * FROM users WHERE username='$username'";
    $res=mysqli_query($dbc,$query);
    if($res)
    {
        if(mysqli_num_rows($res)>0)
        {
            echo json_encode("username taken");
        }
        else
        {
            $insertQuery="INSERT INTO users (name,username,password,gender) VALUES ('$name','$username','$password','$gender')";
            $res=mysqli_query($dbc,$insertQuery);
            if($res)
            {
                // header("Location: redirected.php");
                echo json_encode("success");
            }
            else error_log("Bad querry ".mysqli_error($dbc));

        }
    }
    else error_log("Bad querry ".mysqli_error($dbc));

    
    closeConnection($dbc);
}



?>