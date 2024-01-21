<?php
//Destroy the Session
include('../config/constants.php');
session_destroy();
//Redirect to Login page
header('location:' . SITEURL . 'admin/login.php');
?>