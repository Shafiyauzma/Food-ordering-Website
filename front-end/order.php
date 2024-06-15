<?php include("../partials-front/menu.php"); ?>

<?php

   //check whether food id is set or not
   if(isset($_GET['food_id'])){
      
       //Get the food id and details of selected food
       $food_id = $_GET['food_id'];

       //get the details of selected food
       $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
       //execute query
       $res = mysqli_query($conn,$sql);
       //count the rows
       $count = mysqli_num_rows($res);

       //check whether the data is available or not
       if($count==1){
          
          //we have data
          //get the data from database
          $row = mysqli_fetch_assoc($res);

          $title = $row['title'];
          $price = $row['price'];
          $image_name = $row['image_name'];

       }
       else{
          
           //we donot have data
           //Redirect to Home page
           header('location:'.SITEURL);
       }

   }
   else{

      //Redirect to Home page
      header('location:'.SITEURL);
   }


?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action ="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                           
                           //check whether the image is selected or not
                           if($image_name==""){
                              
                              //Image not available
                              echo "<div style='color:#ff4757'>Image Not Available</div>";
                           }
                           else{

                              //Image Available
                              ?>
                                <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                              <?php
                           }

                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">
                        <p class="food-price"><?php echo $price;?></p>
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php

                //check whether submit button is clicked or not
                if(isset($_POST['submit'])){

                    //get all details from form

                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $quantity = $_POST['qty'];

                    $total = $price * $quantity;
                    $order_date = date("Y-m-d h:i:s");

                    $status = "Ordered";

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //save the order in database
                    //create sql to save order
                    $sql2 = "INSERT INTO tbl_order SET
                             food ='$food',
                             price = $price,
                             quantity = $quantity,
                             total = $total,
                             order_date = '$order_date',
                             status = '$status',
                             customer_name = '$customer_name',
                             customer_contact = '$customer_contact',
                             customer_email = '$customer_email',
                             customer_address = '$customer_address'
                             ";
                    //execute query
                    $res2 = mysqli_query($conn,$sql2);

                    //check whether query is executed or not
                    if($res2==true){

                        //Query Executed and order placed
                        $_SESSION['order'] = "<div style ='color:#2ed573; padding:2%' class='text-center'>Order Placed Successfully</div>";
                        header('location:'.SITEURL."front-end/index.php");
                    }
                    else{

                        //query is not executed
                        $_SESSION['order'] = "<div style ='color:#2ed573' class='text-center'>Failed to Order Food</div>";
                        header('location:'.SITEURL."front-end/index.php");
                    }

                }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include("../partials-front/footer.php"); ?>