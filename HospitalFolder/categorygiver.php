<?php
session_start();
include "../connect.php"; // Ensure this includes the database connection

// Get POST parameters
$filterType = isset($_POST['filterType']) ? $_POST['filterType'] : null;
$filterValue = isset($_POST['filterValue']) ? rawurldecode($_POST['filterValue']) : null;  // Use rawurldecode to preserve '+' as '+'
$hospital_name = isset($_SESSION['hospitalname']) ? $_SESSION['hospitalname'] : null;

// Validate session and input
if (!$hospital_name || !$filterType) {
    echo "Error: Missing hospital name or filter type.";
    exit();
}

// Select the database for the hospital
$con->select_db($hospital_name);

// Initialize the SQL query
$sql = "SELECT * FROM donars_info WHERE 1";  // Base query

// Add filters to the query
if ($filterValue !== "All") {
    if ($filterType === 'bloodgroup') {
        $sql .= " AND bloodgroup = ?";
    } elseif ($filterType === 'category') {
        $sql .= " AND category = ?";
    } elseif ($filterType === 'age') {
        $sql .= " AND YEAR(CURDATE()) - YEAR(dateofbirth) = ?";
    } elseif ($filterType === 'gender') {
        $sql .= " AND gender = ?";
    }
}

// Prepare and execute the query
$stmt = $con->prepare($sql);
if ($filterValue !== "All") {
    $stmt->bind_param("s", $filterValue);  // Bind the filter value for query
}
$stmt->execute();
$result = $stmt->get_result();

// Check and display results
if ($result->num_rows > 0) {
    echo "<form action='alterforres.php' method='post' class='d-flex flex-column align-items-center'>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>SLNO</th><th>Donar ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Phone</th><th>Email</th><th>Blood Group</th><th>Category</th><th>Select</th></tr></thead>";
    echo "<tbody>";
    $i=1;
    while ($row = $result->fetch_assoc()) {
        $age = age_giver($row['dateofbirth']);  // Assuming this function calculates the donor's age
        echo "<tr>
                <td>$i</td>
                <td>{$row['did']}</td>
                <td>{$row['name']}</td>
                <td>{$age}</td>
                <td>{$row['gender']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['email']}</td>
                <td>{$row['bloodgroup']}</td>
                <td>{$row['category']}</td>
                <td><input type='checkbox' name='slno[]' value='{$row['did']}'></td>
              </tr>";
              $i++;
    }
    echo "</tbody></table>";
    echo "<button class='btn btn-danger mt-4' type='submit' name='response'>Respond</button>";
    echo "</form>";
} else {
    echo "<p class='no-data'>No matches found.</p>";
}

// Function to calculate the donor's age
function age_giver($dob) {
    $dob = new DateTime($dob);
    $current = new DateTime();
    $diff = $current->diff($dob);
    return $diff->y;
}
?>
