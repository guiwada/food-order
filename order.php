<?php include('partials-front/menu.php');?>

<?php
//Check whether food id is set or not
if(isset($_GET['food_id']))
{
    //GET the food id and details of the selected food
    $food_id = $_GET['food_id'];

    //GET the details of the selected food
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //Count the rows
    $count = mysqli_num_rows($res);

    //Check whether the data is available or not
    if($count==1)
    {
        //We have Data
        //GET the Data from Database
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    }
    else
    {
        //Food not available
        //Redirect to Home Page
        header('location:' . SITEURL);
    }
}
else
{
    //Redirect to homepage
    header('location:' . SITEURL);
}
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                            //Check whether the image is available or not
                            if($image_name=="")
                            {
                                //Image not available
                                echo "<div class='error'>Image not Available.</div>";
                            }
                            else
                            {
                                //Image is available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Ful Name</div>
                    <input type="text" name="full_name" placeholder="E.g. Vijay Thap" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="adress" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
            //Check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //GET all the details from the form

                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                //Total = Price * qty
                $total = $price * $qty;

                $order_date = date("d-m-y h:i:sa");//Order Date

                $status ="Ordered";//Ordered, On Delivery, deliverd, Cancelled

                $customer_name = $_POST['full_name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_adress = $_POST['adress'];


// Rest of your code

                //Save the order in database
                //Create SQL to save the data
                $sql2 = "INSERT INTO tbl_order SET
                food ='$food',
                price = $price,
                qty = $qty,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_adress	 = '$customer_adress'
            ";
            

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Check whether query executed successufully or not
                if($res2==true)
                {
                    //Query Executed and Order Saved
                    $_SESSION['order'] = "<div class='sucess text-center'>Food Order Successfully.</div>";
                    header('location:'. SITEURL);
                }
                else
                {
                    //Failed to Save Order
                    $_SESSION['order'] = "<div class='error text-center'> Failed food Order.</div>";
                    header('location:'. SITEURL);
                }

            }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php');?>

</body>
</html>