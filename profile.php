<?php
require_once "classes.php";
require_once "database.php";
session_start();
$userProfile;
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
$currentUser=$_SESSION['user'];

if(isset($_GET['id']))
{
  if($_GET['id']==$currentUser->id_user)
    $userProfile=$currentUser;
  
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
    <link rel="stylesheet" href="styles/home.css">
    <script src="https://kit.fontawesome.com/a6397c1be2.js" crossorigin="anonymous"></script>
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
      <a href="home.php"><img src="uploads/toolan.png" alt="logo" id="logo"></a>
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


<!--PAGE-->
<div class="container-fluid text-center" id="home-container">
  <div class="row">
    <div class="col">
    </div>
    <div class="post col-7">
        <div id="suggestion-box" class="list-group"></div>
        <div class='profile-box'><br><div>
        <a href=""><?php  $pfpPath=$userProfile->profile_picture;
            echo "<img src='$pfpPath' class='pfpProfile'>";?></a>
        </div>
        <?php 
            echo "<p class='profileName'>$userProfile->name</p>";
            echo "<p class='profileUsername'>@$userProfile->username</p> <br>";
        ?>
        <button type="button" class="btn btn-primary" id="addORedit_btn"></button>

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
    
    //logika za prikazivanje postova
    var postsLimit=3;
    var offset=0;
    var pageID='<?php echo $userProfile->id_user;?>'
    var isLoading=false;  //zabranjujem paralelno izvrsavanje vise asinhronih funkcija
  
    function loadPosts()//dodaj za com+likes
    {
      if(isLoading)
        return;
      isLoading=true;
      $.post(
        "load_posts.php",{pageID:pageID,postsLimit: postsLimit, offset:offset},function(response)
        {
          $("#post-container").append(response);

          var newPosts = $("#post-container").children('.the-post');

            // Loop through each new post to load likes count
            newPosts.each(function () {
                var postID = $(this).prop('id');
                var likesCountContainer = $(this).find('.likesCount');
                var commentsCountContainer = $(this).find('.commentsCount');
                var likeButton = $(this).find('.like');
                // Fetch and display the likes count
                $.post(
                "get_post_info.php",
                { postID: postID },
                function (response) {
                    if (response.isLiked) {
                        likeButton.removeClass('fa-heart-o').addClass('fa-heart');
                    } else {
                        likeButton.removeClass('fa-heart').addClass('fa-heart-o');
                    }
                    likesCountContainer.html(response.likesCount+" Likes");
                    commentsCountContainer.html(response.commentsCount+" Comments");
                   
                }
            );
        });
          offset+=postsLimit;
          isLoading=false;
        }
      );
    }

    loadPosts();

    $(window).scroll(function() {
        // if ($(window).scrollTop() + $(window).height() >= $('#home-container').height() ) {
        //     loadPosts();
        // }
        if (Math.ceil($(document).height() - $(window).scrollTop()) <= $(window).height()+50) {
              loadPosts();
        }
    });
    console.log("AAA");
  
  $(document).on('click', '.like', function(){
    var postID = $(this).closest('.the-post').prop('id');
    var likeButton = $(this); // referenca na kliknutu ikonicu like
    $.post(
        "like.php",
        { postID: postID },
        function(response) {
          console.log(response.likeStatus);
            if (response.likeStatus == "liked") {
                likeButton.removeClass('fa-heart-o').addClass('fa-heart');
            } else if (response.likeStatus == "notLiked") {
                likeButton.removeClass('fa-heart').addClass('fa-heart-o');
            }
            console.log(response.likesCount);
            likeButton.closest('.the-post').find('.likesCount').html(response.likesCount+" Likes");
        }
    );
  })

    //funkcija za izgled dugmeta za follow/edit profile
    function followButtonTextChange() {
    var btn = $("#addORedit_btn");
    var currentUserID = <?php echo $currentUser->id_user; ?>;
    //grabi id profila iz URL-a
    var urlParams = new URLSearchParams(window.location.search);
    var profileID = urlParams.get('id');

    if (profileID == currentUserID) {
      btn.html("Edit profile");
    } else {
      $.get(
        "follow.php", { followed: profileID },
        function (response) {
          if (response == "FOLLOWING")
            btn.html("Unfollow").css("background-color","grey");
          else if(response=="FOLLOWING ME")
             btn.html("Follow Back").css("background-color","#db4ba6");
          else
              btn.html("Follow").css("background-color","#db4ba6");
        }
      )
    }
  }

    followButtonTextChange();

    //pretraga korisnika
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

    function handleEditOrFollow()
    {
      var currentUserID = <?php echo $currentUser->id_user; ?>;
      var urlParams = new URLSearchParams(window.location.search);
      var profileID = urlParams.get('id');

      if (profileID == currentUserID) {
        window.location.href="edit_profile.php";
      } else {
        $.post(
          "follow.php", { followed: profileID },
          function (response) {
            if(response=="success")
              followButtonTextChange();

          }
        )
      }
    }

    //dugme add OR edit
    $("#addORedit_btn").click(handleEditOrFollow);

    

});



</script>



</body>
</html>