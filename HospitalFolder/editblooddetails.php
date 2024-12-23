<?php
session_start();
include "../connect.php";

// Session and data fetching
$bloodgroup = $_GET["bloodgroup"] ?? null;
$username = $_SESSION["username"] ?? null;
$password = $_SESSION["password"] ?? null;
$state = $_SESSION["state"] ?? null;
$district = $_SESSION["district"] ?? null;
$mandal = $_SESSION["mandal"] ?? null;

// Fetch admin details for locality
$sql1 = "SELECT name FROM admin WHERE state='$state' AND district='$district' AND mandal='$mandal'";
$res1 = $con->query($sql1);

if ($res1 && $res1->num_rows > 0) {
    $row1 = $res1->fetch_assoc();
    $adminname = $row1["name"];
    $con2 = new mysqli("localhost", "root", "", $adminname);

    if ($con2->connect_error) {
        die("Connection failed: " . $con2->connect_error);
    }

    // Fetch hospital details
    $sql2 = "SELECT name FROM hospital WHERE username='$username' AND password='$password'";
    $res2 = $con2->query($sql2);

    if ($res2 && $res2->num_rows > 0) {
        $row = $res2->fetch_assoc();
        $name = $row["name"];
        $con3 = new mysqli("localhost", "root", "", $name);

        if ($con3->connect_error) {
            die("Connection failed: " . $con3->connect_error);
        }

        // Fetch blood details
        $sql3 = "SELECT * FROM hosp_blood_details";
        $res3 = $con3->query($sql3);
    } else {
        echo "Error: Query failed. " . $con2->error;
    }

    $con2->close();
} else {
    echo "Error: No matching admin found for your locality.";
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
            margin-top: 10px; /* Reduced margin */
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
            margin-top: 10px; /* Reduced margin */
        }

        .text-center {
            text-align: center;
        }

        .d-grid {
            display: grid;
            place-items: center;
        }

        caption {
    caption-side: top; /* Ensure the caption is displayed above the table */
    text-align: center; /* Center the caption text */
    font-weight: bold; /* Make the caption text bold */
    margin-bottom: 5px; /* Add spacing between the caption and the table */
        }

        .d-grid {
            margin-top: 10px; /* Reduced margin between table and back button */
        }
    </style>
</head>
<body style="background-color: #b3e5fc;">

    <!-- Include Navbar at the top -->
    <?php include "../navbar.php"; ?>

    <!-- Main Content Area -->
    <div class="container">
        
        <?php if ($res3 && $res3->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                <caption style="text-align: center; font-weight: bold;">Edit Blood Units</caption>

                    <thead class="bg-danger text-white">
                        <tr>
                            <th>SL No</th>
                            <th>Blood Group</th>
                            <th>Blood Units Used (Previous Month)</th>
                            <th>Total Blood Units Required</th>
                            <th>Minimum Blood Units Required</th>
                            <th>Blood Units Remaining</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php while ($row = $res3->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= htmlspecialchars($row['bloodgroup'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['bloodunits_used_previous_month'] ?? 'N/A') ?></td>

                                <?php if ($bloodgroup === $row["bloodgroup"]): ?>
                                    <form action='submitbrequired.php' method='post'>
                                        <td><input type='text' class='form-control' name='required' value='<?= htmlspecialchars($row["total_bloodunits_required"]) ?>'></td>
                                        <td><input type='text' class='form-control' name='min' value='<?= htmlspecialchars($row["min_bloodunits_required"]) ?>'>
                                        <input type='hidden' name='bloodgroup' value='<?= $bloodgroup ?>'></td>
                                        <td><?= htmlspecialchars($row['bloodunits_remain'] ?? 'N/A') ?></td>
                                        <td class="text-center">
                                            <input class="btn btn-danger" type="submit" name="submit" value="Submit">
                                        </td>
                                    </form>
                                <?php else: ?>
                                    <td><?= htmlspecialchars($row['total_bloodunits_required'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['min_bloodunits_required'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['bloodunits_remain'] ?? 'N/A') ?></td>
                                    <td class="text-center">—</td>
                                <?php endif; ?>

                            </tr>
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Back Button Centered Below the Table -->
            <div class="d-grid gap-2 d-md-flex justify-content-center mt-2">
                <button class="btn btn-danger" type="button" id="back">Back</button>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No blood details found.</p>
        <?php endif; ?>
    </div>

    <script>
        document.querySelector("#back").addEventListener("click", () => {
            window.location.href = "account.php";
        });
    </script>

</body>
</html>
