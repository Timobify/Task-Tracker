<?php
$user = 'root';
$pass = '';
$host = 'localhost';
$database = 'ttracker';
$link = mysqli_connect($host,$user,$pass) or die('Unable to connect');


$query = "CREATE DATABASE IF NOT EXISTS ttracker;";
$result = mysqli_query($link, $query);

mysqli_select_db($link, $database);


	//header("Location: settingup.php");

