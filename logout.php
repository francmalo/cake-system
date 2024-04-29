<?php 
ob_start();
session_start();
include 'config.php';
unset($_SESSION['user_id']);
// Redirect to the login page or the homepage
header("Location: signin.php"); // Replace with your login page or homepage URL
?>