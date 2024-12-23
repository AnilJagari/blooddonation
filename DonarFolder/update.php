<?php
session_start();
include "../connect.php";
$Mcheck='';
$Fcheck='';
$Ocheck='';
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$state=$_SESSION["state"];
$district=$_SESSION["district"];
$mandal=$_SESSION["mandal"];
$sql1="select name from admin where state='$state' and district='$district' and mandal='$mandal'";
$res1=$con->query($sql1);
if($res1){
  $row1=$res1->fetch_assoc();
  $adminname=$row1["name"];
  $con2=new mysqli("localhost","root","",$adminname);
  if($con2->connect_error){
     die("conection failed".$con2->connect_error);
  }else{
    $sql2="select * from $adminname.donar where username='$username' and password='$password'";
    $res2=$con2->query($sql2);
    if($res2){
      $row=$res2->fetch_assoc();
      $name=$row["fullname"];
      $delimitor1=" ";
      $token=explode($delimitor1,$name);
      $lastname=$token[0];
      $firstname=$token[1];
      $phone=$row["phone"];
      $email=$row["email"];
      $dob=$row["dateofbirth"];
      $delimitor2="-";
      $tokens=explode($delimitor2,$dob);
      $year=$tokens[0];
      $month1=$tokens[1];
      $date=$tokens[2];
      $aadhaar=$row["aadhaar"];
      $gender=$row["gender"];
      $aadhaar=$row["aadhaar"];
$gender=$row["gender"];
if($gender=="Male"){
  $Mcheck="checked";
}
if($gender=="Female"){
  $Fcheck="checked";
}
if($gender=="Other"){
  $Ocheck="checked";
}
$bloodgroup=$row["bloodgroup"];
$state=$row["state"];
$district=$row["district"];
$mandal=$row["mandal"];
    }else{
      echo "Error: " . $con2->error;
    }
  }
  $con2->close();
}else{
  echo "Error: " . $con->error;
}

$con->close();
?>
<!DOCTYPE html>
<html>
  <head><title>update donar info</title>
  <link rel="stylesheet" href="../bootstrap.css">
</head>
    <body>


    <section class="bg-light py-3 py-md-5"  id="section2" >
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5"> 
          <div class="text-center mb-3">
          <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Enter Your Details </h2>
          </div>
         <?php echo "<form id='updatedonarinfo'>"; ?>
            <div class="row gy-2 overflow-hidden">
              <div class="col-12">
               <div class="form-floating mb-3">
                  <input class="form-control" name="firstname" id="firstname" placeholder="firstname" value="<?php echo $firstname; ?>">
                  <label for="firstname" class="form-label">Firstname</label>
                  <b><span class="badge bg-danger" id="fnameerror"></span></b>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-3">
                  <input class="form-control" name="lastname" id="lastname" placeholder="lastname" value="<?php echo $lastname; ?>">
                  <label for="lastname" class="form-label">Lastname</label>
                  <b><span class="badge bg-danger" id="lnameerror"></span></b>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-3">
                   <input class="form-control" name="phone" id="phone"  placeholder="phone" value="<?php echo $phone; ?>" >
                   <label for="phone" class="form-label">Phone</label>
                    <b><span class="badge bg-danger" id="phoneerror"></span></b>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="email" id="email"  placeholder="email" value="<?php echo $email; ?>">
                    <label for="email" class="form-label">Email</label>
                    <b><span class="badge bg-danger" id="emailerror"></span></b>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="aadhaar" id="aadhaar"  placeholder="aadhaar"  value="<?php echo $aadhaar; ?>">
                    <label for="aadhaar" class="form-label">Aadhaar</label>
                    <b><span class="badge bg-danger" id="aadhaarerror"></span></b>
                  </div>
                </div>

   <div class="container mt-3">  
   <p><b>Gender</b></p>         
   <div class="form-check">
      <input type="radio" class="form-check-input" id="male" name="gender"  value="Male" <?php echo $Mcheck; ?>>
      <label class="form-check-label" for="male">Male</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="female" name="gender"  value="Female" <?php echo $Fcheck; ?>>
      <label class="form-check-label" for="female">Female</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="other" name="gender"  value="Other" <?php echo $Ocheck; ?>>
      <label class="form-check-label" for="other">Other</label>
    </div>
    <b><span class="badge bg-danger" id="gendererror"></span></b>
   </div>
   <div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example" id="bloodgroup" name="bloodgroup">
  <option >select your blood group</option>

  <?php 
          $bloodgrouparr=array("O+","O-","A+","A-","B+","B-","AB+","AB-","OAB+","OAB-");
          sort($bloodgrouparr);
          foreach($bloodgrouparr as $bg){
            if($bloodgroup==$bg){
              echo "<option selected>".$bg."</option>";
          }
          else{
            echo "<option value= $bg >".$bg."</option>";
          }
        }
          ?>
  </select>
  <b><span class="badge bg-primary" id="bloodgrouperror"></span></b>
</div> 

<!-- date of birth-->
<div class="container mt-3">
<p><b>Date Of Birth</b></p> 
<div class="row"> 
  <div class="col">
