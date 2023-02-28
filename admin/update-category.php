<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>
        <?php
        if(isset($_GET['id']))
        {
            // Get the id and all other details
           // echo "Getting the data";
           $id = $_GET['id'];
           // Ceate sql query to get all other details
           $sql = "SELECT * FROM tbl_category WHERE id = $id";
           $res = mysqli_query($conn,$sql);

           // count the rows to check weather th id is valid or not
           $count = mysqli_num_rows($res);

           if($count ==1)
           {
            // Get all the data
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $current_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
           }
           else
           {
            // redirect to manage category with session massage
            $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
            header('location:'.SITEURAL.'admin/manage-category.php');
           }

           
        }
        else
        {
            // redirect to manage category
            header('location:'.SITEURAL.'admin/manage-category.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if($current_image != "")
                        {
                            // Dispay th image
                            ?>
                            <img src="<?php echo SITEURAL; ?>images/category/<?php echo $current_image; ?>"width ="150px">
                            <?php
                        }
                        else
                        {
                            // display th massage
                            echo "<div class='error'>image not added.</div>";
                        }
                        ?>
                    </td>
                </tr>

               <tr>
                <td>New image: </td>
                <td>
                    <input type="file" name="image">
                </td>
               </tr>

               <tr>
                <td>Featured: </td>
                <td>
                <input <?php if($featured=="Yes"){echo 'checked';} ?> type="radio" name="featured" value="Yes"> Yes
                <input <?php if($featured=="No"){echo 'checked';} ?> type="radio" name="featured" value="No"> No
                </td>
               </tr>

               <tr>
               <td>Active: </td>
               <td>
               <input <?php if($active=="Yes"){echo 'checked';} ?> type="radio" name="active" value="Yes"> Yes
               
                <input <?php if($active=="No"){echo 'checked';} ?> type="radio" name="active" value="No"> No
             </td>
               </tr>

               <tr>
                <td>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">    
               <input type="submit" name="submit" value="update-Category" class="btn-secondary">
                </td>
              </tr>
           
            </table>
        </form>
        <?php
        
        if(isset($_POST['submit']))
        {
           // echo "clicked";
           // 1. Get all the value from our form
           $id = $_POST['id'];
           $title = $_POST['title'];
           $current_image = $_POST['current_image'];
           $featured = $_POST['featured'];
           $active = $_POST['active'];

           // 2. updating new image if selected

           // check weather the image is selected or  not 
           if(isset($_FILES['image']['name']))
           {
            // Get the image details
            $image_name = $_FILES['image']['name'];

            // check weather the image is available or not
            if($image_name != "")
            {
                // image availabele
                //A.  upload the new image
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
            header('location:'.SITEURAL.'admin/manage-category.php');
            // Stop the process
            die();
        }
                //B.  remove the current image if avaialable
                if($current_image!="")
                {
                        
                $remove_Path = "../images/category/".$current_image;

                $remove = unlink($remove_Path);
                // check weather the image is remove or not
                // if failed to remove then dispaly mmassage and stop the process
                if($remove==false)
                {
                    // Failed to remove the image
                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                    die(); // stop the process
                }
            }
              
            }
            else
            {
                $image_name = $current_image; 
            }
            
           }
           else
           {
            $image_name = $current_image;
           }

           //3. updated tghe databse 
           $sql2 = "UPDATE tbl_category SET
           title = '$title',
           image_name = '$image_name',
           featured = '$featured',
           active = '$active'
           WHERE id = $id
            ";

            // execute the query
            $res2 = mysqli_query($conn,$sql2);

           //4. redirect to manage category to leave mmassage
           // check weather excuted or not
           if($res2==true)
           {
            // category updated
            $_SESSION['update'] = "<div class ='success'>Category updated sucesfully.</div>";
            header('location:'.SITEURAL.'admin/manage-category.php');
        }
        else
        {
            $_SESSION['update'] = "<div class ='error'>Failed to update category.</div>";
            header('location:'.SITEURAL.'admin/manage-category.php');
        }


          }

        ?>
    </div>
</div>

<?php include("partials/footer.php") ?>