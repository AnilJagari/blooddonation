<?php 
session_start();
include "../connect.php";

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$state = $_SESSION["state"];
$district = $_SESSION["district"];
$mandal = $_SESSION["mandal"];

$sql1 = "SELECT name FROM admin WHERE state='$state' AND district='$district' AND mandal='$mandal'";
$res1 = $con->query($sql1);

if ($res1) {
    $row1 = $res1->fetch_assoc();
    $adminname = $row1["name"];
    $con2 = new mysqli("localhost", "root", "", $adminname);

    if ($con2->connect_error) {
        die("Connection failed: " . $con2->connect_error);
    } else {
        $sql2 = "SELECT name FROM hospital WHERE username='$username' AND password='$password'";
        $res2 = $con2->query($sql2);

        if ($res2) {
            $row = $res2->fetch_assoc();
            $name = $row["name"];
            $con3 = new mysqli("localhost", "root", "", $name);

            if ($con3->connect_error) {
                die("Connection failed: " . $con3->connect_error);
            } else {
                $sql3 = "SELECT * FROM $name.hosp_blood_details";
                $res3 = $con3->query($sql3);

                if ($res3) {
                    $blood_data = [];
                    while ($row = $res3->fetch_assoc()) {
                        $blood_data[] = $row;
                    }
                } else {
                    echo "Error: " . $con3->error;
                }
            }
            $con3->close();
        } else {
            echo "Error: " . $con2->error;
        }
    }
    $con2->close();
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
    <title>Hospital Blood Details</title>
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
        margin-top: 20px;
    }

    table caption {
        caption-side: top; /* Ensure the caption appears above the table */
        text-align: center; /* Center the caption */
        font-weight: bold; /* Make the text bold */
        margin-bottom: 10px; /* Add spacing below the caption */
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

    .btn-outline-success {
        font-size: 14px;
        padding: 5px 10px;
    }

    .btn-danger {
        margin-top: 20px;
    }
</style>

</head>
<body style="background-color: #b3e5fc;">

    <?php include '../navbar.php'; ?> <!-- Include Navbar -->

    <div class="container">
        
        <?php if (!empty($blood_data)) : ?>
            <table class="table table-striped table-hover">
            <caption style="text-align: center; font-weight: bold;">Hospital Blood Details</caption>
                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Blood Group</th>
                        <th>Blood Units Used (Last Month)</th>
                        <th>Total Blood Units Required</th>
                        <th>Minimum Blood Units Required</th>
                        <th>Blood Units Remaining</th>
                        <th>Edit Blood Units</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach ($blood_data as $row) : 
                        $encoded_bloodgroup = urlencode($row["bloodgroup"]); 
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row["bloodgroup"]); ?></td>
                            <td><?= htmlspecialchars($row["bloodunits_used_previous_month"]); ?></td>
                            <td><?= htmlspecialchars($row["total_bloodunits_required"]); ?></td>
                            <td><?= htmlspecialchars($row["min_bloodunits_required"]); ?></td>
                            <td><?= htmlspecialchars($row["bloodunits_remain"]); ?></td>
                            <td>
                                <a class="btn btn-outline-success" href="editblooddetails.php?bloodgroup=<?= $encoded_bloodgroup; ?>">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-center text-muted">No blood details available.</p>
        <?php endif; ?>

        <div class="text-center">
            <button class="btn btn-danger" onclick="window.location.href='account.php';">Back</button>
        </div>
    </div>
</body>
</html>
