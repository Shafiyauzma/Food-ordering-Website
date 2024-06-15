<?php 
     
     //include constants file here
     include('../config/constants.php');

    //1.Get the id of admin to be deleted

     $id= $_GET['id'];

    //2.Create Sql query to delete admin
     $sql = "UPDATE  tbl_admin SET isDeleted = 1 WHERE id=$id";
    //3.Execute the query
     $res = mysqli_query($conn,$sql);

     //check whether the query is executed successfully or not
     if($res == True){

        //query executed successfully
        //create session variable
         $_SESSION['delete'] = "<div style ='color:#2ed573'>Admin Deleted Successfully</div>";
        //Redirect to manage admin page
         header("location:".SITEURL."admin/manage-admin.php");

     }
     else{

        //Failed to delete 
         //create session variable
         $_SESSION['delete'] = "<div style='color:#ff4757'>Failed to delete!! Try again Later</div>";
        //Redirect to manage admin page
         header("location:".SITEURL."admin/manage-admin.php");
     }


    //4.Redirect to manage admin page with message success or faliure


?>