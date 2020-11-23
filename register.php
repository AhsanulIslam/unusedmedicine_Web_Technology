<?php
include "connection/dbConnection.php";

$med_id=0;
$medname = $expdate =$batchid =$brand1 =$cat ="";
$quantity=$loc="";

$dbServerName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "unusedmedicinedb";
$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);
if(mysqli_connect_errno()){
  echo "Error: ".mysqli_connect_err();
}

$fname=$user=$pwd=$eml=$add=$typ=$phn="";
$err ="";
$ferr=$uerr=$pwerr=$EmErr=$AddressErr=$typErr=$phnErr=$sameUserErr="";
$sucess="";
$uNameInDB = "" ;
$uNameInDB2 = "" ;

/* mysqli_real_escape_string() helps prevent sql injection */
  if($_SERVER["REQUEST_METHOD"]=="POST"){

    if(!empty($_POST['f_name'])){
      $fname = mysqli_real_escape_string($conn, $_POST['f_name']);
    }
    else{
        $ferr ="Name can't be Empty!!";
    }
    if(!empty($_POST['u_name'])){
      $user = mysqli_real_escape_string($conn, $_POST['u_name']);
    }
    else{
        $uerr ="UserName can't be Empty!!";
    }
    if(!empty($_POST['paw'])){
      $pwd = mysqli_real_escape_string($conn, $_POST['paw']);
      $uPassToDB = password_hash($pwd, PASSWORD_DEFAULT);
    }
    else{
        $pwerr ="Password can't be Empty!!";
    }
    if(!empty($_POST['E_mail'])){
      $eml = mysqli_real_escape_string($conn, $_POST['E_mail']);
    }
else{
        $EmErr ="Email can't be Empty!!";
    }
    if(!empty($_POST['a_ddress'])){
      $add = mysqli_real_escape_string($conn, $_POST['a_ddress']);
    }
    else{
        $AddressErr ="Address can't be Empty!!";
    }
    if(!empty($_POST['p_hone'])){
      $phn = mysqli_real_escape_string($conn, $_POST['p_hone']);
    }
    else{
        $phnErr ="Phone can't be Empty!!";
    }

    if(!empty($_POST['t_ype'])){
      $typ = $_POST['t_ype'];
    }
     else{
        $typErr ="Choose type!!";
    }

      if(empty($_POST['f_name']) || empty($_POST['u_name']) || empty($_POST['paw']) || empty($_POST['E_mail'])||empty($_POST['a_ddress'])||empty($_POST['a_ddress'])||empty($_POST['p_hone'])||empty($_POST['t_ype']))
      {
        // $err ="Fill up all Field first !!";
      }
      else{
        $sqlUserCheck = "SELECT Don_UNAME FROM donner WHERE Don_UNAME = '$user'";
        $result = mysqli_query($conn, $sqlUserCheck);

          while($row = mysqli_fetch_assoc($result)){
          $uNameInDB = $row['Don_UNAME'];
    }

    $sqlUserCheck2 = "SELECT rec_UNAME FROM receiver WHERE rec_UNAME = '$user'";
    $result2 = mysqli_query($conn, $sqlUserCheck2);

    while($row = mysqli_fetch_assoc($result2)){
      $uNameInDB2 = $row['rec_UNAME'];
    }

    if($uNameInDB == $user || $uNameInDB2 == $user){
      $sameUserErr = "UserName already exists!";
    }
    else{
    if($typ=="Donnar"){
        $sql = "INSERT INTO donner (Don_FNAME,Don_UNAME, PASSWORD,Don_email,Don_ADDRESS,Don_PHONE) VALUES ('".$fname."','".$user."', '".$uPassToDB."', '".$eml."', '".$add."', '".$phn."')";
              }
        else{
          $sql = "INSERT INTO receiver (rec_FNAME,rec_UNAME, PASSWORD,rec_email,rec_ADDRESS,rec_PHONE) VALUES ('".$fname."','".$user."', '".$uPassToDB."', '".$eml."', '".$add."', '".$phn."')";
        }
     $r= mysqli_query($conn, $sql);

       if ($r) {
    $sucess = "You are registered successfully";
            } 

    else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
      }
    }
    
  }
  


