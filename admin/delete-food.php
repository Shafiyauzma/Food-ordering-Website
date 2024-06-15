<?php

     
    include("../config/constants.php");

    //check whether the value is passed on url or not
    if(isset($_GET['id']) && isset($_GET['image_name'])){

         //process to delete

         //1.Get id and image name
         $id = $_GET['id'];
         $image_name = $_GET['image_name'];

         //2.Remove the image if avilable
         //check whether image is available or not
         if($image_name!=""){

            //It has image and need to remove
            //get the img path
            $path = "/opt/lampp/htdocs/Learnphp/FoodWebsite/images/category/".$image_name;

            //Remove image
            $remove = unlink($path);

            //check whether the image is removed or not
            if($remove == false){

                //failed to remove
                $_SESSION['upload'] = "<div style='color:#ff4757'>Failed to Remove Image</div>";
                //Redirect to manage food page
                header("location:".SITEURL."admin/manage-food.php");
                //stop the process
                die();
            }
         }

         //3.Delete Food from Database
         //create sql query from database
         $sql = "DELETE FROM tbl_food WHERE id=$id";
         //execute query
         $res = mysqli_query($conn,$sql);

         //check whether the query is executed or not
         if($res == true){

            //Food Deleted
            $_SESSION['delete']="<div style ='color:#2ed573'>Food Deleted Successfully</div>";
            //Redirect to manage-food page
            header("location:".SITEURL."admin/manage-food.php");
         }
         else{

            //Failed to delete
            $_SESSION['delete']="<div style ='color:#ff4757'>Failed to Delete Food</div>";
            //Redirect to manage-food page
            header("location:".SITEURL."admin/manage-food.php");
         }
    }
    else{

       //Redirect to manage food page
       $_SESSION['unauthorize'] = "<div style='color:#ff4757'>UnAuthorized Access</div>";
       header("location:".SITEURL."admin/manage-food.php");

    }


?>