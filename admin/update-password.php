<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>

        <form action="" method = "POST">

        <table class="tbl-30">
            <tr>
                <td>Current Password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>
            <tr>
                <td>New Password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>
            <tr>
                <td>Current Password:</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
            </tr>
        </table>

        </form>
    </div>
</div>

<?php
//Chec if the button is clicked or not
if(isset($_POST['submit']))
{
    //Get the data from form
    $id=$_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //Check wheter the user with current ID and current Password existis or not
    $sql = "SELECT *FROM tbl_admin WHERE id=$id AND password = '$current_password'";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User exists and password can be change
            //echo "user found";
            if($new_password==$confirm_password)
            {
                echo "passowrd match";
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                WHERE id=$id
                ";

                $res2=mysqli_query($conn,$sql2);

                if($res2==true){
                    $_SESSION['change-pwd'] = "<div class = 'sucess'>Password Changed</div>";
                    header('location: ' . SITEURL . 'admin/manege-admin.php');
                }
                else
                {
                    $_SESSION['pwd-not-match'] = "<div class = 'eror'>Failed to Change</div>";
                    header('location: ' . SITEURL . 'admin/manege-admin.php');
                }
            }
            else
            {
                $_SESSION['pwd-not-match'] = "<div class = 'eror'>Password not match</div>";
                header('location: ' . SITEURL . 'admin/manege-admin.php');
            }
        }
        else
        {
            $_SESSION['user-not-found'] = "<div class = 'eror'>user not found</div>";
            header('location: ' . SITEURL . 'admin/manege-admin.php');
        }
    }


}
?>

<?php include('partials/footer.php'); ?>