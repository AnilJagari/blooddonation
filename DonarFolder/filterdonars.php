<?php
function agecategory($dob){
$dob=new DateTime($dob);
$current=new DateTime();
$diff=$current->diff($dob);
$age=$diff->y;
$min=18;
$mid1=40;
$mid2=50;
$max=55;
if($age<$min){
   echo "<h2>UNDER 18 YEARS OLD DONARS ARE NOT ALLOWED TO DONATE BLOOD</h2>";
   exit();
}
elseif($age>=$min and $age<=$mid1){
    return "A";
}
elseif($age>$mid1 and $age<=$mid2){
    return "B";
}
elseif($age>$mid2 and $age<=$max){
    return "c";
}
else{
    echo "<h2>ABOVE 55 YEARS AGE PEOPLE ARE NOT ALLOWED TO DONATE BLOOD</h2>";
    exit();
}

}
?>