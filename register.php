<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/login.css">
    <script src="https://kit.fontawesome.com/a6397c1be2.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/register.js"></script>
</head>

<body>
<div id="global_login_container">
        <div id="around_login_form">
            <img id="logoImage" src="uploads/toolan.png" alt="">
            <br><br>
            <div id="register_form" class="login_form">
            <div id="login_form_header">
                <span>Create a new account</span>
                <br><br>
            </div>
                     <input type="text" name="name" id= "name" placeholder="Enter Your Name" class="login_input" required><br>
                    <input type="text" name="username" id= "username" placeholder="New Unique Username" class="login_input" required><br>
                    <input type="password" name="password" id= "password"placeholder="New Password" class="login_input" required><br>
                    <input type="password" name="password2" placeholder="Re-Enter Password" class="login_input" required><br>
                    <div class="choose_gender">
                        <label id="chg" >Choose gender:</label>
                        <input type="radio" name="gender" value="male" required>
                        <label for="male">Male</label>
                        <input type="radio" name="gender" value="female" required>
                        <label for="female">Female</label><br>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" id="login_submit">Register Now</button>
                <br>
            </div>
        </div>
    </div>

  
<script>
</script>
</body>


</html>