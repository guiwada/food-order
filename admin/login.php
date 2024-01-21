<?php include('../config/constants.php'); ?>

<html>
<head>
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<div class="login">
    <h1 class="text-center">Login</h1>

    <?php
    if(isset($_SESSION['login'])) {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }

    if(isset($_SESSION['no-login-message']))
    {
        echo $_SESSION['no-login-message'];
        unset ($_SESSION['no-login-message']);
    }
    ?>
    <br><br>

    <form action="" method="POST" class="text-center">
        Username:<br>
        <input type="text" name="username" placeholder="Enter Username"><br><br>
        Password:<br>
        <input type="password" name="password" placeholder="Enter Password"><br><br>

        <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
    </form>

    <p class="text-center">Created By Guilherme Wada</p>
</div>
</body>
</html>

<?php
//Check if the button is clicked
if(isset($_POST['submit'])) {
    //Get the Data from Login form
    //$username = $_POST['username'];
    //$password = md5($_POST['password']);

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    //SQL to check whether the user with username and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE username = ? AND password = ?";
    
    //Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);
    
    //Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    //Execute the Query
    mysqli_stmt_execute($stmt);
    
    //Get result
    $res = mysqli_stmt_get_result($stmt);

    //Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if($count == 1) {
        // User Available and Login Success
        $_SESSION['login'] = "<div class='success'>Login Success</div>";
        $_SESSION['user'] = $username;//Check if the user is logged or not
        // Redirect to home Page/Dashboard
        header('location: ' . SITEURL . 'admin/');
        exit();
    } else {
        // User not available or Login Failed
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
        // Redirect to login page
        header('location: ' . SITEURL . 'admin/login.php');
        exit();
    }
}
?>
