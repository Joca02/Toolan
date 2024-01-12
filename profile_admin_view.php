<?php
require_once "classes.php";
require_once "database.php";
session_start();
$userProfile;
if (!isset($_SESSION['admin'])) {
 // header("Location: login.php");
  //exit();
}
$admin=$_SESSION['admin'];

if(isset($_GET['id']))
{
  if($_GET['id']==$admin->id_user)
    $userProfile=$admin;
  
    else
  {
    $profile_id=$_GET['id'];
    $dbc=createConnection();

    $query="SELECT * FROM users WHERE id_user=$profile_id";
    try{
      $result=mysqli_query($dbc,$query);
      if(mysqli_num_rows($result)==1)
      {
        $row=mysqli_fetch_assoc($result);
                  
        $userProfile=generateUser($row);
      }
      else
        error_log("Several users with same id in profile.php Error");
    }catch(Exception $e)
    {
      error_log("Exception caught in finding user id ".$e);
    }
    finally{
      closeConnection($dbc);
    }
    
  }
 
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/post.css">
    <link rel="stylesheet" href="styles/home.css">
    
    <script src="https://kit.fontawesome.com/a6397c1be2.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/home.js"></script>
<script src="js/admin.js"></script>
</head>
<body>
    

<!--NAVIGATION BAR-->
<div class="container-fluid">
  <div class="row" id="upper-panel">
    <div class="col">
      <a href="admin_home.php"><img src="uploads/toolan.png" alt="logo" id="logo"></a>
    </div>
    <div class="col-6" id="search-div">
    <input type="text" class="form-control" id="search" placeholder="Search...">
    <img src="./uploads/admin.png" alt="logoadmin" id="adminLogo">
    </div>

    <div class="usrBar col">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo "<span class='currUserName'>".$admin->name."</span>";//prikaz ulgoovanog usera
          ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
         <a class="dropdown-item" href="profile_admin_view.php?id=<?php echo $admin->id_user?>">View Profile</a>
         
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
        
          <?php
            $pfpPath=$admin->profile_picture;
            echo "<img src='$pfpPath' class='pfpNav' data-userid='$admin->id_user'>";//dodavanje profilne gore desno
          ?>
    </div>          
    </div>
  </div>
</div>


<!--PAGE-->
<div class="container-fluid text-center" id="home-container">
  <div class="row">
    <div class="col">
    </div>
    <div class="post col-7">
        <div id="suggestion-box" class="list-group"></div>
        <div class='profile-box'><br><div>
        <?php  $pfpPath=$userProfile->profile_picture;
            echo "<img src='$pfpPath' class='pfpProfile'>";?>
        </div>
  <!-- BAN MODAL -->
<div id="ban-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Ban User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="ban-expiration-date">Ban Expiration Date:</label>
                    <input type="date" id="ban-expiration-date" class="form-control">
                </div>

                <div class="form-group">
                    <label for="ban-reason">Ban Reason:</label>
                    <textarea id="ban-reason" class="form-control" rows="4" placeholder="Enter reason for the ban"></textarea>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="ban-footer modal-footer">
                <button id="submit-ban" class="btn subm-ban-btn ">Submit Ban</button>
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
    <!--USER LIKES MODAL-->
<div class="modal fade" id="windowModal" tabindex="-1" role="dialog" aria-labelledby="likesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="windowModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="windowModalBody">
                <!-- Content will be dynamically added here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--END-->
        <?php 
            echo "<p class='profileName'>$userProfile->name</p>";
            echo "<p class='profileUsername'>@$userProfile->username</p> <br>";
        ?>
        <button type="button" class="btn btn-primary" id="ban_btn"></button>
        <p id='profileDescription'></p>
    </div></div>
        
    <div class="col">
    </div>
  </div>

  <div >
  <div class="row">
    <div class="col">
    </div>
    <div class="col-6" id="post-container">
      
    </div>
    <div class="col">
    </div>
  </div>
  </div>






  <script>
   
  $(function(){
    
    var pageID='<?php echo $userProfile->id_user;?>';

    loadPostsAdmin(pageID);

    $(window).scroll(function() {
       
        if (Math.ceil($(document).height() - $(window).scrollTop()) <= $(window).height()+50) {
              loadPostsAdmin(pageID);
        }
    });
 
    
    //postavljanje boje i teksta dugmeta za ban
    function changeBanButton()
    { 
        var admin='<?php echo $admin->id_user?>';
        if(pageID!=admin)
        {
            $.get("user_ban_status.php",{userID:pageID},function(response){
            if(response=="banned")
            {
                $("#ban_btn").css("background-color", "rgb(76, 201, 93)"); // 
                $("#ban_btn").text("Unban user");
            }
            else
            {
                $("#ban_btn").css("background-color", "rgb(196, 68, 68)"); // 
                $("#ban_btn").text("Ban User");
            }
             });
        }
        else
        {
            $("#ban_btn").css("width", "400px");
            $("#ban_btn").text("No action can be performed on admin profile");
        }

       
    }
    
    changeBanButton();


    //banovanje i unbanovanje korisnika
    $(document).ready(function () {
        var submit = $("#submit-ban"); 
        submit.click(function () {
            var banDate = $("#ban-expiration-date").val();
            var selectedDate = new Date(banDate);
            var todaysDate = new Date();
            var txt = $("#ban-reason").val();
            console.log(txt.length);

            if (selectedDate > todaysDate) {
                if (txt.length > 4) {
                    console.log(banDate);
                    $.post("set_ban.php", { banDate: banDate, userID: pageID, banReason: txt },
                        function (response) {
                            if (response == "success") {
                                alert("Ban has been successfully set until " + banDate);
                                $("#ban-modal").modal("hide");
                                changeBanButton();
                            } else {
                                alert("There was an error setting the ban. Please try again later.")
                            }
                        });
                } else {
                    alert("You must enter a ban reason with a minimum of 5 characters.");
                }
            } else {
                alert("Ban expiration date must be set in the future");
            }
    });


    $("#ban_btn").click(function () {
        var admin = '<?php echo $admin->id_user ?>';
        if (pageID != admin) {
            $.get("user_ban_status.php", { userID: pageID }, function (response) {
                if (response == "banned") {
                    if (confirm("Are you sure you want to Unban this user?")) {
                        $.post("unban_user.php", { userID: pageID },
                            function (response) {
                                if (response == "success") {
                                    alert("User has been successfully unbanned.");
                                    changeBanButton();
                                } else {
                                    alert("There was a problem during your request. Please try again later.");
                                }
                            });
                    }
                } else {
                    $("#ban-modal").modal("show");
                }
            });
        }
    });
});














    

   


  


    //profile description
    var decodedDescription = decodeURIComponent("<?php echo $userProfile->prof_description?>")
    if(decodedDescription.length>0)
      $("#profileDescription").text(decodedDescription);
    else $("#profileDescription").text("No profile description");

});



</script>



</body>
</html>