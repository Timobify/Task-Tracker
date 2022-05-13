<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['uid']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}

$id = mysqli_real_escape_string($link,$_GET['id']);
$qry = ("DELETE FROM task WHERE id = '$id'");
$con = mysqli_query($link,$qry) or die(mysqli_error($link));
if(!$con)
{
    header("location: index.php");
}

else
{
    header("location: index.php");
}
?>
