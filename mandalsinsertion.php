<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "address";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// List of mandals for Yadadri Bhuvanagiri district
$mandals = [
    "Addaguduru", "Alair", "Atmakur (M)", "Bibinagar", "Bhongir", "Bommalaramaram", 
    "Gundala", "Motakondur", "Mothkur", "Rajapet", "Turkapally", "Yadagirigutta", 
    "Bhoodan Pochampally", "Choutuppal", "Narayanpur", "Ramannapet", "Valigonda"
];

// Correct district_id for Yadadri Bhuvanagiri
$district_id = 32;  // Update district_id to 32

// Prepare SQL statement for mandal insertion
$sql_insert_mandal = "INSERT INTO mandal (mandal_name, district_id) VALUES (?, ?)";

// Prepare the insert statement
$stmt_insert = $conn->prepare($sql_insert_mandal);

// Loop through each mandal and insert it
foreach ($mandals as $mandal_name) {
    $stmt_insert->bind_param("si", $mandal_name, $district_id);
    $stmt_insert->execute();
}

echo "Mandals for district 'Yadadri Bhuvanagiri' have been inserted successfully.<br>";

// Close the statement and connection
$stmt_insert->close();
$conn->close();
?>
