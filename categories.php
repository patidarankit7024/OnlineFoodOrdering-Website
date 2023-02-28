<?php  include('partials-front/menu.php') ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
            // create sql query to display categories from database
            $sql = "SELECT * FROM tbl_category";
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);

            if($count>0)
            {
                // categorires available
                while($row = mysqli_fetch_assoc($res))
                {
                    // get the valus like title , image name and id
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    
                    <a href="<?php echo SITEURAL;?>category-foods.php?category_id=<?php echo $id ?>">
                    <div class="box-3 float-container">
                        <?php
                        // check wher the image available or not
                        if($image_name=="") 
                        {
                            // Display the massage
                            echo "<div class = 'error'>Image not Available</div>";
                        }
                        else
                        {
                           ?>
                            <img src="<?php echo SITEURAL;  ?>images/category/<?php echo $image_name;  ?>" alt="Pizza" class="img-responsive img-curve">
                           <?php
                        }
                        
                        ?>

                   <h3 class="float-text text-white"><?php echo $title ?></h3>
               </div>
              </a>
              
               <?php

             }
           }
        else
         {
          // CATEGORIES NOT AVAILABLE
              echo "<div class ='error'>Category not Added.</div>";
         }

            ?>


            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php  include('partials-front/footer.php') ?>
    