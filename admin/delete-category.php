<?php

    // include constants file
   include('../config/constants.php');
   //echo "deleted";
   //check whether the id and image name value is set or not
   if(isset($_GET['id']) AND isset($_GET['id'])){

        //Get the value and delete
        // echo "get value";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file
        if($image_name!=""){

             //Image is available so remove it
             $path = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$image_name;
             //Remove the image
             $remove = unlink($path);

             //if failed to remove then send error message
             if($remove == false){

                //set the session message
                $_SESSION['remove']="<div style='color:#ff4757'>Failed to Remove Category Image</div>";
                //Redircet to manage category
                 header("location:".SITEURL."admin/manage-category.php");
                //stop the process
                die();

             }
        } 

         //Delete Data from Database
         //Sql query to delete data from database
         $sql = "DELETE FROM tbl_category WHERE id=$id";
         //execute query
         $res = mysqli_query($conn,$sql);

         //check whether the data is deletd or not from database
         if($res == true){

             //set success message
             $_SESSION['delete'] = "<div style ='color:#2ed573'>Category Deleted Successfully</div>";
             //Redirect to manage Category page with message
             header("location:".SITEURL."admin/manage-category.php");
         }
         else{

             //set fail message and redirect
             $_SESSION['delete'] = "<div style='color:#ff4757'>Failed to Delete Category</div>";
             //Redirect to manage Category page with message
             header("location:".SITEURL."admin/manage-category.php");

         }

   }
   else{

        //Redirect to manage category page
        header("location:".SITEURL."admin/manage-category.php");

   }


?>