<?php
include('includes/config.php');

// Connect to the database
//$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully" ."<br><br>";

$ipa = getenv("REMOTE_ADDR");
if ($ipa = '::1'){
  $ipaddress = "localhost";
} else {
  $ipaddress = $ipa;
}
Echo "Your IP Address is " . $ipaddress;


?>