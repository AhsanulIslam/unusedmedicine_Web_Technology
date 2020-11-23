<?php
include "connection/dbConnection.php";



$user=$pwd="";
$err ="";
$ERRPass = $ErruName = $message = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(!empty($_POST['u_name'])){
		$user = mysqli_real_escape_string($conn, $_POST['u_name']);
  }
  else{
    $ErruName="Username can't be Empty!!";
  }
	if(!empty($_POST['paw'])){
		$pwd = mysqli_real_escape_string($conn, $_POST['paw']);
  }
  else{
    $ERRPass="Password can't be Empty!!";
  }



      $uPassInDB=$uPassInDB2=$uPassInDB1= $uPassInDB3="";
         $user = $_POST["u_name"];
        $pwd = $_POST["paw"];

        $sql = "select mgr_UNAME,password from manager where  MGR_UNAME  = '".$user."'";
        $sql1 = "select Don_UNAME,password from donner where  Don_UNAME  = '".$user."'";
        $sql2 = "select rec_UNAME,password  from receiver where  rec_UNAME  = '".$user."'";
        $sql3 = "select DBoy_UNAME,password from DeliveryBoy where  DBoy_UNAME  = '".$user."'";

        $result = mysqli_query($conn,$sql);
        $rowCount = mysqli_num_rows($result);
        $result1 = mysqli_query($conn,$sql1);
        $rowCount1 = mysqli_num_rows($result1);
        $result2 = mysqli_query($conn,$sql2);
        $rowCount2 = mysqli_num_rows($result2);
        $result3 = mysqli_query($conn,$sql3);
        $rowCount3 = mysqli_num_rows($result3);

while($row = mysqli_fetch_assoc($result)){
      $uPassInDB = $row['password'];
    }
while($row = mysqli_fetch_assoc($result1)){
      $uPassInDB1 = $row['password'];
    }
      
while($row = mysqli_fetch_assoc($result2)){
      $uPassInDB2 = $row['password'];
    }
    
while($row = mysqli_fetch_assoc($result3)){
      $uPassInDB3 = $row['password'];
    }


    if($rowCount < 1 && $rowCount1 < 1 && $rowCount2 < 1 && $rowCount3 < 1 ){
		$message = "User does not exist!";
          	}
       	else{
              if (password_verify($pwd, $uPassInDB)) {
                    //   echo "Record updated successfully";
                    $_SESSION["u_name"] =$user;
                    header("Location:manager/manager.php");
                } 
                elseif(password_verify($pwd, $uPassInDB1)){
		                $_SESSION["u_name"] =$user;
                    header("Location:donner/donner.php");    
                }
                elseif(password_verify($pwd, $uPassInDB2)){
                  # code...
                  $_SESSION["u_name"] =$user;
                    header("Location:receiver/Receiver.php");
                }
                elseif (password_verify($pwd, $uPassInDB3)) {
                  # code...
                  $_SESSION["u_name"] =$user;
                    header("Location:deliveryBoy/deliveryBoy.php");
                }
                else
                {
                      // echo "Error updating record: " . mysqli_error($conn);
                       $err = "Password Enter Correctly !!!";
                        // header("location:connection.php?Invalid = please fill in the gap first");
                     }
                
  }
}

 


?>


<!DOCTYPE html>
<head>
    <title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="loginStyle.css" />
    <style>
      .background {
            background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
    url("./image/backNEW.jpg");
    background-size: cover;
    min-height: 100vh;
    background-position: center;
    font-family: sans-serif;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
}

#text {
    display:none;
    color:red;
    font-size:15px;
    }
.fa{
position:absolute;
 left:470px; 
 top:300px; 
 font-size:25px; 
 cursor:pointer; 
 color:#999;
}
.fa.active{
    color:#49a4c0;
}
</style>
</head>
<body>

<div class="background">
<div class="login">
  <img src="./image/images.jpeg" alt="user" class="userimg" />
<h1>Log in</h1>



<form action="login.php" method ="post">
  <br/><br/>
    <table>
        <tr>
              <td>
                    <label for="">Username<span style="color:red;">* <?php echo $ErruName; ?></span></label>
              </td> 
        </tr>
        <tr>
                <td>
                    <input type="text" name="u_name" size="55" placeholder="Enter Username" >
                    <span style="color:red"><?php echo $message ; ?></span>
               </td> 
        </tr>

        <tr><td><br></td></tr>
            
        <tr>
           <br><td>
                  <label for="">Password<span style="color:red;">* <?php echo $ERRPass; ?></span></label> 
              </td>
        </tr>
         <tr>
              <td>
                  <input id="pwd" name="paw" type="password" class="form-control" placeholder="Enter Password">
                  <span style="color:red"><?php echo $err ; ?></span>
                  <i class="fa fa-eye" id="eye"></i>
              </td>
             
        </tr>
        <tr>
          <td><p id="text" >WARNING..!! Caps lock is ON.</p></td>
        </tr>
       
    </table>
    
    <br><br>

    <div align="center"> <input type="submit" value="sign in" name="btnLogin" ></div>
  
    <br><br><br>
    
    <a class="lost" href="#">Lost your password ?</a>
        <br/><br/>
        <a class="acc" href="register.php">Don't Have a account ?</a>
    <br><br><br>
</form>
  
</div>

<br><br>

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

    <div class="second"></div>
    <div class="third"></div>

    <div class="fourth" align="center">
      <Table >
        <tr>
           <td >
           <h2>Want more information?</h2>
          </td>
        </tr>
         <tr><td><br></td></tr><tr><td><br></td></tr>
        <tr>
          <td >
            <p>We’d love to connect with anyone interested in learning more <br>about our work.  Simply fill out the form below.</p>
          </td>
        </tr>
          <tr><td><br></td></tr><tr><td><br></td></tr><tr><td><br></td></tr><tr><td><br></td></tr><tr><td></td> </tr>
            
                <tr>
                    <td>
                    <input type="text" name="" size="55" placeholder="Name*" >
                    </td> 
               </tr>

        <tr><td><br></td></tr> <tr> <td> <br><!-- <label for="">Email</label>  --> </td></tr>
          
          <tr>
              <td>
                  <input type="email" name="" placeholder="E-Mail*">

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
                <br><br>
                 <h3>	&copyAhsanul, Copyright 2020.</h3 >
                
</footer>

<script>

var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');
eye.addEventListener('click', togglePass);

function togglePass() {
  eye.classList.toggle('active');
  (pwd.type == 'password') ? pwd.type = 'text': pwd.type = 'password';
}

var input = document.getElementById("pwd");
var text = document.getElementById("text");
input.addEventListener("keyup", function(event) {

if (event.getModifierState("CapsLock")) {
    text.style.display = "block";
  } else {
    text.style.display = "none"
  }
});

</script>
</body>
</html>