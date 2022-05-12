<?php
session_start();
require_once '../connection.php';

if (isset($_POST['submit'])) {

    $decision = mysqli_real_escape_string($link,$_POST["decision"]);
    $id = mysqli_real_escape_string($link,$_POST["id"]);

    $query = "UPDATE `task` SET `status`='$decision' WHERE `id` = '$id'";
    $result = mysqli_query($link, $query);
    $status = "success";

}
