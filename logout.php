<?php
session_start();

unset($_SESSION['user_name']);


// Redirect to the login page 
header("Location: index.php");
exit;
