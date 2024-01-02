<?php
require_once "classes.php";
session_start();
header('Content-Type: application/json');
if(isset($_POST['username'])&&isset($_POST['password']))
{
    error_log($_POST['username']." ".$_POST['password']);
    $user=User::isSuccessfullLogin($_POST['username'],$_POST['password']);
    
    if ($user instanceof User)
    {
        $_SESSION['user']=$user;
        echo json_encode("success");
        exit();
    }
    else
    {
        echo json_encode("fail");
        session_destroy();
    }
        
}

?>