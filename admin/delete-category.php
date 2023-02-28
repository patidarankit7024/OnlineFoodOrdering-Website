<?php 
// include constants file
 include('config/constant.php');
 // echo "Delete Page";
 // check weather the id and image_name value is set or not
 if(isset($_GET['id']) AND isset($_GET['image_name']))
 {
    // get the value and delete
   // echo 'get value and delete';
   $id = $_GET['id'];
   $image_name = $_GET['image_name'];

   // remove the physical image file if available 
   if($image_name != "")
   {
    // image is availabel.so remove it
    $path = "../images/category/".$image_name;
    // remove the image
    $remove = unlink($path);
    // if failed to remove image then add an error massage and stop the proccess
    if($remove == false)
    {
     // set the session massage
     $_SESSION['remove'] = "<div class='error'>Failed to Remove category image.</div>";
     // redirect to manage category page
     header('location:'.SITEURAL.'admin/manage-category.php');
     // stop the process
     die();

    }
   }
   // delete data from database 
   // sql query delete data from database
   $sql = "DELETE FROM tbl_category WHERE id=$id";
   // execute the query
   $res = mysqli_query($conn,$sql);

   // check weather the data deleted from databse or not
   if($res == true)
{
    $_SESSION['delete'] = "<div class='success'>Category Deleted Succesfully.</div>";
    // Redirect to manage category page
    header('location:'.SITEURAL.'admin/manage-category.php');  
}
else
{
    $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>";
    // Redirect to manage category page
    header('location:'.SITEURAL.'admin/manage-category.php');
}
 }
 else
 {
    // Redirect to manage Category Page
    header('location:'.SITEURAL.'admin/manage-category.php');
 }
?>