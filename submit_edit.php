<?php
require_once "classes.php";
require_once "database.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$currentUser=$_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header('Content-Type: application/json');
    $newName = $_POST["editName"];
    $newDescription = $_POST["editDescription"];

    //provera fajla
    if (!$_FILES['editProfilePicture']['error'])
    {   
        //error_log($_FILES['editProfilePicture']['name']);
        $allowedTypes=array('jpg', 'jpeg', 'png','JPG');
        $tmp=explode('.',$_FILES['editProfilePicture']['name']);
        $fileExtension=$tmp[count($tmp)-1];
        $maxFileSize=10 * 1024 * 1024;//10MB
        if(in_array($fileExtension,$allowedTypes)&&$_FILES['editProfilePicture']['size'] < $maxFileSize)
        {
            $fileName="uploads/profile_pictures/".$currentUser->id_user.".".$fileExtension;
            if (move_uploaded_file($_FILES['editProfilePicture']['tmp_name'], $fileName))
            {
                $dbc = createConnection();
                $query = "UPDATE users SET name = '$newName', prof_description = '$newDescription', profile_picture='$fileName'WHERE id_user = $currentUser->id_user";
                try{
                    $result=mysqli_query($dbc, $query);
                    if($result)
                    {
                        echo json_encode("success");
                    }
                    else
                        echo json_encode("failure");
                    
                    
                }
                catch(Exception $e)
                {
                    error_log("Exception caught in query ".$e);
                }
                finally{
                    closeConnection($dbc);
                }
            }
            else { echo json_encode("file_failure");
                error_log("failed to upload file");
            }
        }
        else{
            echo json_encode("file_failure");
            error_log("file wrong format");
        }  

    
    }
    else
    {
        $dbc = createConnection();
                $query = "UPDATE users SET name = '$newName', prof_description = '$newDescription' WHERE id_user = $currentUser->id_user";
                try{
                    $result=mysqli_query($dbc, $query);
                    if($result)
                    {
                        if(mysqli_affected_rows($dbc)==1)
                            echo json_encode("success");
                        else
                            echo json_encode("failure");
                    }
                    
                    
                }
                catch(Exception $e)
                {
                    error_log("Exception caught in query ".$e);
                }
                finally{
                    closeConnection($dbc);
                }
    }
    



   
}

?>