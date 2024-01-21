<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //Display all the categories
                //SQl Query
                $sql = "SELECT * FROM tb_category WHERE active='Yes'";

                //Execute the Query

                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check whether categories available or not
                if($count>0)
                {
                    //Categories Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //GET the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                if($image_name=="")
                                {
                                    //image not available
                                    echo "<div class='error'>Categorie not found</div>";
                                }
                                else
                                {
                                    //Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>

                <h3 class="float-text text-white"><?php echo $title; ?></h3>
            </div>
            </a>  
                        <?php
                    }
                }
                else
                {
                    //categories not available
                    echo "<div class='error'>Categorie not found</div>";
                }
            ?>        

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
