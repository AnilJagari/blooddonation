<?php
session_start();
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
        $sql3 = "SELECT * FROM $name.hospital_donar";
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
    <title>Donars Info</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table caption {
            caption-side: top;
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        table th, table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .btn-danger {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            table th, table td {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body style="background-color: #b3e5fc;">
<?php include '../navbar.php'; ?> <!-- Include Navbar -->

    <div class="container">
        <?php
        if (isset($res3) && $res3->num_rows > 0) {
            echo "<table class='table table-striped table-hover'>";
            echo "<caption style='text-align:center;'>Hospital Donors Information</caption>";
            echo "<thead><tr>";
            echo "<th>SlNo</th>";
            echo "<th>Hosp ID</th>";
            echo "<th>Hosp Name</th>";
            echo "<th>Donar ID</th>";
            echo "<th>Donar Name</th>";
            echo "<th>HState</th>";
            echo "<th>HDistrict</th>";
            echo "<th>HMandal</th>";
            echo "<th>Date Of Done</th>";
            echo "</tr></thead><tbody>";

            $i = 1;
            while ($row = $res3->fetch_assoc()) {
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td>{$row['hid']}</td>";
                echo "<td>{$row['hname']}</td>";
                echo "<td>{$row['did']}</td>";
                echo "<td>{$row['dname']}</td>";
                echo "<td>{$row['hstate']}</td>";
                echo "<td>{$row['hdistrict']}</td>";
                echo "<td>{$row['hmandal']}</td>";
                echo "<td>{$row['dateofdone']}</td>";
                echo "</tr>";
                $i++;
            }

            echo "</tbody></table>";
        } else {
            echo "<p class='text-center text-muted'>Your Account Doesn't Have Any Donations Yet</p>";
        }
        ?>
        <div class="text-center">
            <button class="btn btn-danger" onclick="window.location.href='account.php';">Back</button>
        </div>
    </div>
</body>
</html>
