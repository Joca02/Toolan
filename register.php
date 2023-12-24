<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
<div id="global_login_container">
        <div id="around_login_form">
            <img id="logoImage" src="../toolan.png" alt="">
            <br><br>
            <div id="register_form" class="login_form">
            <div id="login_form_header">
                <span>Create a new account</span>
                <br><br>
            </div>
                <form action="register.php" method="post" onsubmit="return validateForm()">
                     <input type="text" name="name" placeholder="Enter Your Name" class="login_input" required><br>
                    <input type="text" name="username" placeholder="New Unique Username" class="login_input" required><br>
                    <input type="password" name="password" placeholder="New Password" class="login_input" required><br>
                    <input type="password" name="password2" placeholder="Re-Enter Password" class="login_input" required><br>
                    <div class="choose_gender">
                        <label id="chg" >Choose gender:</label>
                        <input type="radio" name="gender" value="male" required>
                        <label for="male">Male</label>
                        <input type="radio" name="gender" value="female">
                        <label for="female">Female</label><br>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" id="login_submit">Register Now</button>
                </form>
                <br>
            </div>
        </div>
    </div>


 <!--PHP-->   
<?php
require_once "database.php";
if(isset($_POST['name'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['gender']))
{
    $dbc=createConnection();
    $name=$_POST['name'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $gender=$_POST['gender'];

    $query="SELECT * FROM users WHERE username='$username'";
    $res=mysqli_query($dbc,$query);
    if($res)
    {
        if(mysqli_num_rows($res)>0)
        {
            echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        }
        else
        {
            $insertQuery="INSERT INTO users (name,username,password,gender) VALUES ('$name','$username','$password','$gender')";
            $res=mysqli_query($dbc,$insertQuery);
            if($res)
            {
                header("Location: redirected.php");
            }
            else error_log("Bad querry ".mysqli_error($dbc));

        }
    }
    else error_log("Bad querry ".mysqli_error($dbc));

    
    closeConnection($dbc);
}



?>

<script src="js/register.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>