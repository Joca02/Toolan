<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div id="global_login_container">
        <div id="around_login_form">
            <img id="logoImage" src="../toolan.png" alt="">
            <br><br>
            <div class="login_form">
            <div id="login_form_header">
                <span>Log Into TOOLAN</span>
                <br><br>
            </div>
                <form action="login.php" method="post">
                    <input type="text" name="username" placeholder="Username" class="login_input"><br>
                    <input type="password" name="password" placeholder="Password" class="login_input"><br>
                    <button type="submit" class="btn btn-primary" id="login_submit">Log In</button>
                </form>
                <br>
                <a href="register.php" id="login_acc_create">Dont have an account? Sign up now!</a>
            </div>
        </div>
    </div>

<?php
require_once "classes.php";
session_start();
//TODO sesije, logika kad vraca null
if(isset($_POST['username'])&&isset($_POST['password']))
{
    
    $user=User::isSuccessfullLogin($_POST['username'],$_POST['password']);
    
    if ($user instanceof User)
    {
        $_SESSION['user']=$user;
        header("Location: home.php");
        exit();
    }
    //TODO ispravna notifikacija kad je neuspeo login 
    else if($user==false)
    {
        echo "<p class='choose'>LOSI LOGIN PODACI</p>";
        session_destroy();
    }
        
}

?>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>