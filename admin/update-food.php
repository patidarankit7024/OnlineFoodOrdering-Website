<?php include("partials/menu.php") ?>

<?php
   // check weather the id is set or not
   if(isset($_GET['id']))
   {
    // Get all the deatils
    $id = $_GET['id'];
    // Ceate sql query to get all other details
    $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
    $res2 = mysqli_query($conn,$sql2);

    // get the value based on  query executed
    $row2 = mysqli_fetch_assoc($res2);

    // Get the indivisiual value from selected food
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];

   }
   else
   {
    // Ridirect to  Manage Food
    header('location:'.SITEURAL.'admin/manage-food.php');
   }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
                 <tr>
                    <td>Title: </td>
                    <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">      
                </td>
               </tr>

               <tr>
                <td>Current Image: </td>
                <td>
               <?php
               if($current_image == "")
               {
                // image not available
                echo "<div class ='error'>image not Available.</div>";
            
               }
               else
               {
                // image available
                ?>
                <img src="<?php echo SITEURAL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                <?php
               }
               
               ?>
                </td>
              </tr>
               

            <tr>
                <td>Select New Image: </td>
                <td>
                <input type="file" name="image">
                </td>
               </tr>


               <tr>
                <td>Category: </td>
                 <td>
                    <select name="category">
                           <?php
                                $sql="SELECT * FROM  tbl_category WHERE active='Yes'";

                                $res = mysqli_query($conn,$sql);
                                $count = mysqli_num_rows($res);
                                if($count>0)
                                {
                                    while($row= mysqli_fetch_assoc($res))
                                    {
                                        $category_title= $row['title'];
                                        $category_id=$row['id'];

                                        //echo "<option value = '$category_id'>$category_title</option>"
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php
                            
                                }
                            }
                                else
                                {
                                    echo "<option value='0'>category not available.</option>";
                                    }
                               ?>  
                               
                    </select>
                 </td>
               </tr>

               <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured =="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if($featured =="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
               </tr> 

               <tr>
                <td>Active: </td>
                <td>
                <input <?php if($active =="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                <input <?php if($active =="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                </td>
               </tr>

               <tr>
                 <td>
                 <input type="hidden" name="id" value="<?php echo $id; ?>">
                 <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">  
                 <input type="submit" name="submit" value="update food" class="btn-secondary">
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
           $description = $_POST['description'];
           $price = $_POST['price'];
           $current_image = $_POST['current_image'];
           $category = $_POST['category'];

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
                $tmp =explode('.',$image_name);        
                $ext = end($tmp);
         // Rename the image
        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;

        $src_path = $_FILES['image']['tmp_name']; // source path

        $dest_path = "../images/food/".$image_name;  // destination path
        // finally upoad the image
        $upload = move_uploaded_file($src_path,$dest_path);

        // check weather the image uploaded or not
        // and if the image is not uploaded then we will stopped the process and redirect with error massage
        if($upload==false)
        {
            //set message
            $_SESSION['upload'] = "<div class='error'>Failed to Upload new image.</div>";
            // Redirect to Add category page 
            header('location:'.SITEURAL.'admin/manage-food.php');
            // Stop the process
            die();
        }

         //B.  remove the current image if avaialable
         if($current_image != "")
         {
                 
         $remove_path = "../images/food/".$current_image;

         $remove = unlink($remove_path);
         // check weather the image is remove or not
         // if failed to remove then dispaly mmassage and stop the process
            if($remove==false)
            {
                // fails to remove current image
                $_SESSION['remove-failed'] = "<div class='error'>Fails to remove  current image.</div>";
                // Redirect to manage food 
                header('location:'.SITEURAL.'admin/manage-food.php');
                // stop the process
                die();
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

            // 4. update the food in database
            $sql3 = "UPDATE tbl_category SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id =' $category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
             ";
             
             // execute the query
            $res3 = mysqli_query($conn,$sql3);
            // check weather excuted or not
           if($res3==true)
           {
            // category updated
            $_SESSION['update'] = "<div class ='success'>Food Updated sucesfully.</div>";
            header('location:'.SITEURAL.'admin/manage-food.php');
           }
        else
    {
            $_SESSION['update'] = "<div class ='error'>Failed to update Food.</div>";
            header('location:'.SITEURAL.'admin/manage-food.php');
        }

             }

           ?>
       
    </div>
</div>
<?php include("partials/footer.php") ?>