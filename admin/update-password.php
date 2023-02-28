<?php include("partials/menu.php"); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password </h1>
        <br><br>
        <?php
             if(isset($_GET['id']))
             { 
               $id =$_GET['id'];
             }
        ?> 
    
          <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td> Current Password:</td>
                     <td>
                     <input type="Password" name="Current_Password" placeholder="current password">

                     </td>

                </tr>

                <tr>
                     <td> New Password:</td>
                     <td>
                     <input type="Password" name="New_Password" placeholder="new password">

                     </td>

                </tr>

                <tr>
                     <td> Confirm Password:</td>
                     <td>
                     <input type="Password" name="Confirm_Password" placeholder="Confirm Password">

                     </td>

                </tr>

                <tr>
                     <td colspan="2"> 
                     <input type="hidden" name="id" value="<?php  echo $id; ?>">
                     <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                     </td>

                </tr>

            </table>
               

        </form>
    </div>
</div>
<?php
  if(isset($_POST['submit']))
  {
    //echo "clicked";
    $id =$_POST['id'];
    $Current_Password= md5($_POST['Current_Password']);
    $New_Password= md5($_POST['New_Password']);
    $Confirm_Password= md5($_POST['Confirm_Password']);

    $sql = "SELECT * FROM tbl_admin WHERE id= $id AND password='$Current_Password'";
    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        $count= mysqli_num_rows($res);
    if($count==1)
    {
        //echo "User Found";
        if($New_Password==$Confirm_Password)
        {
            // update the password
            $sql2="UPDATE tbl_admin SET
                          password ='$New_Password'
                          WHERE id =$id
                          ";
                          $res2 = mysqli_query($conn,$sql2);
             if($res2==true)
             {
                // dispaly massage
                $_SESSION['Change-pwd']= "<div class='success'> Password Changes Successfully. </div>";
                            header('location:'.SITEURAL.'admin/manage-admin.php');
             }
             else
             {
                $_SESSION['Change-pwd']= "<div class='error'> Faoled to change password. </div>";
                header('location:'.SITEURAL.'admin/manage-admin.php');
             }

             
        }
        else{
            $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match.</div>";
            header('location:'.SITEURAL.'admin/manage-admin.php');
        }
    }
    else
    {
        $_SESSION['user-not-found']="<div class='error'>User-Not-Found. </div>";
        header('location:'.SITEURAL.'admin/manage-admin.php');
    }
    }
    
  }
  ?>

 <?php include("partials/footer.php"); ?>