<?php

    //Authorization or access Control
   //check whether the user is logged in or not
   if(!isset($_SESSION['user'])){ //if user session is not 
         
      //user is not logged in
      //Redirect to login page with message
      $_SESSION['no-login-msg'] = "<div class='text-center' style='color:#ff4757'>Please Login to Access Admin Panel</div>";
      //Redirect to login page
      header("location:".SITEURL."admin/login.php");
      

   }
   
?>