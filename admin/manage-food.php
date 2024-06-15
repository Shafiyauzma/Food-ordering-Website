<?php include("partials/menu.php") ?>

    <!-- Main Section Starts -->
    <div class="main-content">
        <div class="wrapper">
           <h1>Manage Food</h1>
           <br><br>
           <?php
             
             if(isset($_SESSION['add'])){
                  echo $_SESSION['add'];
                  unset($_SESSION['add']);
             }
             if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
              }
              if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
              }
              if(isset($_SESSION['unauthorize'])){
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
              }
              if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
              }


           ?>
            <br><br><br>
                <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>
            <br><br><br>

            <table class="tbl-full">

            <tr>
                <th>S.NO</th>
                <th>Title</th>
                <th>price</th>
                <th>Image</th>
                <th>featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php

               //sql query to get all the food 
               $sql = "SELECT * FROM tbl_food";

               //execute the query
               $res = mysqli_query($conn,$sql);

               //count rows to check whether we have data in database are not
               $count = mysqli_num_rows($res);
               $sn=1;

               if($count > 0){

                    //we have data in database
                    //Get the food from database and display
                    while($row = mysqli_fetch_assoc($res)){

                        //get individual data
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                            <tr>
                                <td><?php echo $sn++;?></td>
                                <td><?php echo $title;?></td>
                                <td><?php echo $price;?></td>
                                <td>
                                    <?php
                                      //echo $image_name;
                                      //check whether we have image or not
                                      if($image_name!=""){
                                        //we have images and display in table
                                        ?>
                                         <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>"width="100px";>
                                        <?php
                                      }
                                      else{

                                         //image not exists
                                         echo "<div style='color:#ff4757'>Image not Added</div>";
                                      }
                                    ?>
                                </td>
                                <td><?php echo $featured;?></td>
                                <td><?php echo $active;?></td>
                                <td>
                                    <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
                                    <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Food</a>
                                </td>
                            </tr>
                        <?php

                    }

               }
               else{

                  //we dont have data in datbase
                  echo "<tr><td colspan = '2' style='color:#ff4757'>Food Not Added Yet</td></tr>";

               }

            ?>

            </table>
        </div>
    </div>
    <!-- Main Section ends-->

<?php include("partials/footer.php") ?>