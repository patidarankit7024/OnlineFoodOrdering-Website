<?php

// session start
      session_start();
    // constant to store none repeating values
    define('SITEURAL','http://localhost/food-order/');
    define('LOCALHOST','localhost:3306]');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food-order');
    
    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_connect_error());
    $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_connect_error());
?>