?>


<!DOCTYPE html>
<head>
    <title>Document</title>
    <!-- <link rel="stylesheet" href="register.css" /> -->

<style>
  * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/*body {
  /* 
     background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)),
    url("./coffee_book_black.jpg"); */

/* background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)),
    url("./image/2554529.jpg"); */
/* background-size: cover;
  min-height: 100vh;
  background-position: center;
  font-family: sans-serif;
  background-repeat: no-repeat; */

.back {
  background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
    url("./image/back.jpg");
  background-size: cover;
  min-height: 100vh;
  background-position: center;
  font-family: sans-serif;
  background-repeat: no-repeat;
  background-attachment: fixed;
  display: flex;
}

.register {
  width: 620px;
  height: 810px;
  background: rgb(255, 255, 255);
  color: rgb(0, 0, 0);
  top: 50%;
  left: 80%;
  position: absolute;
  transform: translate(-50%, -50%);
  opacity: 80%;
  padding: 50px 40px;
  /* border-style: solid; */
  /* border-bottom-right-radius: 20%; */
  /* border-top-left-radius: 20%; */
}
.userimg {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  position: absolute;
  top: -8.5%;
  left: calc(50% - 50px);
}
h1 {
  margin: 0;
  padding: 10px 0 10px 250px;
  font-family: monospace;
  border-style: double;
  text-transform: capitalize;
  font-weight: bolder;
  font-size: 20px;
  /* text-decoration: wavy; */
}

label {
  font-size: 20px;
  font-family: monospace;
}

.register input {
  width: 100%;
  margin-bottom: 5px;
  /* color: #000; */
}



/* seletion */
.register select {
  width: 100%;
  height: 100%;
  background: none;
  border: 0.5px solid #000000;
  -webkit-appearance: none;
  padding: 0 50px 0 20px;
  cursor: pointer;
  font: 13px sans-serif;
  text-indent: 5px;
}

.register select:focus {
  outline: none;
}

.register option {
  font: 14px sans-serif;
}

.register .select {
  position: relative;
  /* background: #fff; */
  border: 0.5px solid #000000;
  height: 30px;
  cursor: pointer;
}

.register .select:before {
  content: "";
  background: #000000;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  width: 20px;
  pointer-events: none;
}

.register .select:after {
  content: "";
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 10px 7px 0;
  border-color: rgb(255, 255, 255) transparent transparent transparent;
  position: absolute;
  right: 4.5px;
  top: 50%;
  transform: translateY(-50%);
}
/* seletion */

.register input[type="submit"] {
  border: none;
  outline: none;
  height: 40px;
  width: 200px;
  background: #49a4c0;
  color: #fff;
  border-radius: 20px;
  font-family: monospace;
  font-size: 21px;
  cursor: pointer;
}

.register input[type="submit"]:hover {
  cursor: pointer;
  background: #070707;
  color: rgb(255, 255, 255);
}
.register a:hover {
  color: #4b0101;
}

.social {
  margin: 0;
  padding: 0px 0 0px 60px;
  /* background-position: fixed; */
  display: block;
  /* min-height: 100vh; */
  /* border-radius: 5px; */
}

#twi {
  padding: 0 0 0px 30px;
}
.register a {
  text-decoration: none;
  color: #49a4c0;
  text-align: center;
  padding: 20px 0 0px 180px;
  font-size: 21px;
  font-family: monospace;
}
.second {
  background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
    url("./image/sec.jpg");
  background-size: cover;
  min-height: 100vh;
  background-position: center;
  font-family: sans-serif;
  background-repeat: no-repeat;
  display: flex;
}

.third {
  background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
    url("./image/three.jpg");
  background-size: cover;
  min-height: 100vh;
  background-position: center;
  font-family: sans-serif;
  background-repeat: no-repeat;
  display: flex;
}

