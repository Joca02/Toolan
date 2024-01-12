<?php
require_once "classes.php";
require_once "database.php";
session_start();
header('Content-Type: application/json');

$currentUser=$_SESSION['user'];

//upisuje post u bazu
if(isset($_POST['post_description']))
{
    //provera fajla
    if (isset($_FILES['picturePost']) &&!$_FILES['picturePost']['error'])
    {   
        $description=$_POST['post_description'];
        $allowedTypes=array('jpg', 'jpeg', 'png','JPG');
        $tmp=explode('.',$_FILES['picturePost']['name']);
        $fileExtension=$tmp[count($tmp)-1];
        $maxFileSize=10 * 1024 * 1024;//10MB
        if(in_array($fileExtension,$allowedTypes)&&$_FILES['picturePost']['size'] < $maxFileSize)
        {
            $dbc = createConnection();
            $query = "SELECT MAX(id_post) + 1 AS nextPostID FROM posts";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_assoc($result);
            $nextPostID = $row['nextPostID'];
            closeConnection($dbc);
            $fileName="uploads/posts/".$nextPostID.".".$fileExtension;

            if (move_uploaded_file($_FILES['picturePost']['tmp_name'], $fileName))
            {
                $dbc = createConnection();
                $query = "INSERT INTO posts (id_user,post_description, picture) VALUES ($currentUser->id_user, '$description','$fileName')";
                try{
                    $result=mysqli_query($dbc, $query);
                    if($result)
                    {
                        echo json_encode("success");
                    }
                    else
                        echo json_encode("fail");
                    
                    
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
        else { echo json_encode("file_failure");
            error_log("failed to upload file");
        }

    }
    else    //ako nije dodat fajl
    {
        //////////////////////////////
        $dbc=createConnection();
        $description=$_POST['post_description'];
        try{
            $query="INSERT INTO posts (id_user,post_description) VALUES ($currentUser->id_user, '$description')";
            $result=mysqli_query($dbc,$query);
            if($result)
            {
                echo json_encode("success");
            }
            else
            {
                echo json_encode("fail");
                error_log(mysqli_error($dbc));
            }

        }catch(Exception $e)
        {
            error_log($e);
        }
        finally{
            closeConnection($dbc);
        }
    }

    
}



?>