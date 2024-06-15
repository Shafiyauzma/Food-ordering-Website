<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php

             //check whether id is set or not
             if(isset($_GET['id'])){

                 //update the Id and all other details
                 //echo "Getting data...";
                 $id = $_GET['id'];
                 //sql query to get all details
                 $sql = "SELECT * FROM tbl_category WHERE id=$id";
                 //execute query
                 $res = mysqli_query($conn,$sql);

                 //count the rows to check whether id is vaild or not
                 $count = mysqli_num_rows($res);

                 if($count == 1){

                     //Get all the data
                     $row = mysqli_fetch_assoc($res);

                     $title = $row['title'];
                     $current_image = $row['image_name'];
                     $featured = $row['featured'];
                     $active = $row['active'];

                 }
                 else{

                      //Redirect to manage category with session message
                      $_SESSION['no-category-found']="<div style ='color:#ff4757'>Category Not Found</div>";
                      header("location:".SITEURL."admin/manage-category.php");
                 }

             }
             else{

                 //Redirect to manage category
                 header("location:".SITEURL."admin/manage-category.php");
             }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                           
                           if($current_image!=""){

                              //Display the image
                              ?> 
                                <img src = "<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="150px">
                              <?php
                           }
                           else{
                               
                              //Display the message
                              echo "<div style='color:#ff4757'>Image is not Added</div>";
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
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
            
            if(isset($_POST['submit'])){

                // echo "clicked";
                //1.Get all data from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2.updating new image if selected
                //check whether the image is selected or not
                if(isset($_FILES['image']['name'])){
                      
                    //Get the image details
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is available or not
                    if($image_name!="")
                    {

                        //Image Available
                        //A.upload the new image

                        //Auto rename image
                        //get the extensions of our image  (jpg,png,gif etc) 
                        $ext = end(explode('.',$image_name));

                        //Rename the image now
                        $image_name = "Food-Category_".rand(000,999).'.'.$ext;
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path,$destination_path);

                        //check whether the image is uploaded or not
                        //if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div style='color:#ff4757'>Failed to upload image</div>";
                            //redirect to add category page
                            header("location:".SITEURL."admin/manage-category.php");
                            //stop the process
                            die();
                        }

                        //B.Remove the current image if available
                        if($current_image!="")
                        {

                            $remove_path = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$current_image;
                            $remove = unlink($remove_path);
                         
                            //check whether the image is removed or not
                            //if failed to to remove then display message and stop process
                            if($remove == false)
                            {
  
                                //Failed to remove image
                                $_SESSION['failed-remove'] = "<div style='color:#ff4757'>Failed to remove current image</div>";
                                header("location:".SITEURL."admin/manage-category.php");
                                die(); //stop the process
                            }
                            
                        }
                        
                    }
                    else{

                        $image_name = $current_image;
                    }
                }
                else{

                    $image_name = $current_image;
                }

                //3.update the database
                $sql2 = "UPDATE tbl_category SET 
                         title = '$title',
                         image_name = '$image_name',
                         featured = '$featured',
                         active = '$active'
                         WHERE id=$id
                         ";
                //execute the query
                $res2= mysqli_query($conn,$sql2);

                //4..Redirect to manage category with message
                //check whether query executed or not\
                if($res2 == true){

                    //category updated
                    $_SESSION['update']="<div style ='color:#2ed573'>Category Updated Successfully</div>";
                    //Redirect to manage-category page
                    header("location:".SITEURL."admin/manage-category.php");
                }
                else{

                    //failed to update
                    $_SESSION['update'] = "<div style='color:#ff4757'>Failed to Update</div>";
                    //Redirect to manage-category page
                    header("location:".SITEURL."admin/manage-category.php");
                }

            }

        ?>
    </div>
</div>

<?php include("partials/footer.php") ?>
