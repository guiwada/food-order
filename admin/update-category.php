<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        if (isset($_GET['id']))
        {
            $id = $_GET['id'];
            //Create SQL Query to get all others details
            $sql = "SELECT * FROM tb_category WHERE id=$id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                //Get all the data
                $row = mysqli_fetch_assoc($res);
                $title= $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                $_SESSION['no-category-found'] = "<div class='error>Category not found</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }
        else
        {
            header('location:' . SITEURL . 'admin/category.php');
        }
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                    <?php
                     if($current_image !="")
                     {
                        //Display the image
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"width="150px">;
                        <?php
                        
                     }
                     else
                     {
                        //Display the message
                        echo "<div class='error'>Image Not Added</div>";
                     }
                     ?>
                </td>
            </tr>

            <tr>
                <td>New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo"checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo"checked";} ?> type="radio" name="featured" value="No">No                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                <input <?php if($active=="Yes"){echo"checked";}?> type="radio" name="active" value="Yes">Yes
                <input <?php if($active=="No"){echo"checked";}?>  type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name ="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                </td>
            </tr>
        </table>

        </form>

        <?php

        if(isset($_POST['submit']))
        {
            //1-Get all the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2-Update the Database
            if(isset($_FILES['image']['name']))
            {
                //Get  the Images Details
                $image_name = $_FILES['image']['name'];

                //Check whether the image is available or not
                if($image_name !="")
                {
        //Image Available

        //Upload the new image
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
             header('location:' . SITEURL . 'admin/manage-category.php');
             //Stop the process
             die();
         }

         //Remove the current image
         if($current_image!="")
         {

         }
         $remove_path="../images/category/".$current_image;

                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            //3-Updating New Image if selected
            $sql2 = "UPDATE tb_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //4-Redirect to Manage category with Message
            //Check whether executed or not
            if($res2==true)
            {
                //Category Update
                $_SESSION['update'] = "<div class='sucess'>Category Update Sucessfully.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');                
            }
            else
            {
                //Failed to Update Category
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php')?>