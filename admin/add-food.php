<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            $sql = "SELECT * FROM tb_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($rows = mysqli_fetch_assoc($res)) {
                                    $id = $rows['id'];
                                    $title = $rows['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Category Found</option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Processar o formulário e inserir no banco de dados ...

            //Get the Data From Form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }

            if(isset($_FILES['image']['name']))
            {
                $image_name = $_FILES['image']['name'];

                //Check whether the image is selected or not
                if ($image_name!="") {
                    //Image is Selected
                    //Rename the image
                    //Get the extension of selected image(jpg,png,gif,etc)
                    $ext = end(explode('.', $image_name));

                    //Create new name for image
                    $image_name = "Food-Name" . rand(0000, 9999) . "." . $ext;

                    //Source path is the current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //Destination Path for the image to be uploaded
                    $dst = "../images/food/" . $image_name;

                    $upload = move_uploaded_file($src, $dst);

                    if ($upload == false)
                    {
                        //Failed to Upload the image
                        //Redirect to add Food Page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/add-food.php');
                        die();
                    }
                }
            } else
            {
                $image_name = "";
            }

            //Create a SQL Query to Save or Add Food
            //For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";

        // Execute the Query
        $res2 = mysqli_query($conn, $sql2);
    
        // Check if the query was successful
        if ($res2) {
            $_SESSION['add'] = "<div class='success'>Food added Successfully</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to add Food</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
        }
    }
    ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
