//ucitavanje templejta posta
var postElement;
$(function(){
    $.get("post.html",function(data)
{
    var tempContainer = $('<div>');
    tempContainer.html(data);
  
    postElement = tempContainer.find('.the-post'); 
    postElement.find('.like-comment-icons').remove();
})
});
var postsLimit=3;
var offset=0;
var isLoading=false;
function loadPostsAdmin(pageID)
    {
      if(isLoading)
        return;
      isLoading=true;
      
      $.post(
        "load_posts.php",{pageID:pageID,postsLimit: postsLimit, offset:offset},function(response)
        {
          for(var i=0;i<response.usernames.length;i++)
          {
            var newPost=postElement.clone();//pravim klon templejta jer ce se  referencom sve primeniti nad 1 elementom
           
            newPost.find('.pfpNav').attr('src',response.profile_pictures[i]);
            newPost.attr('id',response.id_posts[i]);
            newPost.find('.username').text("@"+response.usernames[i]);
            
            newPost.find('.timestamp').text(response.dates[i]);
            newPost.find('.post-content p').text(response.post_descriptions[i]);
            if(response.isUserOwner==true) //dodajem mogucnost brisanja objave
              newPost.find('.deletePost').append("<button type='button' class='delBtn btn btn-outline-danger'>X</button>");

            $("#post-container").append(newPost);
          }
          var newPosts = $("#post-container").children('.the-post');

           
            newPosts.each(function () {
                var postID = $(this).prop('id');
                var likesCountContainer = $(this).find('.likesCount');
                var commentsCountContainer = $(this).find('.commentsCount');
                $.post(
                "get_post_info.php",
                { postID: postID },
                function (response) {
                    
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
    "<a href='profile_admin_view.php?id=" + response[i].id_user + "' style='display: inline-block; width: " + (60) + "px;'>" +
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
          "<a href='profile_admin_view.php?id=" + users[i].id_user + "' style='display: inline-block; width: " + (60) + "px;'>" +
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




    //pretraga korisnika
  $(function(){
    const suggestionBox = $("#suggestion-box");
  $("#search").on("input", function(){
    var characters = $(this).val();
    suggestionBox.empty();
    if(characters.length > 0) {
      $.get("filter_search.php?name=" + characters, function(response) {
        
        for (var i = 0; i < response.length; i++) {
            const suggestionItem = $("<a href='profile_admin_view.php?id="+response[i].id_user+"'  class='list-group-item list-group-item-action list-group-item-light'><img src='" + response[i].profile_picture + "' class='profile-picture-search'> " + response[i].name + "</a>");

            suggestionBox.append(suggestionItem);

        }
        suggestionBox.show();
      });
    }
  });
  })


  $(document).on('click', '.pfpNav', function() {
    //nalazim userID trimovanjem sourca slike, jer je svaka slika u formatu userID.png/jpg/jpeg..
    var srcValue = $(this).attr('src');
    var idDotPng=srcValue.replace('uploads/profile_pictures/', '');
    var arr=idDotPng.split('.');
    var userID=arr[0];
    
    window.location.href = "profile_admin_view.php?id="+userID;
});