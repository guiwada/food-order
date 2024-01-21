<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_admin WHERE id=$id";
$res = mysqli_query($conn, $sql);

        //Check whether the query is executed or not
        if ($res == true) 
        {
            //Check whether the data is available or not
            $count = mysqli_num_rows($res);
            //Check whether we have admin data or not
            if ($count == 1) {
                //echo "Admin Available";
                $row = mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $username = $row['username'];
            } 
            else {
                //Redirect to Manage Admin Page
                header('location: ' . SITEURL . 'admin/manege-admin.php');
            }
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value=" <?php echo $full_name ; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value = "<?php echo $username ;?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name = "id"  value = "<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

if(isset($_POST['submit']))
{
    //echo "Button Clicked";

    // Get all the values from form to update
     $id = $_POST['id'];
     $full_name = $_POST['full_name'];
     $username = $_POST['username'];

     $sql = "UPDATE tbl_admin SET
     full_name = '$full_name',
     username = '$username'
     WHERE id = '$id'
     ";

     //Execute the Query
     $res = mysqli_query($conn, $sql);

     if($res==true)
     {
        //Query Executed and Admin Updated
        $_SESSION['update'] = "<div class ='sucess'>Admin Updated Sucessfully</div>";
        header('location:' .SITEURL.'admin/manege-admin.php');
     }
     else
     {
        $_SESSION['update'] = "<div class ='sucess'>Falied to Delete Admin</div>";
        header('location:' .SITEURL.'admin/manege-admin.php');
     }
}
?>
<?php include('partials/footer.php'); ?>
