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
  <!-- ADD COMMENT MODAL -->
        <div id="commentModal" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                      <h5 class="modal-title">Add Comment</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal Body -->
                  <div class="modal-body">
                      <textarea id="commentText" class="form-control" rows="4" placeholder="Type your comment here..."></textarea>
                  </div>
                  <!-- Modal Footer -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary" id="submitComment">Submit</button>
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
        <button type="button" class="btn btn-primary" id="addORedit_btn"></button>
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
    
//OVA DVA EVENTA ISPOD DA STAVIM U POSEBAN FAJL JER SU ISTI I ZA HOME.PHP
  //lajk event
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

  //comment event
  $(document).on('click', '.comment', function(){
    var postID = $(this).closest('.the-post').prop('id');
    var commentButton=$(this);
    var txtArea=document.getElementById("commentText");
    txtArea.value="";
    var subm=document.getElementById("submitComment");
      buttonEnabled(txtArea,subm);
    $("#commentText").on('input',function(){
      buttonEnabled(txtArea,subm);
    })
      
    $('#commentModal').modal('show');
    var btn=$("#submitComment");
    btn.unbind("click");  //svaki put kada se klikne comment ico novi event handler se dodaje dugmetu koje submituje com pa moram da ga unbindujem
    btn.click(function(){
      var comment=txtArea.value;
      console.log(comment.length);
      if (comment.length<30)
      {
          $.post(
          "post_comment.php",{postID:postID,comment:comment},
          function(response){
            if(response=="success")
            {
              alert("You have successfully posted your comment.");
              $('#commentModal').modal('hide');
              var postElement = $('#' + postID);
              var commentsCountContainer = postElement.find('.commentsCount');
              var currentCommentCount = parseInt(commentsCountContainer.text().split(' ')[0]);
              commentsCountContainer.text((currentCommentCount + 1) + " Comments");
            }
            else
            {
              alert("There was an error posting your comment.");
            }
          }
        );
      }
      else alert("Comment can have a maximum of 30 characters!");
     
    });
  });


  //ko je lajkovao
  $(document).on('click', '.likesCount', function(){
    var postID = $(this).closest('.the-post').prop('id');
    $.get("get_likers.php",{postID:postID},
    function(response)
    {
      var modalBody = $('#windowModalBody');
      modalBody.empty();
      $("#windowModalLabel").text("Users who liked this photo")
      if(response.length>0)
      {
        for(var i=0;i<response.length;i++)
        {
          modalBody.append("<div class='d-flex align-items-center justify-content-between mb-2'>" +
    "<div class='d-flex align-items-center'>" +
    "<a href='profile.php?id=" + response[i].id_user + "' style='display: inline-block; width: " + (60) + "px;'>" +
    "<img src='" + response[i].profile_picture + "' class='pfpNav'></a>" +
    "<span class='ml-2'>" + response[i].name + "</span>" +
    "</div>" +
    "<i class='like fa fa-heart fa-2x'></i>" +
    "</div>");

        }
      }
      else modalBody.append('<p>This post has 0 likes.</p>');
      

      $('#windowModal').modal('show');
    })
  });


  //komentari prikaz
  $(document).on('click', '.commentsCount', function(){
    var postID = $(this).closest('.the-post').prop('id');
    $.get("get_comments.php",{postID:postID},
    function(response)
    {
      var users=response.users;
      var comments=response.comments;
      var modalBody = $('#windowModalBody');
      modalBody.empty();
      $("#windowModalLabel").text("Comments")

      if(users.length>0)
      {
        for (let i = 0; i < users.length; i++) {
          modalBody.append("<div class='d-flex align-items-center justify-content-between mb-2'>" +
          "<div class='d-flex align-items-center'>" +
          "<a href='profile.php?id=" + users[i].id_user + "' style='display: inline-block; width: " + (60) + "px;'>" +
          "<img src='" + users[i].profile_picture + "' class='pfpNav'></a>" +
          "<span class='ml-2'>" + users[i].name + ":</span>" +
          "</div>" +
          "<span class='ml-2'>" + comments[i] + "</span>" +
          "</div>");
        }
      }
      else modalBody.append('<p>This post has 0 comments.</p>');
      
      $('#windowModal').modal('show');
    })
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


//I OVO EVENTUALNO U JS FAJL
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

    //profile description
    var decodedDescription = decodeURIComponent("<?php echo $userProfile->prof_description?>")
    if(decodedDescription.length>0)
      $("#profileDescription").text(decodedDescription);
    else $("#profileDescription").text("No profile description");

});



</script>



</body>
</html>