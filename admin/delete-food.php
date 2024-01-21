<?php
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // 1. GET ID and Image Name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // 2. Remove the image if available
    // Check whether the image is available or not and delete only if available
    if ($image_name != "") {
        // If there's an image, remove it from the folder
        $path = "../images/food/" . $image_name;

        // Remove image file from folder
        $remove = unlink($path);

        // Check whether the image is removed or not
        if ($remove == false) {
            // Failed to remove image
            $_SESSION['upload'] = "<div class='error'>Failed to Remove the image file</div>";
            // Redirect to Manage Food
            header('location:' . SITEURL . 'admin/manage-food.php');
            // Stop the process
            die();
        }
    }

    // 3. Delete Food from Database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    // Execute the Query
    $res = mysqli_query($conn, $sql);
    // Check whether the query executed or not and set the session message respectively
    if ($res == true) {
        // Food Deleted
        $_SESSION['delete'] = "<div class='sucess'>Food Deleted Successfully</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        // Failed to Delete Food
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
} else {
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
