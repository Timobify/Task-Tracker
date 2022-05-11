<?php
date_default_timezone_set("Africa/Lusaka");
$date=date('F j, Y g:i:a');

$link = mysqli_connect ( "localhost", "root", "" ) or die ( "Didn't connect" );
mysqli_select_db ( $link, "ttracker" );

?>