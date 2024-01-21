<?php

//Check wheter the user is logged or not
if(!isset($_SESSION['user']))//if user session is not set
{
    //User is not logged in
    //Redirect to login page with message
    $_SESSION['no-login-message'] = "<div class = 'error'>Please Login to Acess Admin Panel.</div>";
    //Redirect to Login Page
    header("location:". SITEURL .'admin/login.php');
}