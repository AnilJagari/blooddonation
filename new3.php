<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "address";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of district names
$districts = [
    "ADILABAD",
    "BHADRADRI KOTHAGUDEM",
    "HANUMAKONDA",
    "HYDERABAD",
    "JAGTIAL",
    "JANGOAN",
    "JAYASHANKAR BHOOPALPALLY",
    "JOGULAMBA GADWAL",
    "KAMAREDDY",
    "KARIMNAGAR",
    "KHAMMAM",
    "KOMARAM BHEEM ASIFABAD",
    "MAHABUBABAD",
    "MAHABUBNAGAR",
    "MANCHERIAL",
    "MEDAK",
    "MEDCHAL-MALKAJGIRI",
    "MULUG",
    "NAGARKURNOOL",
    "NALGONDA",
    "NARAYANPET",
    "NIRMAL",
    "NIZAMABAD",
    "PEDDAPALLI",
    "RAJANNA SIRCILLA",
    "RANGAREDDY",
    "SANGAREDDY",
    "SIDDIPET",
    "SURYAPET",
    "VIKARABAD",
    "WANAPARTHY",
    "WARANGAL",
    "YADADRI BHUVANAGIRI"
];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO district (state_id, name) VALUES (?, ?)");
$stmt->bind_param("is", $state_id, $name);

$state_id = 1;

foreach ($districts as $name) {
    $stmt->execute();
}

echo "New records created successfully";

$stmt->close();
$conn->close();
?>
