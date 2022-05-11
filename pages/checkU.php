<?php
require_once 'connection.php';

$u = mysqli_real_escape_string($link, $_GET['username']);

$query = "SELECT * FROM `user` WHERE `username` = '$u'";
$result = mysqli_query($link, $query);
$numRows = mysqli_num_rows($result);

if($numRows > 0){
    $output = "<p style=\"color: red\">Sorry that Username is already taken try a new Username</p>";
}else if($numRows == 0){
    $output = "<p style=\"color: green\">That Username is avaliable you can proceed</p>";
}

echo $output;
