<?php
      
      //include constants.php for URL
      include("../config/constants.php");

     //1.Destroy the Session
     session_destroy(); 

     //2.Redirect to login page
     header("location:".SITEURL."admin/login.php");  


?>