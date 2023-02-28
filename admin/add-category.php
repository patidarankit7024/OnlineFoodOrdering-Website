<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        if(isset($_SESSION['add']))
        {
          echo $_SESSION['add'];
          unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload']))
        {
          echo $_SESSION['upload'];
          unset($_SESSION['upload']);
        }
        ?>
        <!-- Add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data"> 
            <!-- enctype="multipart/form-data" allows us to upload file or image -->
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

               <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                </td>
               </tr>

               <tr>
                <td>Active: </td>
                <td>
                <input type="radio" name="active" value="Yes"> Yes
                <input type="radio" name="active" value="No"> No
                </td>
               </tr>

               <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add-Category" class="btn-secondary">
                </td>
               </tr>

            </table>
        </form>
        <!-- Add category form ends  -->

    <?php

    // check weather the submit button is clicked or not
    if(isset($_POST['submit']))
    {
       // echo "clicked";

       // 1. Get the value from the  category -form
       $title = $_POST['title'];

       // for radio input,we need to check weather the  button is selected or not
       if(isset($_POST['featured']))
       {
        $featured = $_POST['featured'];
       }
       else
       {
        // Set the Deafault value
        $featured = "No";
       }
       if(isset($_POST['active']))
       {
        $active = $_POST['active'];
       }
       else
       {
        $active = "No";
       }

       // Check weather the image is selected or  not and set the value for image name accordingly
    //    print_r($_FILES['image']);

    //    die();// break the code here
    if(isset($_FILES['image']['name']))
    {
        // uplod the image
        // To upload image we need image name,source path and destination path
        $image_name = $_FILES['image']['name'];
        // upload image only if image is selected 
        if($image_name != "")
        {
          
            
         // auto rename our image
         // Get the extension of our image(jpg,png,gif,etc) e.g ."food.jpg"
         $ext = end(explode('.',$image_name));
         // Rename the image
        $image_name = "food_category_".rand(000,999).'.'.$ext;


        $source_path = $_FILES['image']['tmp_name'];

        $destination_path = "../images/category/".$image_name;
        // finally upoad the image
        $upload = move_uploaded_file($source_path,$destination_path);

        // check weather the image uploaded or not
        // and if the image is not uploaded then we will stopped the process and redirect with error massage
        if($upload==false)
        {
            //set message
            $_SESSION['upload'] = "<div class='error'>Failed to upload the image. </div>";
            // Redirect to Add category page 
            header('location:'.SITEURAL.'admin/add-category.php');
            // Stop the process
            die();
        }
    }
    }
    else
    {
        // dont upload image and set the image _name value blank
        $image_name="";
    }
       // 2. create sql query to insert category into database
       $sql = "INSERT INTO tbl_Category SET
         title='$title',
         image_name = '$image_name',
         featured = '$featured',
         active = '$active'
         ";

         //3. Execute the query and save  in database
         $res = mysqli_query($conn,$sql);

         //4. check weather the query executed or  not  data added or not
         if($res==true)
         {
            // query executed and category added
            $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
            // Redirect to manage category page
            header('location:'.SITEURAL.'admin/manage-category.php');
         }
         else{
            // failed to add category
            $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
            header('location:'.SITEURAL.'admin/add-category.php');

         }
    }
    ?>

    </div>
</div>

<?php include('partials/footer.php') ?>