<?php include("partials/menu.php");?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 

            if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; //Displaying message
                    unset($_SESSION['add']); //Removing session message
                    }
        ?>

        <br><br>

        <form action ="" method="POST">

        <table class="tbl-30">

            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name">
                </td>
            </tr>

            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name ="username" placeholder ="Enter Your Username">
                </td>
            </tr>

            <tr>
                <td>Password:</td>
                <td>
                    <input type="password" name ="password" placeholder ="Your Password">
                </td>
            </tr>
    
            <tr>
                <td colspan="2">
                    <input type ="submit" name ="submit" value ="Add Admin" class="btn-secondary">
                </td>
            </tr>

        </table>


        </form>

    </div>
</div>

<?php include("partials/footer.php");?>

<?php

   // Process the value from form and save into database
   //check whether the button is clicked or not
   if(isset($_POST['submit']))
   {

      //button clicked

      //1.Get the data from our form
      $full_name = $_POST['full_name'];
      $username = $_POST['username'];
      $password = md5($_POST['password']);

      //2.Sql query to save the data into database
      $sql = "INSERT INTO tbl_admin SET
              full_name = '$full_name',
              username = '$username',
              password = '$password' 
              ";

     
      //3.Execute Query and save data into datbase 
      $res = mysqli_query($conn,$sql) or die(mysqli_error($conn)); 

      //4.check whether query is executed or not and the data is inserted or not
      if($res == True){

        //Data inserted
        // echo "Data inserted";

        // create a session
         $_SESSION['add'] = "<div style ='color:#2ed573'>Admin Added Successfully</div>";
        //Redirecting the page to manage-Admin
         header("location:".SITEURL.'admin/manage-admin.php');
      }
      else{

        //Fail to insert data
        // echo "Failed to insert data";
         // create a session
         $_SESSION['add'] = "<div style='color:#ff4757'>Failed to Add Admin</div>";
        //Redirecting the page to manage-Admin
         header("location:".SITEURL.'admin/add-admin.php');
      }

   }

?>