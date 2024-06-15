<?php include("partials/menu.php")?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        
        <?php
          
          if(isset($_GET['id'])){
            $id = $_GET['id'];

          }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm password">
                    </td>
                </tr>
                   <td colspan="2">
                      <input type="hidden" name="id" value="<?php echo $id?>">
                      <input type="submit" name="submit" value="Change password" class="btn-secondary">
                   </td>
                 <tr>

                </tr>
            </table>
        </form>
    </div>
</div>

<?php

   //check whether the submit button is clicked or not
   if(isset($_POST['submit']))
   {
       
      //1.Get the data from form
      $id = $_POST['id'];
      $current_password = md5($_POST['current_password']);
      $new_password = md5($_POST['new_password']);
      $confirm_password = md5($_POST['confirm_password']);

      //2.check whether the user with current id and current password exist or not
      $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
      //Execute the query
      $res = mysqli_query($conn,$sql);

      if($res == true)
      {

          //Check whether the data is available or not
          $count = mysqli_num_rows($res);

          if($count == 1)
          {

             //User exists and password can be changed  and redirect
             //echo "user Found";
             //check whether the new password and old password matched or not
             if($new_password == $confirm_password)
             {

                  //update password
                  //create sql query 
                  $sql2 = "UPDATE tbl_admin SET
                           password = '$new_password'
                           WHERE id = $id
                           ";
                  //execute query
                  $res2 = mysqli_query($conn,$sql2);
                  //check whether the query is executed or not
                  if($res2 == TRUE){

                      //Display message
                      $_SESSION['change-pwd'] = "<div style ='color:#2ed573'>Password Changed Successfully</div>";
                      //Redirect the page
                      header('location:'.SITEURL."admin/manage-admin.php");
                  }
                  else{

                      //Display error message
                      $_SESSION['change-pwd'] = "<div style ='color:#ff4757'>Failed to Change Password</div>";
                      //Redirect the page
                      header('location:'.SITEURL."admin/manage-admin.php");
                      
                  }

             }
             else{
                 
                  //Failed to update and redirect to manage admin page with error message
                  $_SESSION['pwd-not-match'] = "<div style ='color:#ff4757'>Password not matched</div>";
                  //Redirect the page
                  header('location:'.SITEURL."admin/manage-admin.php");
             }
             
          }
         else
          {

              //user doesn't exist
              $_SESSION['user-not-found']="<div style ='color:#ff4757'>User Not Found</div>";
              //Redirect the page
              header('location:'.SITEURL."admin/manage-admin.php");
              
          }
      }
      
      //3.check whether the new password and confirm password matched or not
      
      //4.Change password if all above is true   

   }


?>

<?php include("partials/footer.php")?>