<?php 
session_start();
include "../connect.php";
date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$password = $_SESSION["password"]; 

// Query to fetch the admin's database name (which is the admin's name)
$sql1 = "SELECT name FROM admin WHERE username='$username' AND password='$password'";
$res1 = $con->query($sql1);

if ($res1 && $res1->num_rows > 0) {
    $row1 = $res1->fetch_assoc();
    $adminDatabaseName = $row1["name"];  // Admin name is the database name
    
    // Connect to the admin's specific database (where admin name is the database)
    $con2 = new mysqli("localhost", "root", "", $adminDatabaseName);
    if ($con2->connect_error) {
        die("Connection failed: " . $con2->connect_error);
    }
    
    // Query to fetch hospital names from the hospital table in the admin's specific database
    $sql2 = "SELECT name FROM hospital";  // Table name is 'hospital'
    $res2 = $con2->query($sql2);

    $didBloodgroup = []; // Associative array to store donor ID and blood group

    if ($res2 && $res2->num_rows > 0) {
        $totalHospitals = $res2->num_rows;
        while ($row2 = $res2->fetch_assoc()) {
            $hospitalName = $row2["name"];  // Get hospital name
            
            // Now connect to the hospital's specific database (where the hospital name is the database)
            $con3 = new mysqli("localhost", "root", "", $hospitalName);
            if ($con3->connect_error) {
                die("Connection failed: " . $con3->connect_error);
            }

            // Query to fetch donors whose dateofregister difference is more than 1 minute
            $sql3 = "SELECT did, bloodgroup FROM donars_info WHERE TIMESTAMPDIFF(MINUTE, dateofregister, '{$currentDateTime}') > 1";
            $res3 = $con3->query($sql3);

            if ($res3 && $res3->num_rows > 0) {
                while ($row3 = $res3->fetch_assoc()) {
                    $didBloodgroup[$row3["did"]] = $row3["bloodgroup"];  // Map donor ID to blood group
                   
                }
            }
            $sql4 = "DELETE FROM donars_info WHERE TIMESTAMPDIFF(MINUTE, dateofregister, '{$currentDateTime}') > 1";
            $res4 = $con3->query($sql4);
            if (!$res4) {
                echo "Error deleting records: " . $con3->error;
            }

            // Close the hospital's database connection
           
           

            $con3->close();
        }
    }
    foreach ($didBloodgroup as $did => $bloodgroup){
        $max=0;
        $sql4 = "SELECT name FROM hospital";  // Table name is 'hospital'
        $res4 = $con2->query($sql4);
        while ($row4 = $res4->fetch_assoc()){
            $hospitalName = $row4["name"];
            $con3 = new mysqli("localhost", "root", "", $hospitalName);
            if ($con3->connect_error) {
                die("Connection failed: " . $con3->connect_error);
            }
            $sql6 = "SELECT hid,min_bloodunits_required FROM hosp_blood_details WHERE  bloodgroup='$bloodgroup' ";
            $res6 = $con3->query($sql6);
            $row6 = $res6->fetch_assoc();
           
            $newmax=$row6["min_bloodunits_required"];

            if ($newmax>$max)
                {
                    $max= $newmax;
                     $didBloodgroup2[$bloodgroup] =$row6["hid"];
                    
                }
    
             
        }

    }
     
     asort($didBloodgroup);
     $did = array_keys($didBloodgroup);
     $i=0;
     foreach ($didBloodgroup2 as $bloodgroup2 => $hid){
        $sql7 = "SELECT name FROM hospital WHERE id='$hid'";
        $res7 = $con2->query($sql7);
        if ($res7) {
            $row7 = $res7->fetch_assoc();
            $newhosp = $row7["name"];
            $con5 = new mysqli("localhost", "root", "", $newhosp);

            if ($con5->connect_error) {
                die("Connection failed: " . $con5->connect_error);
            }
            
            $sql8 = "SELECT * FROM donar WHERE id='$did[$i]'";
            $res8 = $con2->query($sql8);
            if ($res8) {
                $row8 = $res8->fetch_assoc();
                $sql9 = "INSERT INTO donars_info (did,name, phone, email, gender, bloodgroup, aadhaar, dateofbirth, category,state, district, mandal, dateofregister) VALUES ('{$row8["id"]}', '{$row8["fullname"]}', '{$row8["phone"]}', '{$row8["email"]}', '{$row8["gender"]}', '{$row8["bloodgroup"]}', '{$row8["aadhaar"]}', '{$row8["dateofbirth"]}', '{$row8["category"]}', '{$row8["state"]}', '{$row8["district"]}', '{$row8["mandal"]}', NOW())";
                $res9 = $con5->query($sql9);
                if ($res9) {
                    $sql10 = "UPDATE donar SET lastdonationdate=NOW() WHERE id='$did[$i]'";
                    $res10 = $con2->query($sql10);
                    if ($res10) {
                        echo "done";
                    }
                }
            }
            
        }
        $i++;
     }

    // Close the admin's database connection
    $con2->close();
} else {
    echo "Invalid username or password.";
}

$con->close(); 
?>
