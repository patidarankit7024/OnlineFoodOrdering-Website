<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
        <?php
          if(isset($_SESSION['add'])) // checking weather the sesion  is saved or not
          {
             echo $_SESSION['add'];
             unset($_SESSION['add']);
          }
        

        ?>

        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td> Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your Name">
                    </td>
                </tr>
                <td> username: </td>
                   <td>
                      <input type="text" name="username"  placeholder="Enter your username">
                   </td>
               </tr>
               <tr>
               <td> Password:</td>
                   <td>
                      <input type="password" name="Password"  placeholder="Enter your Password">
                   </td>
                 </tr>
                 <tr>
               <td colspan="2">
                <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
               </td>
              </tr>
            </table>
     </form>
    </div>
</div>

<?php include("partials/footer.php"); ?>

<?php

if(isset($_POST["submit"]))
   { 
     // button clicked
     //echo "Button clicked";
     // Get the data from form
     $full_name = $_POST['full_name'];
       $username = $_POST['username'];
       $Password = md5($_POST['Password']);
 
       $sql ="INSERT INTO tbl_admin SET
       full_name='$full_name',
       username='$username',
       Password='$Password'";

// executing query and saving data into db
$res = mysqli_query($conn,$sql) or die(mysqli_connect_error());
     

// checking 
if($res==TRUE)
{
  // Data inserted
 // echo "data inserted";
 // create a session varaible to display
 $_SESSION['add'] = "<div class = 'success'>Admin Added Successfully.</div>";
 // redirect page.
        header("location:".SITEURAL.'admin/manage-admin.php');
}
else{
  // failed to insert data
 // echo "failed to inser t data";
 // create a session varaible to display
 $_SESSION['add'] = "Failed to Add Admin";
 // redirect page.
        header("location:".SITEURAL.'admin/manage-admin.php');
}
  }
    
?>