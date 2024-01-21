<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php

        if(isset($_SESSION['add']))
        {
            echo ($_SESSION['add']);
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload']))
        {
            echo ($_SESSION['upload']);
            unset($_SESSION['upload']);
        }

        ?>
        <br>

        <!--Add Categoy From Starts-->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Categoy Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
    <td>Featured:</td>
    <td>
        <input type="radio" name="featured" value="Yes"> Yes
        <input type="radio" name="featured" value="No"> No
    </td>
</tr>

<tr>
    <td>Active:</td>
    <td>
        <input type="radio" name="active" value="Yes"> Yes
        <input type="radio" name="active" value="No"> No
    </td>
</tr>

<tr>
    <td colspan="2">
            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
    </td>
</tr>

            </table>
        </form>
        <!--Add Categoy From Ends-->
        <?php
        //Check if the button is clicked or not
// Check if the button is clicked or not
if(isset($_POST['submit']))
{
    // Get the value from category Form
    $title = $_POST['title'];
    $featured = isset($_POST['featured']) && $_POST['featured'] == 'Yes' ? 'Yes' : 'No';
    $active = isset($_POST['active']) && $_POST['active'] == 'Yes' ? 'Yes' : 'No';

    //Check wheter the image is selected or not and set the value for image
    //print_r($_FILES['image']);

    //die();

    if(isset($_FILES['image']['name']))
    {
        //Upload the image
        //To upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        if($image_name !=="")
         {
         //Auto Rename our Image
         //Get the extension of our image(jpg, png, img, GIF, etc...)
         $ext = end(explode('.', $image_name));

         //Rename the Image
         $image_name="Food_Category_".rand(000, 999).'.'.$ext;

         //Upload the image only if image is selected

         $source_path = $_FILES['image']['tmp_name'];

         $destination_path="../images/category/".$image_name;  

         //Finaly Upload the Image
         $upload = move_uploaded_file($source_path, $destination_path);

         //Check whether the image is upload or not
         //And if the image is not upload then we will stop the process and redirect with error message

         if($upload==false)
         {
             //SET message
             $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
             //Redirect to Add Category Page
             header('location:' . SITEURL . 'admin/add-category.php');
             //Stop the process
             die();
         }

      }
    }
    else
    {
        $image_name="";
    }

    $sql= "INSERT INTO tb_category (title, featured, active) VALUES ('$title', '$featured', '$active')";


    //2-Create SQL Query to Insert Category into DataBase
    $sql= "INSERT INTO tb_category (title, featured, active, image_name) VALUES ('$title', '$featured', '$active', '$image_name')";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed or not and data added or not
    if($res)
    {
        $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
    else
    {
        $_SESSION['add']="<div class='error'>Failed to Add Category.</div>";
        header('location:' . SITEURL . 'admin/add-category.php');
    }
}

        
        ?>
    </div>
</div>


<?php include('partials/footer.php'); ?>