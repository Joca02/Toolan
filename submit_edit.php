<?php
require_once "classes.php";
require_once "database.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$currentUser=$_SESSION['user']; //NE APDEJTUJE

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header('Content-Type: application/json');
    $newName = $_POST["name"];
    $newDescription = $_POST["description"];
    $dbc = createConnection();
    $query = "UPDATE users SET name = '$newName', prof_description = '$newDescription' WHERE id_user = $currentUser->id_user";
    try{
        $result=mysqli_query($dbc, $query);
        if($result)
        {
            //error_log(mysqli_affected_rows($dbc)); 
            if(mysqli_affected_rows($dbc)==1)
                echo json_encode("success");
            else
                echo json_encode("failure");
        }
        
        
    }
    catch(Exception $e)
    {
        error_log("Exception caught in querry ".$e);
    }
    finally{
        closeConnection($dbc);
    }
}

?>