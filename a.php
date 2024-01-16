<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/post.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/home.js"></script>
</head>
<body>
    
<div id="post-container"></div>

<script>

    //FAJL ZA EKSPERIMENTISANJE

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
var postTemplate; 

// $.ajax({
//     url: 'post.html',
//     method: 'GET',
//     async: false, // Set to false to ensure synchronous behavior
//     success: function (data) {
//         postTemplate = data;
//     }
// });

// $.get("post.html",function(data)
// {
//     console.log(data);
//     postTemplate = data;
//     $("#post-container").append(postTemplate);
// })


$.get("post.html",function(data)
{
    console.log(data);
    var tempContainer = $('<div>');
    tempContainer.html(data);

   ž
    var postElement = tempContainer.find('.the-post');
    
    postElement.find('.post-content p').text("AWSD"); 
    $("#post-container").append(postElement);
})




//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
</script>
</body>
</html>