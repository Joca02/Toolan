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
  exit();
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
</head>
<body>
    <?php
        //TODO profil izgled, add post, settings, add friend
        //Post logika
    ?>

<div class="container-fluid">
  <div class="row" id="upper-panel">
    <div class="col">
      <a href="home.php"><img src="../toolan.png" alt="logo" id="logo"></a>
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
          <a class="dropdown-item" href="profile.php">View Profile</a>
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
        <div>
        <a href=""><?php  $pfpPath=$currentUser->profile_picture;
            echo "<img src='$pfpPath' class='pfpProfile'>";?></a>
        </div>
        <?php 
            
        ?>
    </div>
    <div class="col">
    </div>
  </div>




<script src="js/home.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>