.fourth {
  /* background-size: cover; */
  /* min-height: 100vh; */
  background-position: center;
  font-family: sans-serif;

  /* background-repeat: no-repeat; */
  /* display: flex; */
  padding-top: 50px;
  padding-bottom: 300px;
  background-color: rgb(255, 255, 255);
}
h2 {
  font-size: 55px;
  font-style: initial;
  color: rgb(56, 56, 56);
}
p {
  font-size: 35px;
  font-style: initial;
  color: rgb(56, 56, 56);
}


textarea {
  color: rgb(43, 43, 43);
  font-size: 25px;
  border-radius: 5px;
}
.fourth input[type="submit"] {
  width: 140px;
  height: 70px;
  color: rgb(255, 255, 255);
  font-size: 25px;
  background-color: rgb(45, 117, 252);
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.foot {
  padding-bottom: 250px;
  background-color: rgb(43, 43, 43);
  color: white;
}
.foot a {
  text-decoration: none;
  color: #49a4c0;
  text-align: center;
  padding: 0px 0px 0px 00px;
  font-size: 35px;
  font-family: monospace;
}

h3 {
  font-size: 30px;
  font-style: initial;
  color: rgb(129, 127, 127);
}


.register input[type="text"],
input[type="email"],
input[type="password"] {
  border: none;
  border-bottom: 1px solid rgb(0, 0, 0);
  background: transparent;
  outline: none;
  height: 40px;
  color: rgb(0, 0, 0);
  font-size: 13px;
}

.fourth input[type="email"],
input[type="text"] {
  /* border: none; */
  border: 1px solid rgb(139, 139, 139);
  border-radius: 5px;
  background: transparent;
  outline: none;
  height: 50px;
  width: 500px;
  color: rgb(43, 43, 43);
  font-size: 25px;
  text-align: left;
}
</style>


<script type="text/javascript">
function validate() {
var mobile = document.getElementById("mobile").value;
var pattern = /^[0-9]{11}$/;

if (pattern.test(mobile)) {
   document.getElementById("mobile").style.backgroundColor = "#aeff94";
return true;
}
document.getElementById("mobile").style.backgroundColor = "#ff9999";
alert("It is not valid mobile number");
return false;
 
}


</script>


</head>

<body>

<div class="back">
<div class="register">
  <img src="./image/images.jpeg" alt="user" class="userimg" />
<h1>Register</h1>



    <form action="register.php" method ="post"  onsubmit="return validate()">
    <!-- <fieldset> -->
      
    <table>
        <tr>
              <td>
                    <label for="">Full Name<span style="color:red;">* <?php echo $ferr; ?></span> </label>
             </td> 
        </tr>
            <tr>
              <td>
                  <input type="text" name="f_name" placeholder="Enter Full Name" >
                 <!-- value=" <?/*php echo $fname;*/ ?>" -->
               </td>
            </tr>

 <tr>
        <td><br></td>
        </tr>
       
        <tr>
              <td>
                    <label for="">Username<span style="color:red;">* <?php echo $uerr; echo $sameUserErr; ?></span></label>
             </td> 
        </tr>
            <tr>
                    <td>
                    <input type="text" name="u_name" size="55" placeholder="Enter Username" >
                   
                    </td> 
             </tr>

        <tr>
        <td><br></td>
        </tr>
            
        <tr>
        <br>
              <td>
                  <label for="">Password<span style="color:red;">* <?php echo $pwerr; ?></span></label> 
              </td>
        </tr>
        <tr>
              <td>
                  <input type="password" name="paw" placeholder="Enter Password">
               
               </td>
        </tr>
        <tr>
        <td><br></td>
        </tr>
            <tr>
              <td>
                    <label for="">Email<span style="color:red;">* <?php echo $EmErr; ?></span></label>
             </td> 
            </tr>

        <tr>
              <td>
                  <input type="email" name="E_mail" placeholder="Enter Email">
                 
               </td>
        </tr>
         <tr>
        <td><br></td>
        </tr>
 </tr>
            <tr>
              <td>
                    <label for="">Phone<span style="color:red;">* <?php echo $phnErr; ?></span></label>
             </td> 
            </tr>

        <tr>
              <td>
                  <input type="text" name="p_hone" placeholder="Enter Phone" id="mobile" onblur="validate()">
                 
               </td>
        </tr>
         <tr>
        <tr>
              <td>
                    <label for="">Address<span style="color:red;">* <?php echo $AddressErr; ?></span></label>
             </td> 
            </tr>

        <tr>
              <td>
                  <input type="text" name="a_ddress" placeholder="Enter Address">
              
               </td>
        </tr>

         <tr>
        <td><br></td>
        </tr>
        
        <tr>
              <td>
                    <label for="">User Type<span style="color:red;">* <?php echo $typErr; ?></span></label>
             </td> 
            </tr>

        <tr>
              <td>
                
                  <div class="select">
                 <select name="t_ype" id="">
                     <option value="" disabled selected>select your type</option>
                    <option value="Donnar">Donner</option>
                    <option value="Receiver">Receiver</option>
                 </select>
                 </div>
                 
               </td>
        </tr>



    </table>
   
    <br>
    <br>
    <div align="center"> <input type="submit" value="Sign up" name="btnregister"  ></div>
    
    <br>
     <?php echo $sucess ;?>
<!-- <span style="color:red"><?php// echo $err ; ?></span> -->
    
       
      
        <a class="acc" href="login.php">Want to sign in ?</a>
    <br>
    <br>
     
      <br>
    </form>
  
</div>


<br>
<br>

<div class="social">
      <a href="https://www.facebook.com" target="_blank">
        <img src="./image/Facebook_48px.png" alt="loading" style="width:35px ;" />
      </a>

      <a href="https://www.twitter.com" id="twi" target="_blank">
        <img src="./image/Twitter_48px.png" alt="loading" style="width:35px ;" />
      </a>

      <a href="https://www.linkedin.com/" id="twi" target="_blank">
        <img src="./image/LinkedIn_48px.png" alt="loading" style="width:35px ;"/>
      </a>

      <a href="https://www.Google.com" id="twi" target="_blank">
        <img src="./image/Google_48px.png" alt="loading" style="width:35px ;"/>
      </a>
    </div>

</div>


 <div class="second">
    
    </div>
 <div class="third">
    
    </div>

    <div class="fourth" align="center">
      <Table >
        <tr>
           <td >
           <h2>Want more information?</h2>
          </td>
        </tr>
              <tr><td><br></td></tr>
              <tr><td><br></td></tr>
        <tr>
         <td >
          <p>We’d love to connect with anyone interested in learning more <br>about our work.  Simply fill out the form below.</p>
          </td>
        </tr>
              <tr><td><br></td></tr>
                <tr><td><br></td></tr><tr><td><br></td></tr>
                <tr><td><br></td></tr>
        <tr>
              <td>
                    <!-- <label for="">Full Name</label> -->
                    </td> 
            </tr>
            
                <tr>
                    <td>
                    <input type="text" name="" size="55" placeholder="Name*" >
                    <span style="color:red"><?php echo $err ; ?></span>
            
               </td> 
        </tr>

        <tr><td><br></td></tr>
            
        <tr> <td> <br><!-- <label for="">Email</label>  --> </td></tr>
          
          
          <tr>
              <td>
                  <input type="email" name="" placeholder="E-Mail*">
                  <span style="color:red"><?php echo $err ; ?></span>
               </td>
          </tr>
            <tr> <td><br></td> </tr>
             <tr>
               <td>
              <textarea name="" id="" cols="60" rows="10" placeholder="Message"></textarea>
              </td>
               <td >   <input type="submit" value="Send" > </td>
            </tr>
      </TAble>
    </div>


    <footer class="foot" align="center">
      <br><br>
        
                  <a href="#">About us</a>
                  <!-- locale_get_display_language -->
 <br><br>
                 <h3>	&copyAhsanul, Copyright 2020.</h3 >
                
        </footer>


</body>
</html>