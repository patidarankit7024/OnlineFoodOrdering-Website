<?php
include('config/constant.php');

session_destroy(); // unsets $_session['user']
header('location:'.SITEURAL.'admin/login.php');
?>