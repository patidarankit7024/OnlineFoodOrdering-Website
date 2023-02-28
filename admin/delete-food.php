<?php 
// include constants file
 include('config/constant.php');
 // echo "Delete Page";
 // check weather the id and image_name value is set or not
 if(isset($_GET['id']) && isset($_GET['image_name']))
 {
    // get the value and delete
   // echo 'get value and delete';s
   $id = $_GET['id'];
   $image_name = $_GET['image_name'];

   // remove the physical image file if available 
   if($image_name != "")
   {
    // image is availabel.so remove it
    $path = "../images/food/".$image_name;
    // remove the image
    $remove = unlink($path);
    // if failed to remove image then add an error massage and stop the proccess
    if($remove == false)
    {
     // set the session massage
     $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
     // redirect to manage category page
     header('location:'.SITEURAL.'admin/manage-food.php');
     // stop the process
     die();

    }
   }
   // delete data from database 
   // sql query delete data from database
   $sql = "DELETE FROM tbl_food WHERE id=$id";
   // execute the query
   $res = mysqli_query($conn,$sql);

   // check weather the data deleted from databse or not
   if($res == true)
{
    $_SESSION['delete'] = "<div class='success'>Food Deleted Succesfully.</div>";
    // Redirect to manage category page
    header('location:'.SITEURAL.'admin/manage-food.php');  
}
else
{
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
    // Redirect to manage Food  page
    header('location:'.SITEURAL.'admin/manage-food.php');
}
 }
 else
 {
    // Redirect to manage Food Page
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURAL.'admin/manage-food.php');
 }
?>