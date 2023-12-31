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
                error_log("No changes have been saved");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="styles/edit_profile.css">
</head>
<body>
<div class="container">
    <br>
    <h2>Edit Profile</h2>
    <form id="editProfileForm" enctype="multipart/form-data" >
        <div class="form-group">
            <label for="editName">Edit Name:</label>
            <input type="text" class="change form-control" id="editName" name="editName" placeholder="Enter your new name">
        </div>
        <div class="form-group">
            <label for="editDescription">Add/Change Profile Description:</label>
            <textarea class="change form-control" id="editDescription" name="editDescription" rows="3" placeholder="Enter your new profile description" style="resize: none;"></textarea>
        </div>
        <div class="form-group">
            <label for="editProfilePicture">Add New Profile Picture:</label>
            <input type="file" class="form-control-file" id="editProfilePicture" name="editProfilePicture">
        </div>
        <br>
        <button type="button" class="btn btn-primary" id="submit">Submit changes</button>
    </form>

    <script>
        $(function(){
            var name=$("#editName");
            var description= $("#editDescription");
            name.val("<?php echo $currentUser->name; ?>");
            description.val("<?php 
            if(isset($currentUser->prof_description))
                echo $currentUser->prof_description; ?>")

            //provera forme
            var btn=$("#submit");
            btn.click(function(){
                var condition=true;
                if(name.val()<2)
                {
                    condition=false;
                    alert("Name must have at least 2 letters!");
               }
                    
                else if(name.val().length>15)
                {
                    condition=false;
                    alert("Name cannot have more than 15 letters!");
                }
                    
                if(description.val().length>255)
                {
                    condition=false;
                    alert("Description can have a maximum of 255 characters!");
                }

                if(condition)
                {
                    $.post("submit_edit.php", {name: name.val(),description: description.val()},
                    function(response) {              
        //                 try {
        //     var jsonResponse = JSON.parse(response);
        //     if (jsonResponse.status === "success") {
        //         alert("Changes have been saved successfully!");
        //     } else {
        //         alert("There was an error while trying to save your changes. Please try again later.");
        //     }
        // } catch (e) {
        //     console.error("Error parsing JSON response:", e);
        // }
                        if (response=="success") {
                            alert("Changes have been saved succesfully!");    
                        } else {
                            alert("There was an error while trying to save your changes. Please try again later."); 
                        }
                        });
             }
            })
        })
    </script>
</div>
</body>
</html>