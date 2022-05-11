<?php
$user = 'root';
$pass = '';
$host = 'localhost';
$database = 'e_tutoring';
$link = mysqli_connect($host,$user,$pass) or die('Unable to connect');


$query = "CREATE DATABASE IF NOT EXISTS e_tutoring;";
$result = mysqli_query($link, $query);

mysqli_select_db($link, $database);


	//header("Location: settingup.php");

