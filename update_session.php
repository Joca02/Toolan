<?php
require_once "classes.php";
require_once "database.php";
session_start();

if (isset($_SESSION['user'])) {
    $currentUser = $_SESSION['user'];
    $_SESSION['user'] = findUserById($currentUser->id_user);
    $_SESSION['user']->profile_picture=$_SESSION['user']->profile_picture+"?v=1";
}
?>
