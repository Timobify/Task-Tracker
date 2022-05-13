<?php

$filename = "sqlData/ttracker.sql";


$templine = '';
$lines = file($filename);
foreach ($lines as $line){

	if (substr($line, 0, 2) == '--' || $line == '')
		continue;

		$templine .= $line;

		if (substr(trim($line), -1, 1) == ';')
		{

			mysqli_query($link, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($link) . '<br /><br />');

			$templine = '';
		}
}
header("Location: index.php");