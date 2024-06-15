<?php include("partials/menu.php");?>

<?php 
    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //Get all details
        $id = $_GET['id'];

        //sql query to selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //execute query
        $res2 = mysqli_query($conn,$sql2);

        //get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //Redirect to manage food
        header("location:".SITEURL."admin/manage-food.php");
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                       <?php
                          if($current_image!="")
                          {
                              //Display the image
                              ?>
                                <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>"width="150px">
                              <?php
                          }
                          else
                          {
                             //Display the message
                             echo "<div style='color:#ff4757'>Image is not Added</div>";

                          }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                          <?php

                            //Query to get active category
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute query
                            $res = mysqli_query($conn,$sql);
                            //count rows
                            $count = mysqli_num_rows($res);

                            //check whether the category available or not
                            if($count > 0)
                            {
                                //category available
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    ?>
                                      <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //category not available
                                echo "<option value='0'>Category Not Available</option>";
                            }

                          ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
       </form>

       <?php

          //check whether submit button is clicked or nor
          if(isset($_POST['submit'])){

              //echo "clicked";
              //1.Get all details from form
              $id = $_POST['id'];
              $title = $_POST['title'];
              $description = $_POST['description'];
              $price = $_POST['price'];
              $current_image = $_POST['current_image'];
              $category = $_POST['category'];
              $featured = $_POST['featured'];
              $active = $_POST['active'];

              //2.upload image if selected
              //check whether upload button is clicked or not
              if(isset($_POST['submit']))
              {
                //button is clicked'
                $image_name = $_FILES['image']['name'];

                //check whether the file is available or not
                if($image_name!="")
                {
                    //image is available
                    //A.uploading New Image
                    //rename the image
                    $ext = end(explode('.',$image_name));

                    $image_name = "Food-Name".rand(000,999).'.'.$ext;

                    //get source and destination path
                    $src_path = $_FILES['image']['tmp_name'];
                    $des_path = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($src_path,$des_path);

                    //check whether the image is upladed or not
                    if($upload == false)
                    {

                          //fail to upload
                          $_SESSION['upload'] = "<div style='color:#ff4757'>Failed to Upload New Images</div>";
                          //redirect to manage food page
                          header("location:".SITEURL."admin/manage-food.php");
                          //stop the process
                          die();
                    }

                    //3.Remove image if an image is uploaded
                    //B.Remove current image if available
                    if($current_image!="")
                    {
                        //current image is available
                        //remove the image
                        $remove_path = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$current_image;

                        $remove = unlink($remove_path);

                        //check whether image is removed or not
                        if($remove == false)
                        {
                            //failed to remove image
                            $_SESSION['remove-failed'] = "<div style='color:#ff4757'>Failed to remove current image</div>";
                            //redirect to manage food page
                            header("location:".SITEURL."admin/manage-food.php");
                            //stop the process
                            die();

                        }
                    }

                }
                else
                {
                    $image_name = $current_image; //default image when image is not selected
                }

              }
              else
              {
                //button is not clicked
                $image_name = $current_image; //default image when button is not clicked
              }

              //4.update the food in database with session message
              $sql3 = "UPDATE tbl_food SET
                       title = '$title',
                       description = '$description',
                       price = $price,
                       image_name = '$image_name',
                       category_id='$category',
                       featured = '$featured',
                       active = '$active'
                       WHERE id=$id
                       ";
               //execute query
               $res3 = mysqli_query($conn,$sql3);

               //check whether the query is executed or not
               if($res3 == true){

                    //query executed
                    $_SESSION['update'] = "<div style ='color:#2ed573'>Food Updated Successfully</div>";
                    //Redirect to manage food page
                    header("location:".SITEURL."admin/manage-food.php");
               }
               else{
                    
                    //query is not executed
                    $_SESSION['update'] = "<div style='color:#ff4757'>Failed to Update Food</div>";
                    //Redirect to manage food page
                    header("location:".SITEURL."admin/manage-food.php");
               }
          }
    
       ?>

    </div>
</div>


<?php include("partials/footer.php");?>