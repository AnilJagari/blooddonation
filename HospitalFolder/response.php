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
        $sql2 = "SELECT id, name FROM hospital WHERE username='$username' AND password='$password'";
        $res2 = $con2->query($sql2);

        if ($res2) {
            $row2 = $res2->fetch_assoc();
            $hospname = $row2["name"];
            $_SESSION["hospitalname"] = $hospname;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Filter</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <script src="categorygiver.js" defer></script>
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .container { margin-top: 20px; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h1 { margin-bottom: 20px; font-size: 24px; font-weight: bold; color: #333333; }
        #sort { margin-bottom: 20px; padding: 10px; font-size: 16px; border-radius: 6px; border: 1px solid #ced4da; }
        .radio-group { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; }
        .radio-label { padding: 10px 20px; border: 2px solid #007bff; border-radius: 25px; cursor: pointer; text-align: center; transition: all 0.3s; color: #007bff; font-weight: bold; }
        .radio-label:hover { background-color: #007bff; color: white; }
        .radio-input { display: none; }
        .radio-input:checked + .radio-label { background-color: #007bff; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { text-align: center; padding: 12px; border: 1px solid #dee2e6; }
        table th { background-color: #007bff; color: white; }
        table tr:nth-child(even) { background-color: #f2f2f2; }
        .no-data { text-align: center; font-size: 16px; color: #6c757d; margin-top: 20px; }
    </style>
</head>
<body style="background-color: #b3e5fc;">
<?php include '../navbar.php'; ?>
<div class="container">
    <h3 class="text-center">Select Donors</h3>
    <div>
        <select id="sort" class="form-select">
            <option value="bloodgroup" selected>Blood Group</option>
            <option value="category">Category</option>
            <option value="age">Age</option>
            <option value="gender">Gender</option>
        </select>
        <div class="radio-group" id="radio-group"></div>
    </div>
    <div id="donor-table"></div>
</div>
</body>
</html>
