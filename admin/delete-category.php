<?php
include('../config/constants.php');

//Check wheter the id and image_name value is set or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //Get the value and delete
    $id = $_GET['id'];
    $image_name=$_GET['image_name'];

    //Remove the physical image file is available
    if($image_name !="")
    {
        //Image is available, so remove it
        $path = "../images/category/".$image_name;
        //Remove the image
        $remove = unlink($path);

        //IF falied to remove image then add an error message and stop the process
        if($remove==false)
        {
            //SET the Session Message
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image. </div>";
            //Redirect to Manage Category Page
            header('location:' . SITEURL . 'admin/manage-category.php'); 
            //Stop the process
            die();
        }
    }
    //Delete Data from Database
    //SQL Query ti delete
    $sql = "DELETE FROM tb_category WHERE id=$id";

    //execute the Query
    $res = mysqli_query($conn, $sql);

    //Check wheter the data is delete from database or not
    if($res==true)
    {
        //SET Sucess message and redirect
        $_SESSION['delete'] = "<div class='sucess'> Category Deleted Successfully</div>";
        //Redirect to Manage Category
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
    else
    {
                //SET Fail message and redirect
                $_SESSION['delete'] = "<div class='error'> Faleid to Deleted Category</div>";
                //Redirect to Manage Category
                header('location:' . SITEURL . 'admin/manage-category.php');
    }

}
else
{
    header('location:' . SITEURL . 'admin/manage-category.php');
}
?>