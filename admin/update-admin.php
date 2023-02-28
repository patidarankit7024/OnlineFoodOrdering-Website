<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
    <h1>Update Admin</h1>

    <br><br>
    <?php
    // 1. Get the id of selected admin
    $id=$_GET['id'];
    // 2. create the sql query to get the deatils
    $sql="SELECT * FROM tbl_admin WHERE id=$id";
    // Execute the query
    $res=mysqli_query($conn,$sql);
    // check weather the query Executed or not
    if($res ==true)
                {
                  // echo "admin deleted";
                    // check weather the data is avilable or not
                     $count= mysqli_num_rows($res);
                     // check weather we have admin data or not
                     if($count==1)
                     {
                       // echo"Admin Available";
                       $row=mysqli_fetch_assoc($res);

                       $full_name = $row['full_name'];
                       $username = $row['username'];
                        
                     }
                     else
                     {
                        // Redirect to Mange admin page
                        header('location:'.SITEURAL.'admin/manage-admin.php');
                     }
                    
                }
    ?>
    <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                    <input type="text" name = "full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>
            <tr>
            <td>Username: </td>
            <td>
                <input type="text" name = "username" value="<?php echo $username; ?>">
            </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name = "submit" value="update admin" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
    </div>
</div>
<?php 
// check weather the submit button is clicked or not
if(isset($_POST['submit']))
{
    //echo "Button Clicked";
    // get all the value from form to update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $sql = "UPDATE tbl_admin SET
         full_name = '$full_name',
         username = '$username' 
         WHERE id='$id'
         ";
         // execute the equery
         $res = mysqli_query($conn, $sql);
         // check weathe rthe query executed succesfully or not
         if($res == true)
         {
             $_SESSION['update']="<div class='success'>Admin updated successfully.</div>";
             header('location:'.SITEURAL.'admin/manage-admin.php');
         }
         else
         {
            $_SESSION['update']="<div class='error'>Failed to Delete Admin.</div>";
             header('location:'.SITEURAL.'admin/manage-admin.php');
         }

         
}
?>
<?php include('partials/footer.php') ?>