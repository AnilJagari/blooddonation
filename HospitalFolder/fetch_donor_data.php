<?php
include "../connect.php";

// Get filter value from POST request
$filterValue = $_POST['filterValue'];
$hospital_name = "hospitalA"; // Replace with dynamic hospital name if needed

// Connect to hospital's database
$con->select_db($hospital_name);

// Build the query
$sql = "SELECT * FROM donars_info";
if ($filterValue !== "All") {
    $sql .= " WHERE bloodgroup = '$filterValue'";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-hover table-bordered'>";
    echo "<thead>
            <tr>
                <th>SL No</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Blood Group</th>
            </tr>
          </thead>";
    echo "<tbody>";
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$i}</td>
                <td>{$row['name']}</td>
                <td>{$row['dateofbirth']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['email']}</td>
                <td>{$row['bloodgroup']}</td>
              </tr>";
        $i++;
    }
    echo "</tbody></table>";
} else {
    echo "<p class='no-data'>No matching donors found.</p>";
}
?>