<select class="form-select" aria-label="Default select example" id="date" name="date">
  <option >DD</option>
<?php
        for($i=1;$i<=31;$i++){
            if($i==$date){
            echo "<option selected>{$i}</option>";
            }
            else{
              echo "<option>".$i."</option>";
            }
        }
        ?>
  </select>
  </div>
  <div class="col">
  <select class="form-select" aria-label="Default select example" id="month" name="month">
  <option selected>MM</option>
<?php
        $montharr=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        foreach($montharr as $key=>$month){
            $newkey=$key+1;
            if($newkey==$month1){

            echo "<option selected>".$month."</option>";
            }
            else{
              echo "<option value=$newkey>".$month."</option>";
            }
        }
        ?>
  </select>
  </div>
  <div class="col">
  <select class="form-select" aria-label="Default select example" id="year" name="year">
  <option selected>YYYY</option>
  <?php
        $startyear=1964;
        $endyear=date('Y');
        for($i=$startyear;$i<=$endyear;$i++){
          if($i==$year){
            echo "<option selected>{$i}</option>";
          }
          else{
            echo "<option value=$i>".$i."</option>";
          }
        }
        ?>


  </select>
  </div>
</div>
<b><span class="badge bg-danger" id="dateerror"></span></b>
</div>

<!-- drop down-->
<div class="container mt-3">  
   <select class="form-select" aria-label="Default select example" id="stateDropdown" name="state">
  <option value="" selected disabled>select your state</option>
  <?php 
include ("../connectaddress.php");
$sql2="select id,name from state";
$res2=$con->query($sql2);
if($res1){
    while($st=$res2->fetch_assoc()){
        if($state==$st["name"]){  ?>
            <option value="<?php echo $st["id"];?>" selected><?php echo $st["name"];?></option> 
      <?php  }else{ ?>
        <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
       <?php }?>
        <?php 
        }
        }else{
         echo "error :".$con->error;
        }
        ?>   
  </select>
  <b><span class="badge bg-danger" id="stateerror"></span></b>
</div> 
<div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example"  id="districtDropdown" name="district">
  <option value="" selected disabled>select your district</option>
  <?php 
$sql2="select id,name from district";
$res2=$con->query($sql2);
if($res1){
    while($st=$res2->fetch_assoc()){
        if($district==$st["name"]){  ?>
            <option value="<?php echo $st["id"];?>" selected><?php echo $st["name"];?></option> 
      <?php  }else{ ?>
        <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
       <?php }?>
        <?php 
        }
        }else{
         echo "error :".$con->error;
        }
        ?>   
  

  </select>
  <b><span class="badge bg-danger" id="districterror"></span></b>
</div> 
<div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example"  id="mandalDropdown" name="mandal">
  <option value="" selected disabled>select your mandal</option>
  <?php 
$sql2="select id,name from mandal";
$res2=$con->query($sql2);
if($res1){
    while($st=$res2->fetch_assoc()){
        if($mandal==$st["name"]){  ?>
            <option value="<?php echo $st["id"];?>" selected><?php echo $st["name"];?></option> 
      <?php  }else{ ?>
        <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
       <?php }?>
        <?php 
        }
        }else{
         echo "error :".$con->error;
        }
        $con->close();?>   
  </select>
  <b><span class="badge bg-danger" id="mandalerror"></span></b>
</div> 

<div class="d-flex pt-5">
              <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger me-1 flex-grow-1" id="cancel">Cancel</button>
                <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary flex-grow-1" id="update">Update</button>
              </div>
