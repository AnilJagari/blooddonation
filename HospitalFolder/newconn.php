<?php
$host = 'localhost';      // Host name
$username = 'root';       // Database username
$password = '';           // Database password
$dbname = 'hospitala'; // Database name

// Create connection
$con = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
