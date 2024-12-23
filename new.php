
<html>
    <head>
    <link rel="stylesheet" href="bootstrap.css">   
    </head>
<body>
<?php
$bloodgroup = array("All","O+", "O-", "A+", "A-", "B+", "B-", "AB+", "AB-", "OAB+", "OAB-");
$category = array("All","A", "B", "C");
$age = array("All","20", "21", "23", "26", "28");
$gender = array("All","Male", "Female", "Other");
session_start();
include "connect.php";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$state=$_SESSION["state"];
$district=$_SESSION["district"];
$mandal=$_SESSION["mandal"];
$sql1="select name from admin  where state='$state' and district='$district' and mandal='$mandal'";
$res1=$con->query($sql1);
if($res1){
  $row1=$res1->fetch_assoc();
  $adminname=$row1["name"];
  $con2=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$adminname);
  if($con2->connect_error){
     die("conection failed".$con2->connect_error);
  }else{
    $sql2="select name from hospital where username='$username' and password='$password'";
    $res2=$con2->query($sql2);
    if($res2){
      $row=$res2->fetch_assoc();
      $name=$row["name"];
      $con3=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$name);
      if($con3->connect_error){
        die("conection failed".$con3->connect_error);
      }else{
        $sql3="select * from donars_info";
        $res3=$con3->query($sql3);
        if($res3){
            echo "<table class='table table-striped table-hover'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Age</th>";
            echo "<th>Gender</th>";  
            echo "<th>Phone</th>";
            echo "<th>Email</th>";
             echo "<th>BloodGroup</th>";
             echo "<th>Category</th>";
             echo "<th>Select</th>";
             echo "</tr>";
            
             while($row=$res3->fetch_assoc()){
                echo "<tr>";
        
              
                  echo "<td>{$row['did']}</td>";
                  echo "<td>{$row['name']}</td>";
                  echo "<td>{$row['dateofbirth']}</td>";
                  echo "<td>{$row['gender']}</td>";
                  echo "<td>{$row['phone']}</td>";
                  echo "<td>{$row['email']}</td>";
                  
                  echo "<td>{$row['bloodgroup']}</td>";
                  
                 
                  echo "<td>{$row['category']}</td>";
                  
                 echo '<td><button id="button" class="btn btn-danger" >select</button></td>';
                  echo "</tr>"; 
                 
             }
             echo "</table>";
        }else{
            echo "Error: " . $con3->error;
        }
      }
    }else{
      echo "Error: " . $con2->error;
    }
  } 
  
}else{
  echo "Error: " . $con->error;
}

?>


   
</body>
</html>











<?php
$bloodgroup = array("All","O+", "O-", "A+", "A-", "B+", "B-", "AB+", "AB-", "OAB+", "OAB-");
$category = array("All","A", "B", "C");
$age = array("All","20", "21", "23", "26", "28");
$gender = array("All","Male", "Female", "Other");
session_start();
include "../connect.php";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$state=$_SESSION["state"];
$district=$_SESSION["district"];
$mandal=$_SESSION["mandal"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Radio Elements</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
        #buttonforselect{
            position: relative;
    
    margin-left:10px;
    border: none;
    background: #dc3545; /* Button background color */
    color:black; /* Button text color */
    cursor: pointer;
    font-size: 16px;
    border-radius: 4px;
    overflow: hidden;
    height:40px;
    text-align: center; /* Center text horizontally */
    text-align-last: center; /* Center text of selected option */
    display: flex; /* Enable flexbox layout */
    align-items: center; /* Center text vertically */
    justify-content: center;
        
           
        }
        #sort{
           
      appearance: none; /* Remove default select styling */
    -webkit-appearance: none;
    -moz-appearance: none;
    border: none;
    background: transparent;
    color: inherit;
    font: inherit;
    padding:0 15px; 
    padding-bottom:8px;
    width: 100%;
    height: 100%;
    cursor: pointer;
    outline: none;
    height:40px;

        }
       
      #outerdiv{
            
            position:relative;
            display:flex;
            flex-direction:row;
            justify-content: center;
            align-items: center;

        }
        #innerdiv{
            position:absolute;
            padding-left:30px;
            height:40px;
            width:120px;
        } 
        
       
  .radio-group {
    display: flex;
    gap: 10px;
}
.radio-group label {
    height:40px;
    padding: 10px 20px;
    border:none;
    border-radius: 4px;
    cursor: pointer;
    
}
.radio-group label.selected {
    color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}


  
    </style>
</head>
<body>
<div class="container">
<div class="container mt-5" id="outerdiv" >
    <div class="btn-group btn-group-toggle radio-group" data-toggle="buttons" id="radio-group" id="innerdiv">
        <!-- Radio buttons will be inserted here dynamically -->
    </div>
    <button class="button-wrapper" id="buttonforselect">
    <select class="form-select mt-3 " aria-label="Default Sort By" id="sort">
        <option value="bloodgroup" selected>Blood Group</option>
        <option value="category">Category</option>
        <option value="age">Age</option>
        <option value="gender">Gender</option>
    </select>
    </button>