</div>
<?php echo "</form>"; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    </body>
<script>
  function test_input(data){
        function stripslashes(str){
          return str.replace(/\\/g,'');
        }
        data=data.trim();
        data=stripslashes(data);
        return data;
       }
       document.querySelector("#cancel").addEventListener("click", ()=> {
        window.location.href="account.php";
       });

    document.querySelector("#update").addEventListener("click", ()=> {
        let flag=true;
        let fnameerr=document.querySelector("#fnameerror");
        let lnameerr=document.querySelector("#lnameerror");
        let phoneerr=document.querySelector("#phoneerror");
        let emailerr=document.querySelector("#emailerror");
        let aadhaarerr=document.querySelector("#aadhaarerror");
        let gendererr=document.querySelector("#gendererror");
        let bloodgrouperr=document.querySelector("#bloodgrouperror");
        let dateerr=document.querySelector("#dateerror");
        let stateerr=document.querySelector("#stateerror");
        let districterr=document.querySelector("#districterror");
        let mandalerr=document.querySelector("#mandalerror");
        fnameerr.innerText="";
        lnameerr.innerText="";
        phoneerr.innerText="";
        emailerr.innerText="";
        aadhaarerr.innerText="";
        gendererr.innerText="";
        bloodgrouperr.innerText="";
        dateerr.innerText="";
        stateerr.innerText="";
        districterr.innerText="";
        mandalerr.innerText="";
        var fname=test_input(document.querySelector("#firstname").value);
        var lname=test_input(document.querySelector("#lastname").value);
        var phone=test_input(document.querySelector("#phone").value);
        var email=test_input(document.querySelector("#email").value);
        var aadhaar=test_input(document.querySelector("#aadhaar").value);
        var gender=document.querySelector("input[name='gender']:checked");

        if(gender){
          var gendervalue=gender.value;
        }
        else{
          gendererr.innerText="gender not selected";
          flag=false;

        } 
        var bg=document.querySelector("#bloodgroup");
        if(bg.value=="select your blood group"){
          bloodgrouperr.innerText="select bloodgroup only if you know (optional)";
        }
        var dt=document.querySelector("#date");
        if(dt.value=="DD"){
          dateerr.innerText="Date of birth not selected properly";
          flag=false;
        }
        var mnt=document.querySelector("#month");
        if(mnt.value=="MM"){
          dateerr.innerText="Date of birth not selected properly";
          flag=false;
        }
        var yer=document.querySelector("#year");
        if(yer.value=="YYYY"){
          dateerr.innerText="Date of birth not selected properly";
          flag=false;
        }
        var st=document.querySelector("#stateDropdown");
        if(st.value=="select your state"){
          stateerr.innerText="state not selected";
          flag=false;
        }
        var dist=document.querySelector("#districtDropdown");
        if(dist.value=="select your district"){
          districterr.innerText="district not selected";
          flag=false;
        }   
        var mdl=document.querySelector("#mandalDropdown");
        if(mdl.value=="select your mandal"){
          mandalerr.innerText="mandal not selected";
          flag=false;
        }                  
        const nameregex=/^[A-Za-z]+$/;
        const phoneregex=/^\d{10}$/;
        const aadhaarregex=/^\d{12}$/;
        const emailregex= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if(fname===""){
          fnameerr.innerText="name shouldn't empty";
          flag=false;
        }
        else if(!nameregex.test(fname)){
          fnameerr.innerText="shouldn't contain nums and special chars";
          flag=false;
        }
        if(lname===""){
          lnameerr.innerText="lastname shouldn't empty";
          flag=false;
        }
        else if(!nameregex.test(lname)){
          lnameerr.innerText="shouldn't contain numbers and special chars";
          flag=false;
        }
        if(phone===""){
          phoneerr.innerText="phone shouldn't empty";
          flag=false;
        }
        else if(!phoneregex.test(phone)){
          phoneerr.innerText="invalid phone number";
          flag=false;
        }
        if(email===""){
          emailerr.innerText="email shouldn't empty";
          flag=false;
        } 
        else if(!emailregex.test(email)){
          emailerr.innerText="invalid email";
          flag=false;
        }
        if(aadhaar===""){
          aadhaarerr.innerText="aadhaar shouldn't empty";
          flag=false;
        }
        else if(!aadhaarregex.test(aadhaar)){
          aadhaarerr.innerText="invalid aadhaar number";
          flag=false;
        }
        if(flag){
          var formData = new FormData(document.querySelector('#updatedonarinfo'));
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'updateinsertdb.php', true);
          xhr.onload = function() {
          if (xhr.status === 200) {
        if(xhr.responseText=="updated successfully") {
            window.location.href="account.php";
         }
         else{
            window.location.href="account.php";
         }
        } else {
            // Handle error
            console.error('Error: ' + xhr.statusText);
        }
    };
    xhr.send(formData); 
        }
      });


      document.addEventListener('DOMContentLoaded', function () {
            const stateDropdown = document.getElementById('stateDropdown');
            const districtDropdown = document.getElementById('districtDropdown');
            const mandalDropdown = document.getElementById('mandalDropdown');

            stateDropdown.addEventListener('change', function () {
                const stateId = this.value;
                if (stateId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../fetch_district.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            districtDropdown.innerHTML = xhr.responseText;
                            districtDropdown.disabled = false;
                            mandalDropdown.innerHTML = '<option value="" selected disabled>Select Mandal</option>';
                            mandalDropdown.disabled = true;
                        } else {
                            console.error('Error: ' + xhr.statusText);
                        }
                    };
                    xhr.send('state_id=' + encodeURIComponent(stateId));
                } else {
                    districtDropdown.innerHTML = '<option value="" selected disabled>Select District</option>';
                    districtDropdown.disabled = true;
                    mandalDropdown.innerHTML = '<option value="" selected disabled>Select Mandal</option>';
                    mandalDropdown.disabled = true;
                }
            });

            districtDropdown.addEventListener('change', function () {
                const districtId = this.value;
                if (districtId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../fetch_mandal.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            mandalDropdown.innerHTML = xhr.responseText;
                            mandalDropdown.disabled = false;
                        } else {
                            console.error('Error: ' + xhr.statusText);
                        }
                    };
                    xhr.send('district_id=' + encodeURIComponent(districtId));
                } else {
                    mandalDropdown.innerHTML = '<option value="" selected disabled>Select Mandal</option>';
                    mandalDropdown.disabled = true;
                }
            });
        });

          </script>



</html>