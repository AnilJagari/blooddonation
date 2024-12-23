<?php
session_start();
include "../connect.php";

// Initialize session variables
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$state = $_SESSION["state"];
$district = $_SESSION["district"];
$mandal = $_SESSION["mandal"];

// Fetch the admin name from the database
$sql1 = "SELECT name FROM admin WHERE state='$state' AND district='$district' AND mandal='$mandal'";
$res1 = $con->query($sql1);

if ($res1) {
    $row1 = $res1->fetch_assoc();
    $adminname = $row1["name"];
    $con2 = new mysqli("localhost", "root", "", $adminname);

    if (!$con2->connect_error) {
        $sql2 = "SELECT name FROM hospital WHERE username='$username' AND password='$password'";
        $res2 = $con2->query($sql2);

        if ($res2) {
            $row = $res2->fetch_assoc();
            $name = $row["name"];
            $con3 = new mysqli("localhost", "root", "", $name);

            if (!$con3->connect_error) {
                $sql3 = "SELECT DISTINCT * FROM hosp_donars_info";
                $res3 = $con3->query($sql3);

                if ($res3) {
                    $donors_data = [];
                    while ($row = $res3->fetch_assoc()) {
                        $donors_data[] = $row;
                    }
                }
                $con3->close();
            }
        }
        $con2->close();
    }
} else {
    echo "Error: " . $con->error;
}
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Donors</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            text-align: center;
            padding: 8px;
            border: 1px solid #dee2e6;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table caption {
            caption-side: top;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .btn-danger {
            margin-top: 10px;
        }

        .text-center img {
            margin: 0 5px;
        }

        @media (max-width: 768px) {
            table th, table td {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>
<body style="background-color: #b3e5fc;">

    <?php include '../navbar.php'; ?>

    <div class="container">
    
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <caption style="text-align: center; font-weight: bold;">Contact Donors</caption>
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Blood Group</th>
                        <th>Category</th>
                        <th>Mandal</th>
                        <th>Donation Date</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($donors_data) && count($donors_data) > 0): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($donors_data as $donor): ?>
                            <?php 
                                $age = age_giver($donor['dateofbirth']);
                                $datetime = new DateTime($donor['datetime']);
                                $formatted_date = $datetime->format('Y-m-d');
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= htmlspecialchars($donor['did']) ?></td>
                                <td><?= htmlspecialchars($donor['name']) ?></td>
                                <td><?= $age ?></td>
                                <td><?= htmlspecialchars($donor['gender']) ?></td>
                                <td><?= htmlspecialchars($donor['phone']) ?></td>
                                <td><?= htmlspecialchars($donor['email']) ?></td>
                                <td><?= htmlspecialchars($donor['bloodgroup']) ?></td>
                                <td><?= htmlspecialchars($donor['category']) ?></td>
                                <td><?= htmlspecialchars($donor['mandal']) ?></td>
                                <td><?= $formatted_date ?></td>
                                <td>
                                    <img src='../images/phonelogo.png' alt='phone' width='30'>
                                    <img src='../images/maillogo.jpg' alt='mail' width='30'>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center">No donors available yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <button class="btn btn-danger" onclick="window.location.href='account.php';">Back</button>
        </div>
    </div>

    <?php
    function age_giver($dob) {
        $dob = new DateTime($dob);
        $current = new DateTime();
        return $current->diff($dob)->y;
    }
    ?>
</body>
</html>
