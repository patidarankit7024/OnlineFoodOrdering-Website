<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
         <h1>Manage Food</h1>
         <br /><br />

<!-- button to add admin -->
<a href="<?php echo SITEURAL;  ?>admin/add-food.php" class="btn-primary">Add food</a>
<br /><br /><br />

<?php
        if(isset($_SESSION['add']))
        {
          echo $_SESSION['add'];
          unset($_SESSION['add']);
        }
        if(isset($_SESSION['delete']))
        {
          echo $_SESSION['delete'];
          unset($_SESSION['delete']);
        }
        if(isset($_SESSION['upload']))
        {
          echo $_SESSION['upload'];
          unset($_SESSION['upload']);     
        }
        if(isset($_SESSION['unauthorized']))
        {
          echo $_SESSION['unauthorized'];
          unset($_SESSION['unauthorized']);     
        }
        if(isset($_SESSION['failed-remove']))
        {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        
?>
<table class="tbl-full">
    <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>

<?php

    $sql = "SELECT * FROM tbl_food";

    // execute query
    $res = mysqli_query($conn,$sql);

    // count rows
    $count = mysqli_num_rows($res);

    // create serial no variable and assign value as 1
      $sn=1;
    
    // check weather we have data in database or not 
    if($count>0)
    {
      // we have data in database
      // get the data and display
      while($row = mysqli_fetch_assoc($res))
      {
        $id = $row['id'];
        $title = $row['title'];
        $price=$row['price'];
        $image_name = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
        ?>
        <tr>
           <td><?php echo $sn++; ?></td>
           <td><?php echo $title; ?></td>
           <td>Rs <?php echo $price; ?></td>
           <td>
                 <?php
                      
                      // check weather image is available or not
                      if($image_name=="")
                      {
                        echo"<div class='error'> Image not Added.</div>";
                      }
                      else
                      {
                            ?>
                            <img src="<?php echo SITEURAL;?>images/food/<?php echo $image_name;?>" width="100px">
                            <?php
                      }

                 ?>
           </td>
           <td><?php echo $featured; ?></td>
           <td><?php echo $active; ?></td>
           <td>
               <a href="<?php echo SITEURAL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
               <a href="<?php echo SITEURAL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
           </td>
            </tr>

        <?php
      }
    }
    else
    {
        echo "<tr> <td colspan='7' class ='error'> Food not Added Yet.</td></tr>";
    }

?>

        
</table>

    </div>
    
</div>

<?php include("partials/footer.php") ?>