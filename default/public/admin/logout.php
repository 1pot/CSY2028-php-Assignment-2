<?php
//it should work 
//session_destroy();
session_start();

unset($_SESSION['loggedin']);
unset($_SESSION['user_type_id']);
header('Location: https://v.je/admin/index.php');
 ?>