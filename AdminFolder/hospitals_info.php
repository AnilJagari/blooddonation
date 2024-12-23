<?php
session_start();
function age_giver($dob){
    $dob = new DateTime($dob);
    $current = new DateTime();
    $diff = $current->diff($dob);
    $age = $diff->y;
    return $age;
}

include "../connect.php";
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$sql2 = "SELECT name FROM admin WHERE username='$username' AND password='$password'";
$res2 = $con->query($sql2);

if ($res2) {
    $row = $res2->fetch_assoc();
    $name = $row["name"];
    $con2 = new mysqli("localhost", "root", "", $name);

    if ($con2->connect_error) {
        die("Connection failed: " . $con2->connect_error);
    } else {
        $sql3 = "SELECT * FROM $name.hospital";
        $res3 = $con2->query($sql3);
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospitals Info</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .navbar {
        background-color: #007bff;
    }
    .navbar-brand, .nav-link {
        color: white !important;
    }
    .navbar .nav-link:hover {
        background-color: #0056b3;
    }
    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px; /* Add spacing between navbar and container */
    }
    table {
        margin-top: 20px;
    }
    .table thead {
        background-color: #007bff;
        color: white;
    }
    .btn-danger {
        margin-top: 20px;
    }
</style>

</head>
<body style="background-color: #b3e5fc;">

    <!-- Include Navbar File -->
    <?php include '../navbar.php'; ?> <!-- Assuming navbar.php is in the same directory -->

    <!-- Table Content -->
    <div class="container">
      
        <?php
        if ($res3 && $res3->num_rows > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<caption style='caption-side: top; font-weight: bold; text-align:center;'>List of Hospitals</caption>";
            echo "<thead >";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Uniq ID</th>";
            echo "<th>Type</th>";
            echo "<th>Phone</th>";
            echo "<th>Email</th>";
            echo "<th>State</th>";
            echo "<th>District</th>";
            echo "<th>Mandal</th>";
            echo "<th>Registration Date</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Loop through and output the table rows
            while ($row = $res3->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['uniqnumb']}</td>";
                echo "<td>{$row['htype']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['state']}</td>";
                echo "<td>{$row['district']}</td>";
                echo "<td>{$row['mandal']}</td>";
                echo "<td>{$row['registrationdate']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='text-center text-muted'>Your Account Doesn't Have Any Hospitals Yet</p>";
        }
        ?>
        <div class="text-center">
            <button class="btn btn-danger" onclick="window.location.href='account.php';">Back</button>
        </div>
    </div>

    <script src="../bootstrap.bundle.min.js"></script>
</body>
</html>
