<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
      <h1>Update Admin</h1>
      <br><br>

      <?php

        //1.Get the id of selected Admin
        $id = $_GET['id'];
        // 2.Sql query to get the data
        $sql="SELECT * FROM tbl_admin WHERE id=$id";
        // 3.Execute the query
        $res = mysqli_query($conn,$sql);

        // check whether the query is executed or not
        if($res == True){

            //Check whether the data is available or not
            $count = mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count == 1){

                //Get the details
                $row = mysqli_fetch_assoc($res);
                
                $full_name = $row["full_name"];
                $username = $row["username"];

            }
            else{

                //Redirect to Manage Admin page
                header("location:".SITEURL."admin/manage-admin.php");
            }
        }
 
      ?>
      <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name;?>">
                </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="username" value="<?php echo $username;?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="submit" class="btn-secondary">
                </td>
            </tr>

        </table>
      </form>
    </div>
</div>

<?php 

  // check whether the submit button is clicked or not
  if(isset($_POST['submit'])){

    //echo "button clicked";
    //Get all the value from form to update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //Create sql query to update Admin
    $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username'
            WHERE id='$id'
            ";

    // Execute query
    $res = mysqli_query($conn,$sql);

    //Check whether the query is executed successfully or not
    if($res == TRUE){

        //Query executed and admin updated
        $_SESSION['update'] = "<div style ='color:#2ed573'>Admin Updated Successfully</div>";
        //Redirect to manage admin page
        header("location:".SITEURL."admin/manage-admin.php");
    }
    else{

        //Failed to Execute
        //Query executed and admin updated
        $_SESSION['update'] = "<div style ='color:#ff4757'>Failed to Update</div>";
        //Redirect to manage admin page
        header("location:".SITEURL."admin/manage-admin.php");

    }

  }


?>

<?php include("partials/footer.php") ?>