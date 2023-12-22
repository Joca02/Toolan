<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/home.css">

</head>
<body>
    
<div class="container-fluid">
  <div class="row" id="upper-panel">
    <div class="col">
      <img src="../toolan.png" alt="logo" id="logo">
    </div>
    <div class="col-6" id="search-div">
    <input type="text" class="form-control" id="search" placeholder="Search...">
    </div>
    <div class="col">
      OVDE STOJE PROFILNA I IME
    </div>
  </div>
</div>

<div class="container-fluid text-center" id="home-container">
  <div class="row">
    <div class="col">
     
    </div>
    <div class="post col-7">
        <div class="quick-post row">
            <div class="col-9">
            <textarea class="form-control" placeholder="Add a quick post. What's on your mind?" rows="3" id="quick-post" oninput="buttonEnabled(this)"></textarea>
            </div>
            <div class="btn col-3" id="btn-qpost">
                <button type="submit" class="btn btn-primary" id="confirm-post" disabled>Post</button>
            </div>
    </div>
    </div>
    <div class="col">
     
    </div>
  </div>
</div>







<script src="js/home.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>