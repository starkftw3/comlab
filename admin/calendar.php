<?php 
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: adminlogin.php");
    exit();
}

$page = "Calendar";
include '../partial/sidebar.php';
include '../partial/header.php';


?>