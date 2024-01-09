
<?php
require_once "classes.php";
session_start();
$currentUser;
if(isset($_SESSION['user']))
{
  $currentUser=$_SESSION['user'];

}
else
{
  header("Location: login.php");
  exit();//TODO search input funkcionalnost
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/home.css">
  
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/home.js"></script>

</head>
<body>
<!--NAVIGATION BAR-->
<div class="container-fluid">
  <div class="row" id="upper-panel">
    <div class="col">
      <img src="uploads/toolan.png" alt="logo" id="logo">
    </div>
    <div class="col-6" id="search-div">

    <input type="text" class="form-control" id="search" placeholder="Search...">
    

    </div>
    <div class="usrBar col">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo "<span class='currUserName'>".$currentUser->name."</span>";//prikaz ulgoovanog usera
          ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="profile.php?id=<?php echo $currentUser->id_user?>">View Profile</a>
          <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
        
          <?php
            $pfpPath=$currentUser->profile_picture;
            echo "<img src='$pfpPath' class='pfpNav'>";//dodavanje profilne gore desno
          ?>   
    </div>          
    </div>
  </div>
</div>



<!--HOME PAGE-->
<div class="container-fluid text-center" id="home-container">
  <div class="row">
    <div class="col">
     
    </div>
    <div class="post col-7">
    <div id="suggestion-box" class="list-group"></div>

        <div class="quick-post row">
            <div class="col-9">
            <textarea class="form-control" placeholder="Add a quick post. What's on your mind?" rows="3" id="quick-post"></textarea>
            </div>
            <div class="btn col-3" id="btn-qpost">
                <button type="submit" class="btn btn-primary" id="confirm-post" disabled>Post</button>
            </div>
    </div>
    </div>
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
</div>



</body>
<script>
  $(function(){
    //search logika
    const suggestionBox = $("#suggestion-box");
   
    $("#search").on("input", function(){
      var characters = $(this).val();
      suggestionBox.empty();
      if(characters.length > 0) {
        $.get("filter_search.php?name=" + characters, function(response) {
          
          for (var i = 0; i < response.length; i++) {
              const name=response[i].name;

              const suggestionItem = $("<a href='profile.php?id="+response[i].id_user+"'  class='list-group-item list-group-item-action list-group-item-light'><img src='" + response[i].profile_picture + "' class='profile-picture-search'> " + response[i].name + "</a>");

              suggestionBox.append(suggestionItem);

          }
          suggestionBox.show();
        });
      }
    });

    //post logika
    const postContainer = $("#post-container");
    var txtArea=document.getElementById("quick-post")
    var subm=document.getElementById("confirm-post");
    $("#quick-post").on("input",function()
    {
      buttonEnabled(txtArea,subm);
    })
    
    $("#confirm-post").click(function(){
      var txt=$("#quick-post").val();
      $.get(
        "add_post.php",{post_description:txt},function(response){
          if(response=="success")
            {
              alert("Post has been successfully added!");
              //da bi dugme ponovo bilo disabled
              $("#quick-post").val("");
              buttonEnabled(txtArea,subm);
            }
          else
          {
            alert("There was an error adding the post, please try again later.");
          }
        }
      );
    });
});

</script>

</html>