<?php






$sql6 = "SELECT hid,min_bloodunits_required FROM hosp_blood_details WHERE  bloodgroup='$bg' ";
$res6 = $con3->query($sql6);
$row6 = $res6->fetch_assoc();
$didBloodgroup2[$bg] = $row6["min_bloodunits_required"];
$newmax=$row6["min_bloodunits_required"];
echo $hospitalName;

echo $row6["min_bloodunits_required"];
echo "<br>";
echo "------";
if ($newmax>$max)
{
    $max= $newmax;

    $didBloodgroup2[$bg] = $max;
}



?>