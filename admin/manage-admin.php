<?php include("partials/menu.php") ?>

    <!-- Main Section Starts -->
    <div class="main-content">
        <div class="wrapper">
           <h1>Manage Admin</h1>
           <br><br><br>
           <?php

              if(isset($_SESSION['add'])){
                  echo $_SESSION['add']; //Displaying message
                  unset($_SESSION['add']); //Removing session message
              }
              if(isset($_SESSION['delete'])){
                echo $_SESSION['delete']; //Displaying message
                unset($_SESSION['delete']); //Removing session message
            }
              if(isset($_SESSION['update'])){
                echo $_SESSION['update']; //Displaying message
                unset($_SESSION['update']); //Removing session message
            }
              if(isset($_SESSION['user-not-found'])){
                 echo $_SESSION['user-not-found'];
                 unset($_SESSION['user-not-found']);
              }
              if(isset($_SESSION['pwd-not-match'])){
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
             }
             if(isset($_SESSION['change-pwd'])){
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
           }

            ?>
            <br><br><br>

           <!-- Button to add Admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
           <br><br><br>

           <table class="tbl-full">

              <tr>
                <th>S.NO</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
              </tr>

                <?php 
                  
                  //Query to get all admins
                  $sql = "SELECT * FROM tbl_admin WHERE isDeleted=0";
                  //execute query
                  $res = mysqli_query($conn,$sql);

                  //check whether the query is executed or not
                  if($res == TRUE){

                      //Count rows and check whether the data in database or not
                      $count = mysqli_num_rows($res); //function to get all rows from database
                      $sn = 1;
                      //check the number of rows
                      if($count > 0){

                        //we have data in database
                        while($rows = mysqli_fetch_assoc($res))
                        {

                          //To get all the data from database
                          //Get individual data
                          $id = $rows['id'];
                          $full_name = $rows['full_name'];
                          $username = $rows['username'];

                          //Display the values in our table
                          ?>
                             <tr>
                                <td><?php echo $sn++;?></td>
                                <td><?php echo $full_name;?></td>
                                <td><?php echo $username;?></td>
                                <td>
                                    <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change password</a>
                                    <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                    <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                                </td>
                              </tr>
 
                          <?php

                        }

                      }
                      else{

                        //we don't have data in database
                        echo "we don't have data in database";

                      }
                  }

                 ?>
           </table>
        </div>
    </div>
    <!-- Main Section ends-->

<?php include("partials/footer.php") ?>