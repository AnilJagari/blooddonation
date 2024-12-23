<?php
include ("connectaddress.php");

if (isset($_POST['state_id'])) {
    $state_id = $_POST['state_id'];
    $query = "SELECT id, name FROM district WHERE state_id = $state_id";
    $result = $con->query($query);
    
    if ($result->num_rows > 0) {
        echo '<option value="" selected disabled>Select District</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    } else {
        echo '<option value="">District not available</option>';
    }
}
?>
