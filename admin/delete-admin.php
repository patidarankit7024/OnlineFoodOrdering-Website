<?php
// include constant .php here
include('config/constant.php');

// 1. get the id of admin to be deleted.
  $id = $_GET['id'];

// 2. create sql query to Delete admin
$sql = "DELETE FROM tbl_admin WHERE id= $id";

// Execute the query
$res = mysqli_query($conn,$sql);

// check weather the query executed successfully or not
if($res == true)
{
    // Query Executed suucefully and admin deleted
    //echo "Admin deleted";
    // Create SESSION variable to Display Message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted succesfully.</div>";
    // Redirect to manage admin page
    header('location:'.SITEURAL.'admin/manage-admin.php');  
}
else{
    // failed to deleted admin
    //echo "Failed to delete admin";

    $_SESSION['delete ']="<div  class = 'error'> failed to delete admin. try again later.</div>";
      header('location:'.SITEURAL.'admin/manage-admin.php');

}

// 3. Redirect to Manage Admin page with message (succes/error)

?>