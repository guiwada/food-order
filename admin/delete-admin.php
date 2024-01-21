<?php
include('../config/constants.php');

$id = $_GET['id'];

$sql = "DELETE FROM tbl_admin WHERE id=$id";

$res = mysqli_query($conn, $sql);

if($res==true)
{
    $_SESSION['delete'] = "<div class = 'sucess'>Admin deleted successfully.</div>";

    header('location:'.SITEURL.'admin/manege-admin.php');
}
else
{
    $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin. Try Again Later.</div>";
    header('location:'.SITEURL.'admin/manege-admin.php');
}
?>
