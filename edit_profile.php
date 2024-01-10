<?php
require_once "classes.php";
require_once "database.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$currentUser=$_SESSION['user']; 


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
        <button type="button" class="btn btn-secondary" id="cancel">Cancel</button>
        <button type="button" class="btn btn-danger" id="delete">Delete Profile</button>
    </form>

    <script>
    $(function(){
        var name = $("#editName");
        var description = $("#editDescription");
        var profile_picture = $("#editProfilePicture");
        name.val("<?php echo $currentUser->name; ?>");

        //dekodujem opis profila u txtArea jer \n pravi problem
        var decodedDescription = decodeURIComponent("<?php 
            if(isset($currentUser->prof_description))
                echo $currentUser->prof_description; ?>");
        description.val(decodedDescription);

        //provera forme
        var btnSubmit = $("#submit");
        btnSubmit.click(function(){
            var condition = true;
            if(name.val().length < 2) {
                condition = false;
                alert("Name must have at least 2 letters!");
            }
            else if(name.val().length > 15) {
                condition = false;
                alert("Name cannot have more than 15 letters!");
            }
            if(description.val().length > 255) {
                condition = false;
                alert("Description can have a maximum of 255 characters!");
            }

            if(condition) {
                  //enkodujem opis profila u txtArea jer \n pravi problem
                var encodedDescription = encodeURIComponent(description.val());
                var formData = new FormData($("#editProfileForm")[0]);
        
                formData.append('editDescription', encodedDescription);
                $.ajax({
                    url: "submit_edit.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json", 
                    success: function(response) {              
                        if (response == "success") {
                            alert("Changes have been saved successfully!");
                            $.get("update_session.php", function(data) {
                                        //2. key-val pair dole zbog kesiranja brauzera                               
                                //window.location.reload();
                                window.location.href = "profile.php?id=<?php echo $currentUser->id_user;?>"; 


                                // setTimeout(function() {
                                    
                                //     window.location.reload(true);
                                // }, 100);//OVDE PROVERITI DAL JE NEOPHODNO  (NE RADI)      
                            });
                        } 
                        else if(response == "file_failure") {
                            alert("Please use a different picture format.");
                        }
                        else {
                            alert("No changes were saved."); 
                            window.location.href = "profile.php?id=<?php echo $currentUser->id_user;?>";
                        }   
                    } 
                });                      
            }
        });

        var btnCancel=$("#cancel");

        btnCancel.click(function(){
            alert("No changes were saved."); 
            window.location.href = "profile.php?id=<?php echo $currentUser->id_user;?>";
        })

        var btnDelete=$("#delete");
        btnDelete.click(function(){
            if(confirm("Are you sure you want to delete profile?Once deleted, action cannot be undone."))
            {
                var idUser = <?php echo $currentUser->id_user; ?>;

                $.get(
                    "delete_profile.php",{id:idUser},function(response)
                    {
                        if(response=="success")
                        {
                            alert("Profile has been successfully deleted. You will be redirected to Log In page.");
                            window.location.href = "login.php";
                        }
                        else
                            alert("There was an error trying to delete your profile, please try again later.");
                    }
                )
            }
        })
        
    });
</script>

</div>
</body>
</html>