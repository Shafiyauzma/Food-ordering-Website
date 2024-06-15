<?php
     
      // Start the session
       session_start();

      //Create Constants to store Non-repeating values
      define('SITEURL','http://localhost:8080/Learnphp/FoodWebsite/');
      define('LOCALHOST','localhost');
      define('DB_USERNAME','root');
      define('DB_PASSWORD','');
      define('DB_NAME','Food-Order');

      $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn)); //Database Connection
      $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error($conn));

?>