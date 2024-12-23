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
        $sql3 = "SELECT * FROM $name.donar";
        $res3 = $con2->query($sql3);

        if ($res3) {
            $table_content = "";

            if ($res3->num_rows > 0) {
                function age_giver($dob)
                {
                    $dob = new DateTime($dob);
                    $current = new DateTime();
                    $diff = $current->diff($dob);
                    return $diff->y;
                }

                function format_date($date)
                {
                    $dateObj = new DateTime($date);
                    return $dateObj->format('Y-m-d'); // Show only the date in YYYY-MM-DD format
                }

                $i = 1;
                while ($row = $res3->fetch_assoc()) {
                    $table_content .= "<tr>";
                    $table_content .= "<td>$i</td>";
                    $table_content .= "<td>{$row['id']}</td>";
                    $table_content .= "<td>{$row['fullname']}</td>";
                    $table_content .= "<td>" . age_giver($row['dateofbirth']) . "</td>";
                    $table_content .= "<td>{$row['gender']}</td>";
                    $table_content .= "<td>{$row['phone']}</td>";
                    $table_content .= "<td>{$row['email']}</td>";
                    $table_content .= "<td>{$row['bloodgroup']}</td>";
                    $table_content .= "<td>{$row['category']}</td>";
                    $table_content .= "<td>{$row['state']}</td>";
                    $table_content .= "<td>{$row['district']}</td>";
                    $table_content .= "<td>{$row['mandal']}</td>";
                    $table_content .= "<td>" . format_date($row['registerdate']) . "</td>";
                    $table_content .= "<td>" . format_date($row['lastdonationdate']) . "</td>";
                    $table_content .= "</tr>";
                    $i++;
                }
            } else {
                $table_content = "<tr><td colspan='14' class='text-center'>No donors found.</td></tr>";
            }
        } else {
            $table_content = "<tr><td colspan='14' class='text-center'>Error: " . $con2->error . "</td></tr>";
        }
    }
}
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donors Info</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        /* Extend the container horizontally */
        .container {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: auto;
            width: 100%; /* Ensure the container expands to the full width of the parent */
            min-width: 100%; /* Ensure container takes minimum width */
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Ensure even distribution of space */
        }

        table caption {
            caption-side: top;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table th, table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6;
            word-wrap: break-word; /* Prevents content overflow */
        }

        table th {
            background-color: #007bff;
            color: white;
            white-space: nowrap; /* Prevents the header text from wrapping */
        }

        /* Specific column width adjustments */
        table th:nth-child(1), table td:nth-child(1) { 
            width: 4%; /* SLNo */
        }

        table th:nth-child(2), table td:nth-child(2) { 
            width: 4%; /* ID */
        }

        table th:nth-child(4), table td:nth-child(4) { 
            width: 3%; /* Age */
        }

        table th:nth-child(5), table td:nth-child(5) { 
            width: 5%; /* Gender */
        }
        table th:nth-child(8), table td:nth-child(8) { 
            width: 7%; /* Gender */
        }

        table th:nth-child(9), table td:nth-child(9) { 
            width: 6%; /* Gender */
        }
        table th:nth-child(10), table td:nth-child(10) { 
            width: 7%; /* Gender */
        }

        /* Button styling */
        .btn-danger {
            margin-top: 20px;
        }

        /* Make the table responsive on smaller screens */
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
        
        <?php if (!empty($table_content)) : ?>
            <table class="table table-striped table-hover">
                <caption>Donor Information</caption>
                <thead>
                    <tr>
                        <th>SLNo</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>BloodGroup</th>
                        <th>Category</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Mandal</th>
                        <th>Registration</th>
                        <th>LastDonation</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $table_content ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-center text-muted">No donor information available.</p>
        <?php endif; ?>

        <div class="text-center">
            <button class="btn btn-danger" onclick="window.location.href='account.php';">Back</button>
        </div>
    </div>

</body>
</html>
