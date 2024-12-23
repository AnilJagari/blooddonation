<?php
session_start();
include "../connect.php";
date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');
$did_bloodgroup = array();
$username = $_SESSION["username"];
$password = $_SESSION["password"]; 
$sql1 = "SELECT name FROM admin WHERE username='$username' AND password='$password'";
$res1 = $con->query($sql1);

if ($res1) {
    $row1 = $res1->fetch_assoc();
    $adminname = $row1["name"];

    // Establish connection to admin database
    $con2 = new mysqli("localhost", "root", "", $adminname);
    if ($con2->connect_error) {
        die("Connection failed: " . $con2->connect_error);
    }

    // Query to fetch hospitals under the admin
    $sql2 = "SELECT name FROM $adminname.hospital";
    $res2 = $con2->query($sql2);

    if ($res2) {
        if ($res2->num_rows > 0) {
            // Loop through each hospital
            while ($row2 = $res2->fetch_assoc()) {
                $hospname = $row2["name"];
                $con3 = new mysqli("localhost", "root", "", $hospname);
                if ($con3->connect_error) {
                    die("Connection failed: " . $con3->connect_error);
                }

                // Query to select donors whose donations need to be reset
                $sql3 = "SELECT did, bloodgroup FROM {$hospname}.donars_info WHERE TIMESTAMPDIFF(MINUTE, dateofregister, '{$currentDateTime}') > 30";
                $res3 = $con3->query($sql3);

                if ($res3) {
                    if ($res3->num_rows > 0) {
                        while ($row3 = $res3->fetch_assoc()) {
                            $did_bloodgroup[$row3["did"]] = $row3["bloodgroup"];
                        }
                    }

                    // Query to delete donors whose donations need to be reset
                    $sql4 = "DELETE FROM {$hospname}.donars_info WHERE TIMESTAMPDIFF(MINUTE, dateofregister, '{$currentDateTime}') > 30";
                    $res4 = $con3->query($sql4);

                    if (!$res4) {
                        echo "Error deleting records: " . $con3->error;
                    }
                } else {
                    echo "Error selecting records: " . $con3->error;
                }

                $con3->close();
            }
        } else {
            echo "No hospitals in your account yet";
        }
    } else {
        echo "Error: " . $con2->error;
    }

    // Process the donors and update accordingly
    if (!empty($did_bloodgroup)) {
       
        foreach ($did_bloodgroup as $did => $bloodgroup) {

            $sql5 = "SELECT id, name FROM $adminname.hospital";
            $res5 = $con2->query($sql5);

            if ($res5) {
                $requirearr = array();

                while ($row5 = $res5->fetch_assoc()) {
                    $hname = $row5["name"];
                   
                    $con4 = new mysqli("localhost", "root", "", $hname);

                    if ($con4->connect_error) {
                        die("Connection failed: " . $con4->connect_error);
                    }

                    $sql6 = "SELECT min_bloodunits_required FROM hosp_blood_details WHERE hid='{$row5["id"]}' and bloodgroup='{$bloodgroup}'";
                    $res6 = $con4->query($sql6);

                    if ($res6) {
                        $row6 = $res6->fetch_assoc();
                        $requirearr[$row5["id"]] = $row6["min_bloodunits_required"];
                    } else {
                        echo "Error: " . $con4->error;
                    }

                    $con4->close();
                }

                arsort($requirearr);
                $id = key($requirearr);
                $require = current($requirearr);

                $sql7 = "SELECT name FROM $adminname.hospital WHERE id='$id'";
                $res7 = $con2->query($sql7);

                if ($res7) {
                    $row7 = $res7->fetch_assoc();
                    $newhosp = $row7["name"];
                    $con5 = new mysqli("localhost", "root", "", $newhosp);

                    if ($con5->connect_error) {
                        die("Connection failed: " . $con5->connect_error);
                    }

                    $sql8 = "SELECT * FROM $adminname.donar WHERE id='$did'";
                    $res8 = $con2->query($sql8);

                    if ($res8) {
                        $row8 = $res8->fetch_assoc();
                        $sql9 = "INSERT INTO $newhosp.donars_info (did,name, phone, email, gender, bloodgroup, aadhaar, dateofbirth, category,state, district, mandal, dateofregister) VALUES ('{$row8["id"]}', '{$row8["fullname"]}', '{$row8["phone"]}', '{$row8["email"]}', '{$row8["gender"]}', '{$row8["bloodgroup"]}', '{$row8["aadhaar"]}', '{$row8["dateofbirth"]}', '{$row8["category"]}', '{$row8["state"]}', '{$row8["district"]}', '{$row8["mandal"]}', NOW())";
                        $res9 = $con5->query($sql9);

                        if ($res9) {
                            $sql10 = "UPDATE $adminname.donar SET lastdonationdate=NOW() WHERE id='$did'";
                            $res10 = $con2->query($sql10);

                            if ($res10) {
                                echo "done";
                            } else {
                                echo "Error updating donor: " . $con2->error;
                            }
                        } else {
                            echo "Error inserting donor info: " . $con5->error;
                        }
                    } else {
                        echo "Error selecting donor: " . $con2->error;
                    }

                    $con5->close();
                } else {
                    echo "Error selecting hospital: " . $con2->error;
                }
            } else {
                echo "Error selecting hospitals: " . $con2->error;
            }
        }
    } else {
        echo "no donars";
    }

    $con2->close();
} else {
    echo "Error selecting admin: " . $con->error;
}

$con->close();
?>
