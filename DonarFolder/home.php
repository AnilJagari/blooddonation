<?php
include ("../connectaddress.php");
$sql1="select id,name from state";
$res1=$con->query($sql1);

if(isset($_GET["message"])){
  $fmessage=$_GET["message"];
  echo "<h4>$fmessage</h4>";
  exit(); 
}
else{
  $fmessage="";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donar Login/Sign-up Page</title>
    <link rel="stylesheet" href="../bootstrap.css">
</head>

<body>
   <!--SECTION 1-->

<section class="bg-light py-3 py-md-5" id="section1" style="display:block;" >
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <a href="#!">
                <img src="./assets/img/bsb-logo.svg" alt="Blooddonation Logo" width="175" height="57">
              </a>
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign in to your account</h2>
            <form id="donarlogininfo">
              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input  class="form-control" name="username1" id="username1" placeholder="username" required>
                    <label for="username" class="form-label">Username</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input  class="form-control" name="password1" id="password1"  placeholder="Password" required>
                    <label for="password" class="form-label">Password</label>
                  </div>
                  <div>
                  <span class="badge bg-danger" id="errormessage" style="font-size:14px;font-weight:450;"></span>
                  </div>
                </div>
                <div class="col-12">
                <div class="text-center mb-2">
                    <a href="#!" class="link-primary text-decoration-none">Forgot password?</a>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="button"  id="login1">Log in</button>
                  </div>
                </div>
                <div class="col-12">
                  <p class="m-0 text-secondary text-center">Don't have an account? <a id="signup" class="link-primary text-decoration-none" onclick="func1()" style="cursor:pointer;" >Sign up</a></p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--SECTION 2--> 
<section class="bg-light py-3 py-md-5"  id="section2" style="display:none;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5"> 
          <div class="text-center mb-3">
          <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Enter Your Details </h2>
          </div>
         <?php echo "<form action='datainsertdb.php' method='post'>"; ?>
            <div class="row gy-2 overflow-hidden">
              <div class="col-12">
               <div class="form-floating mb-3">
                  <input class="form-control" name="firstname" id="firstname" placeholder="firstname" >
                  <label for="firstname" class="form-label">Firstname</label>
                  <b><span class="badge bg-danger" id="fnameerror"></span></b>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-3">
                  <input class="form-control" name="lastname" id="lastname" placeholder="lastname" >
                  <label for="lastname" class="form-label">Lastname</label>
                  <b><span class="badge bg-danger" id="lnameerror"></span></b>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-3">
                   <input class="form-control" name="phone" id="phone"  placeholder="phone" >
                   <label for="phone" class="form-label">Phone</label>
                    <b><span class="badge bg-danger" id="phoneerror"></span></b>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="email" id="email"  placeholder="email" >
                    <label for="email" class="form-label">Email</label>
                    <b><span class="badge bg-danger" id="emailerror"></span></b>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="aadhaar" id="aadhaar"  placeholder="aadhaar" >
                    <label for="aadhaar" class="form-label">Aadhaar</label>
                    <b><span class="badge bg-danger" id="aadhaarerror"></span></b>
                  </div>
                </div>

   <div class="container mt-3">  
   <p><b>Gender</b></p>         
   <div class="form-check">
      <input type="radio" class="form-check-input" id="male" name="gender" value="Male">
      <label class="form-check-label" for="male">Male</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="female" name="gender" value="Female">
      <label class="form-check-label" for="female">Female</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="other" name="gender" value="Other">
      <label class="form-check-label" for="other">Other</label>
    </div>
    <b><span class="badge bg-danger" id="gendererror"></span></b>
   </div>
   <div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example" id="bloodgroup" name="bloodgroup">
  <option selected>select your blood group</option>
  <?php 
          $bloodgroup=array("O+","O-","A+","A-","B+","B-","AB+","AB-","OAB+","OAB-");
          sort($bloodgroup);
          foreach($bloodgroup as $bg){
            echo "<option value='{$bg}'>{$bg}</option>";
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
  <option selected>DD</option>
  <?php
        for($i=1;$i<=31;$i++){
            echo "<option value={$i}>{$i}</option>";
        }
  ?>
  </select>
  </div>
  <div class="col">
  <select class="form-select" aria-label="Default select example" id="month" name="month">
  <option selected>MM</option>
  <?php
        $montharray=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        foreach($montharray as $key=>$month){
            $newkey=$key+1;
            echo "<option value='{$newkey}'>{$month}</option>";
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
            echo "<option value='{$i}'>{$i}</option>";
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
             if($res1){
         while($st=$res1->fetch_assoc()){
           ?>
           <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
           <?php }
           }else{
            echo "error :".$con->error;
           }
           $con->close();?>
  </select>
  <b><span class="badge bg-danger" id="stateerror"></span></b>
</div> 
<div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example"  id="districtDropdown" name="district" disabled>
  <option value="" selected disabled>select your district</option>
  </select>
  <b><span class="badge bg-danger" id="districterror"></span></b>
</div> 
<div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example"  id="mandalDropdown" name="mandal" disabled>
  <option value="" selected disabled>select your mandal</option>

  </select>
  <b><span class="badge bg-danger" id="mandalerror"></span></b>
</div> 


<div class="col-10">
                  <div class="d-grid my-3">
<button class="btn btn-primary" type="button" name="next1" value="next1"  id="button1">Next</button>
</div>
 </div>
</div>
   
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--SECTION 3-->
<section class="bg-light py-3 py-md-5"  id="section3" style="display:none;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
          <div class="text-center mb-3">
          <h2 class="fs-6 fw-normal text-center text-secondary mb-4">set username and password for your account</h2>
          </div>
          
<div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="username2" id="username2" placeholder="username" >
                    <label for="username2" class="form-label">Username</label>
                    <b><span class="badge bg-danger" id="usernameerror2"></span></b>
                  </div>
                  
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="password2" id="password2" placeholder="password" >
                    <label for="password2" class="form-label">Password</label>
                    <b><span class="badge bg-danger" id="passworderror2"></span></b>
                  </div>
                </div>

                <div class="col-10" id="nxtbtn">
                  <div class="d-grid my-3">
<button class="btn btn-primary" type="button" name="next2" value="next2" id="button2">Next</button>
</div>
 </div>

 <div class="col-12" style="display:none;" id="setpassword">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="re-enter-password" id="re-enter-password" placeholder="re-enter-password">
                    <label for="re-enter-password" class="form-label">Re-Enter-Password</label>
                    <b><span class="badge bg-danger" id="repasserror"></span></b>
                  </div>
                </div>

                <div class="col-10"  style="display:none;" id="sbtbtn">
                  <div class="d-grid my-3">
<button class="btn btn-primary" type="button" name="sendotp" value="sendotp"  id="button3">SEND OTP</button>
</div>
 </div>
</div>
               
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

 <!--SECTION 4-->
 <section class="bg-light py-3 py-md-5"  id="section4" style="display:none;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
          <div class="text-center mb-3">
          <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Enter the OTP that sent to your Gmail</h2>
          </div>

          
<div class="row gy-2 overflow-hidden">
<div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="otp" id="otp" placeholder="otp">
                    <label for="otp" class="form-label">Enter OTP</label>
                  </div>
                </div>

                <div class="col-10" id="nxtbtn">
                  <div class="d-grid my-3">
<button class="btn btn-primary" type="submit" name="login2" value="login2" >Login</button><br><br>
 <?php echo "</form>"; ?>
</div>
 </div>
</div>
      
</div>
                  
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
       function test_input(data){
        function stripslashes(str){
          return str.replace(/\\/g,'');
        }
        data=data.trim();
        data=stripslashes(data);
        return data; 
       }
       document.querySelector("#login1").addEventListener("click",()=>{
      var data= new FormData(document.querySelector('#donarlogininfo'));
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'verifyaccount.php', true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          var responseText = xhr.responseText;
                        var response;
          
                        try {
                            response = JSON.parse(responseText);
                        } catch (e) {
                            response = responseText;
                        }

                        // Handle the response based on its type
                        if (typeof response === 'string') {
                          
                          var error=document.querySelector("#errormessage");
                          error.innerText="incorrect username or password";
                            
                        } else if (typeof response === 'object' && response !== null) {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
        }
      }
         else {
            // Handle error
            console.error('Error: ' + xhr.statusText);
        }
    };
    
    // Send the request with the form data
    xhr.send(data);
     });

       //signup page
       function func1(){
        let sec1=document.querySelector("#section1");
        sec1.style.display="none";
        let sec2=document.querySelector("#section2");
        sec2.style.display="block";
       }
       //credentials of the user
       document.querySelector("#button1").addEventListener("click", ()=> {
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

        if(!gender){
          gendererr.innerText="gender not selected";
          flag=false;
        }
        var bg=document.querySelector("#bloodgroup");
        if(bg.value=="select your blood group"){
          bloodgrouperr.innerText="select bloodgroup only if you know (optional)";
        }
        else{
          var bloodgroup=bg.value;
        }
        var dt=document.querySelector("#date");
        if(dt.value=="DD"){
          dateerr.innerText="Date of birth not selected properly";
          flag=false;
        }
        else{
          var date=dt.value;
        }
        var mnt=document.querySelector("#month");
        if(mnt.value=="MM"){
          dateerr.innerText="Date of birth not selected properly";
          flag=false;
        }
        else{
          var month=mnt.value;
        }
        var yer=document.querySelector("#year");
        if(yer.value=="YYYY"){
          dateerr.innerText="Date of birth not selected properly";
          flag=false;
        }
        else{
          var year=yer.value;
        }  
        var st=document.querySelector("#stateDropdown");
        if(st.value==""){
          stateerr.innerText="state not selected";
          flag=false;
        }
        else{
          var state=st.value;
        } 
        var dist=document.querySelector("#districtDropdown");
        if(dist.value==""){
          districterr.innerText="district not selected";
          flag=false;
        }
        else{
          var district=dist.value;
        }   
        var mdl=document.querySelector("#mandalDropdown");
        if(mdl.value==""){
          mandalerr.innerText="mandal not selected";
          flag=false;
        }
        else{
          var mandal=mdl.value;
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
        if(flag==true){
          let sec2=document.querySelector("#section2");
        sec2.style.display="none";
        let sec3=document.querySelector("#section3");
        sec3.style.display="block";
        } 
       });

       //username and passowrd setting page
       document.querySelector("#button2").addEventListener("click", ()=> {
        let flag=true;
        var uname=document.querySelector("#username2");
        var pass=document.querySelector("#password2");
        var username=test_input(uname.value);
        let password=test_input(pass.value);
      
        
        let usernameerr=document.querySelector("#usernameerror2");
        let passworderr=document.querySelector("#passworderror2");
        usernameerr.innerText="";
        passworderr.innerText="";
        const unameregex=/^[A-Za-z0-9._]{1,50}$/;
        const passregex=/^[A-Za-z0-9._]{1,50}$/;
        const passdigit=/\d/;
        const passlower=/[a-z]/;
        if(username==""){
          usernameerr.innerText="username shouldn't be empty"; 
          flag=false;
        }
        else if(!unameregex.test(username)){
          usernameerr.innerText="username should be unique and doesn't contain special char";
          flag=false;
        }
        if(password==""){
          passworderr.innerText="password shouldn't be empty";
          flag=false;
        }
        else if(password.length<=8){
          passworderr.innerText="password atleast contain 8 char";
          flag=false;
        }
        else if(password.length>50){
          passworderr.innerText="password shouldn't contain more than 50 chars";
          flag=false;
        }
        else if(!passdigit.test(password)){
          passworderr.innerText="password contains atleast 1 digit";
          flag=false;
        }
        else if(!passlower.test(password)){
          passworderr.innerText="password contains atleast lowercase char";
          flag=false;
        }
        else if(!passregex.test(password)){
          passworderr.innerText="password shoudn't contain special char";
          flag=false;
        }
  if(flag){
        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'usernamecheck.php', true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 200){
        if((xhr.responseText).trim()=="not exist") {
          uname.readOnly=true; 
          pass.readOnly=true;
       var nxtbtn1=document.querySelector("#nxtbtn");
        nxtbtn1.remove();
      var rep=document.querySelector("#setpassword");
        rep.style.display="block";
      var sbtn=document.querySelector("#sbtbtn");
        sbtn.style.display="block";
         }
         else{
            usernameerr.innerText="username already exist ";
            flag=false; 
            
         }
        } else {
            // Handle error
            console.error('Error: ' + xhr.statusText);
        }

    };
     xhr.send("username=" + encodeURIComponent(username));
  }
     
        });
        //username and password resetting page
        document.querySelector("#button3").addEventListener("click", ()=> {
          let flag=true;
          let password=test_input(document.querySelector("#password2").value);
          let rep=test_input(document.querySelector("#re-enter-password").value);
          if(password!=rep){
            let repasserr=document.querySelector("#repasserror");
            repasserr.innerText="password mismatched";
            flag=false;
          }
          if(flag==true){
            let sec3=document.querySelector("#section3");
            sec3.style.display="none";
            let sec4=document.querySelector("#section4");
            sec4.style.display="block";
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

    
</body>
</html>