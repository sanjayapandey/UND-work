<?php
session_start();
$userId = $_GET['userId'];
$_SESSION['userid'] = $_GET['userId'];
$_SESSION['username']=$_GET['userName'];
header("Location: dashboard.php"); /* Redirect browser */
exit();
?>
