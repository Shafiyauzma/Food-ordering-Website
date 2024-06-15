<?php include("partials/menu.php");?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php

          if(isset($_SESSION['add'])){
             echo $_SESSION['add'];
             unset($_SESSION['add']);
          }
          if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
         }

        ?>

        <br><br>

        <!-- Add category starts here -->
         <form action="" method="POST" enctype="multipart/form-data">  <!--allow to upload file -->
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
         </form>

          <!-- Add category ends here -->

         <?php
              
              //check whether the submit button is clicked or not
              if(isset($_POST['submit'])){

                   //1.Get the value from the form
                    $title = $_POST['title'];

                   //For radio buttons we need to check whether the button is clicked or not
                   if(isset($_POST['featured'])){
                       
                       //Get the value from form
                       $featured = $_POST['featured'];
                   }
                   else{

                       //Set the default value
                       $featured = "No";

                   }
                   if(isset($_POST['active'])){
                       
                      //Get the value from form
                      $active = $_POST['active'];
                    }
                    
                    else{
                        //Set the default value
                        $active= "No";

                    }

                    //check whether the image is selected or not and set the image value accordingly
                    // print_r($_FILES['image']); //to insert array values

                    //die(); //break code
                    if(isset($_FILES['image']['name']))
                    {
                         //upload the image
                         //to upload the image we need image name,source path and destination path
                         $image_name=$_FILES['image']['name'];

                         //upload only image if it is selected 
                         if($image_name!="")
                         {
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
                            if($upload == false)
                            {

                                //set message
                                $_SESSION['upload'] = "<div style='color:#ff4757'>Failed to upload image</div>";
                                //redirect to add category page
                                header("location:".SITEURL."admin/add-category.php");

                                //stop the process
                                die();
                            }
                        }
                    }
                    else{

                        //don't upload the image and set the image name as blank
                        $image_name = "";

                    }

                    //2.Create sql query to insert data into database
                    $sql = "INSERT INTO tbl_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                            ";
                    //Execute the query
                    $res = mysqli_query($conn,$sql);

                    //check whether the query executed or not and data added or not
                    if($res == true){

                        //Data inserted
                        $_SESSION['add'] ="<div style ='color:#2ed573'>Category Added Successfully</div>";
                        //Redirect to manage-category page
                        header("location:".SITEURL."admin/manage-category.php");
                    }
                    else{

                        //Data is not inserted
                        $_SESSION['add'] ="<div style='color:#ff4757'>Failed to add Category</div>";
                        //Redirect to manage-category page
                        header("location:".SITEURL."admin/manage-category.php");
                    }
            
              }

         ?>
    </div>
</div>


<?php include("partials/footer.php");?>