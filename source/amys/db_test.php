<?php

//ENTER YOUR DATABASE CONNECTION INFO BELOW:
$hostname="db590462216.db.1and1.com:3306";
$database="db590462216";
$username="dbo590462216";
$password="yad2jaJ9oj7";

//DO NOT EDIT BELOW THIS LINE
$link = mysql_connect($hostname, $username, $password);
if (!$link) {
die('Connection failed: ' . mysql_error());
}
else{
     echo "Connection to MySQL server " .$hostname . " successful!
" . PHP_EOL;
}

$db_selected = mysql_select_db($database, $link);
if (!$db_selected) {
    die ('Can\'t select database: ' . mysql_error());
}
else {
    echo 'Database ' . $database . ' successfully selected!';
}

mysql_close($link);

?> 