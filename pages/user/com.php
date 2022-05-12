<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['uid']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $taskid = mysqli_real_escape_string($link, $_POST["tasks"]);
    $userID = mysqli_real_escape_string($link,$_POST["user"]);
    $commenter = mysqli_real_escape_string($link, $_POST["fullname"]);
    $details= mysqli_real_escape_string($link,$_POST["comment"]);
    $DateTime = date("Y/m/d");
    $query = "INSERT INTO comments (tid, uid, commenter, details, datetime) values
		('$taskid','$userID','$commenter','$details','$DateTime')";
    $result = mysqli_query($link,$query);
    header("Location: view.php?ID=".$taskid);
    exit();
}
?>