<?php
include ("connectaddress.php");

if (isset($_POST['district_id'])) {
    $district_id = $_POST['district_id'];
    $query = "SELECT id, name FROM mandal WHERE district_id = $district_id";
    $result = $con->query($query);
    
    if ($result->num_rows > 0) {
        echo '<option value="" selected disabled>Select Mandal</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    } else {
        echo '<option value="">Mandal not available</option>';
    }
}
?>
