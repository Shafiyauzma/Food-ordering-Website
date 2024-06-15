<?php include("../config/constants.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food-Order System</title>
    <link rel="stylesheet" href="../CSS/style1.css">
</head>
<body>
    <div class="login">
       
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
           
           if(isset($_SESSION['login'])){

                echo $_SESSION['login'];
                unset($_SESSION['login']);
           }
           if(isset($_SESSION['no-login-msg'])){

            echo $_SESSION['no-login-msg'];
            unset($_SESSION['no-login-msg']);
          }

        ?>
        <br><br>

        <!-- Login Form Starts here -->
         <form action="" method="POST" class="text-center">
            Username:
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password :
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
         </form>
        <!-- Login Form ends here -->
        <p class="text-center">Created by - <a href="#">Shafiya</a></p>
    </div>
    
</body>
</html>

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){

        //Process for Login
        //1.Get the data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2.sql query to check whether the user with the username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
        //3.Execute query
        $res = mysqli_query($conn,$sql);

        //4.count rows to check whether the user exist or not
        $count = mysqli_num_rows($res);

        if($count == 1){

            //User Available and login success
            $_SESSION['login'] = "<div style ='color:#2ed573'>Login Successfull</div>";
            $_SESSION['user'] = $username; //To check the user is logged in or not and logout will unset it
            //Redirect to Homepage/Dashboard
            header("location:".SITEURL.'admin/');

        }
        else{

            //user not Available and login Fail
            $_SESSION['login'] = "<div style='color:#ff4757' class='text-center'>Username or Password not Found</div>";
            //Redirect to Homepage/Dashboard
            header("location:".SITEURL.'admin/login.php');

        }

    }    



?>