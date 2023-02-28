<?php  include('config/constant.php');  ?>

<html>
    <head>
   <title>Login - Food Order System</title>
   <link rel="stylesheet" href="css/style.css">
   </head>

    <body>

        <div class="login">
              <h1 class="text-center">User Login</h1>
              <br><br>
                 
              <?php
                if(isset($_SESSION['login']))
                {
                  echo $_SESSION['login'];
                  unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login']))
                {
                  echo $_SESSION['no-login'];
                  unset($_SESSION['no-login']);
                }

              ?>
              <br><br>
              <form action="" method="POST" class="text-center">
                Username:<br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>
                 
                Password:<br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
              </form>
              <p class="text-center"> ----> <a herf ="https://www.geeksforgeeks.org/java/">Forgot Password ?</a></p>
              <br>
              <p class="text-center"> Created By- <a herf ="www.vijaythapa.com">Mini project team</a></p>
        </div>

    </body>
</html>

<?php
   if(isset($_POST['submit']))
   {

     $username = $_POST['username'];
     $password = md5($_POST['password']);

    $sql = "SELECT * FROM logintest WHERE username = '$username' AND password='$password'";
    $res = mysqli_query($conn,$sql);

    $count= mysqli_num_rows($res);
                    if($count==1)
                     {
                        $_SESSION['login']="<div   class ='success'> Login Successful.</div>";
                        $_SESSION['user'] = $username; // check weather the user loged in or not and logout will unset it
                        header('location:'.SITEURAL.'index.php');

                     }
                     else
                     {
                        $_SESSION['login']="<div   class ='error text-center'> Login Failed.</div>";
                        header('location:'.SITEURAL.'login.php');
                     }

    }

         ?>