</div>

<?php 
    $sql1="select name from admin  where state='$state' and district='$district' and mandal='$mandal'";
    $res1=$con->query($sql1);
    if($res1 && $row1=$res1->fetch_assoc()){
      $adminname=$row1["name"];
      $con2=new mysqli("localhost","root","",$adminname);
      if($con2->connect_error){
         die("conection failed".$con2->connect_error);
      }else{
        $sql2="select name from hospital where username='$username' and password='$password'";
        $res2=$con2->query($sql2);
        if($res2){
            if($res2->num_rows>0){
            $row=$res2->fetch_assoc();
          $name=$row["name"];
          $con3=new mysqli("localhost","root","",$name);
          if($con3->connect_error){
            die("conection failed".$con3->connect_error);
          }else{
            $sql3="select * from donars_info";
            $res3=$con3->query($sql3);
            if($res3){
                $array=array();
                echo "<table class='table table-striped table-hover'>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Name</th>";
                echo "<th>Age</th>";
                echo "<th>Gender</th>";  
                echo "<th>Phone</th>";
                echo "<th>Email</th>";
                 echo "<th>BloodGroup</th>";
                 echo "<th>Category</th>";
                 echo "<th>Select</th>";
                 echo "</tr>";
                 while($row=$res3->fetch_assoc()){
                    echo "<tr>";
                      echo "<td>{$row['did']}</td>";
                      echo "<td>{$row['name']}</td>";
                      echo "<td>{$row['dateofbirth']}</td>";
                      echo "<td>{$row['gender']}</td>";
                      echo "<td>{$row['phone']}</td>";
                      echo "<td>{$row['email']}</td>";
                      
                      echo "<td>{$row['bloodgroup']}</td>";
                      
                     
                      echo "<td>{$row['category']}</td>";
                      
                     echo '<td><button id="button".{$row["did"]} class="btn btn-danger" >select</button></td>';
                     $var= "button".$row["did"];
                     array_push($array,$var);
                      echo "</tr>"; 
                 }
                 echo "</table>";
                 
            }else{
                echo "Error: " . $con3->error;
            }
          }
        }else{
          echo "Error: " . $con2->error;
        }
    }
        else{
         echo "<h1>no donars</h1>";
        }
      } 
    
    }else{
      echo "Error: " . $con->error;
    }
    
?>
   

</table>
<div  class="d-flex justify-content-center align-items-center">
<button class="btn btn-danger" onclick="func1()">Respond</button>
</div>
</div>

<script>
    function func1(){
        
    }

    document.querySelector(".button").addEventListener("click",()=>{
    const btn= document.querySelector("#button");
    alert("yes");
    btn.innerText="selected";
    btn.style.border="none";
    if(btn.style.backgroundColor=="green"){ 
    btn.innerText="select";
    btn.style.border="none";
    btn.style.backgroundColor="#dc3545";
    }else{
        btn.innerText="selected";
        btn.style.border="none";
        btn.style.backgroundColor="green";
    }
    });
const data = {
    bloodgroup: <?php echo json_encode($bloodgroup); ?>,
    category: <?php echo json_encode($category); ?>,
    age: <?php echo json_encode($age); ?>,
    gender: <?php echo json_encode($gender); ?>
   
};


function updateRadioButtons(selectedItem) {
    const radioGroup = document.getElementById('radio-group');
    radioGroup.innerHTML = ''; // Clear existing buttons

    data[selectedItem].forEach(item => {
        var label = document.createElement('label');
        label.classList.add('btn');
        label.setAttribute('onclick', `openContent("${item}")`);

        var input = document.createElement('input');
        input.type = 'radio';
        input.name = selectedItem;
        input.value = item;
        label.style.backgroundColor="#dc3545";
        if(item==="All"){
            input.checked=true;
        }
        input.autocomplete = 'off';

        label.appendChild(input);
        label.appendChild(document.createTextNode(item));

        radioGroup.appendChild(label);
    });
}

document.getElementById('sort').addEventListener('change', (event) => {
    const selectedItem = event.target.value;
    updateRadioButtons(selectedItem);
});

// Initial load
updateRadioButtons('bloodgroup');

function openContent(choice){
    var item=document.querySelector("#sort").value;
    var xhr = new XMLHttpRequest();
    xhr.setRequestHeader("Content-type","application/X-WWW-form-urlencoded");
    xhr.send("item=" + encodeURIComponent(item) + "&choice=" + encodeURIComponent(choice));
    xhr.open('POST', 'categorygiver.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
         xhr.responseText;
        if(xhr.responseText=="successfull") {
            window.location.href="response.php";
         }
         else{
            alert(xhr.responseText);
            window.location.href="../home.php";
         }
        } else {
            console.error('Error: ' + xhr.statusText);
        }
    };
}
</script>

</body>
</html>
