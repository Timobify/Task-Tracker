<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['uid']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}
$userID = $_SESSION['uid'];
$notifyId = 1;

    $query = "UPDATE `task` SET `notify`='$notifyId' WHERE `uid` = ".$userID."";
    $result = mysqli_query($link,$query);
    header("Location: index.php");
    exit();

