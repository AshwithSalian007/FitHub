<?php
session_start();

unset($_SESSION['admin']);


// Redirect to the login page 
header("Location: login.php");
exit;
