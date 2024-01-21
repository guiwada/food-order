<?php include('partials-front/menu.php');?>

<?php
//Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
       //Category ID is set and get the id
        $category_id = $_GET['category_id'];
        //GET the category title based on category ID
        $sql = "SELECT title FROM tb_category WHERE id=$category_id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //GET the valuer from Database
        $row =  mysqli_fetch_assoc($res);
        //GET the title
        $category_title = $row['title'];
    }
    else
        {
            //Category not passed
            //Redirect to Home Page
            header('location:' . SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            //Create SQL Query to GET foods based on Selected Category
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count the rows
            $count2 = mysqli_num_rows($res2);

            //Check whether food is available or not
            if($count2>0)
            {
                //Food is Available
                while($row=mysqli_fetch_assoc($res2))
                {
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if($image_name=="")
                            {
                                //Image not Available
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else
                            {
                                //Image Available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="food-price">$<?php echo $price; ?></p>
                    <p class="food-detail">
                        <?php echo $description; ?>
                    </p>
                    <br>

                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>

                    <?php
                }
            }
            else
            {
                //Food not available
                echo "<div class='error>Food Not Available</div>";
            }
            ?>
            <div class="food-menu-box">
                <div class="food-menu-img">
                    <img src="images/menu-pizza.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                </div>

                <div class="food-menu-desc">
                    <h4>Food Title</h4>
                    <p class="food-price">$2.3</p>
                    <p class="food-detail">
                        Made with Italian Sauce, Chicken, and organice vegetables.
                    </p>
                    <br>

                    <a href="#" class="btn btn-primary">Order Now</a>
                </div>
            </div>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->


    <!-- footer Section Starts Here -->
    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved. Designed By <a href="#">Vijay Thapa</a></p>
        </div>
    </section>
    <!-- footer Section Ends Here -->
    <?php include('partials-front/footer.php');?>

</body>
</html>