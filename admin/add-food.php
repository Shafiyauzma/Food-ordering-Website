<?php include("partials/menu.php")?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php

          if(isset($_SESSION['upload'])){
             
                 echo $_SESSION['upload'];
                 unset($_SESSION['upload']); 
          }

        ?>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name ="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name ="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name ="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                             
                               //1.create sql query to display categories from Database
                               $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                               //execute query
                               $res = mysqli_query($conn,$sql);

                               //count rows to check whether we have categories are not
                               $count = mysqli_num_rows($res);

                               //if count is greater than 0 we have categories else we don't have categories
                               if($count > 0){

                                  //we have categories
                                  while($row = mysqli_fetch_assoc($res)){

                                      //get the details of category
                                      $id = $row['id'];
                                      $title = $row['title'];
                                      ?>
                                       <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                      <?php
                                  }
                               }
                               else{

                                  //we don't have categories
                                  ?>
                                    <option value="0">No-Category-Found</option>
                                  <?php
                               }

                               //2.Display on dropdown

                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name ="featured" value="Yes">Yes
                        <input type="radio" name ="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name ="active" value="Yes">Yes
                        <input type="radio" name ="active" value="No">No
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

          //check whether the Add food button is clicked or not
          if(isset($_POST['submit'])){

              //Add the food in database
              //echo "clicked";
              //1.Get the data from form
              $title = $_POST['title'];
              $description = $_POST['description'];
              $price = $_POST['price'];
              $image_name = $_POST['image_name'];
              $category = $_POST['category'];
              
              //check whether radio button is set or not
              if(isset($_POST['featured'])){

                 $featured = $_POST['featured'];
              }
              else{

                 $featured = "No"; //setting the default value

              }
              if(isset($_POST['active'])){

                 $active = $_POST['active'];
             }
             else{

                 $active = "No"; //setting the default value
                
             }

              //2.upload the image if selected
              //check whether the select image is clicked or not and upload the image only if the image is selected
              if($_FILES['image']['name']){
                    
                  //Get the details of selected image
                  $image_name = $_FILES['image']['name'];

                  //check whether image is selected are not
                  if($image_name!=""){

                      //image is selected
                      //A.rename the image
                      //get the extensions of image
                      $ext = end(explode('.',$image_name));

                      //create new name
                      $image_name = "Food-name_".rand(000,999).".".$ext;

                      //B.upload the image
                      //get the source path and destination path
                      //source path is current path of image
                      $src = $_FILES['image']['tmp_name']; 

                      //destination path
                      $des = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$image_name;

                      //upload image
                      $upload = move_uploaded_file($src,$des);

                      //check whether image uploaded or not
                      if($upload == false){
                           
                            //fail to upload the image
                            //Redirect to add food page with message
                            $_SESSION['upload'] = "<div style='color:#ff4757'>Failed to upload image</div>";
                            header("location:".SITEURL."admin/add-food.php");
                            //stop the process
                            die();
                      }
                  }
              }
              else{

                  $image_name = ""; //setting defalut value asa none
              }

              //3.Insert into Database
              //create sql query to save data from database
              $sql2 = "INSERT INTO tbl_food SET
                       title='$title',
                       description = '$description',
                       price = $price,
                       image_name = '$image_name',
                       category_id = $category,
                       featured = '$featured',
                       active = '$active'
                       ";
                //execute sql query
                $res2 = mysqli_query($conn,$sql2);
                //check whether data is inserted or not

                if($res2 == true){

                    //data inserted successfully
                    $_SESSION['add'] = "<div style ='color:#2ed573'>Food Added Successfully</div>";
                    //Redirect to manage-food page
                    header("location:".SITEURL."admin/manage-food.php");

                }
                else{

                    //failed to insert data
                    $_SESSION['add'] = "<div style='color:#ff4757'>Failed to Add Food</div>";
                    //Redirect to manage-food page
                    header("location:".SITEURL."admin/manage-food.php");

                }
          }

        ?>

    </div>
</div>

<?php include("partials/footer.php")?>