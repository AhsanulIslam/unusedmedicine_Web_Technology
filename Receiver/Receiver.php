<?php
  // session_start();
include "../connection/dbConnection.php";
 $unam = $_SESSION['u_name'];


$fnm = $eml =$add =$typ=$phn="";

echo "<br>";

$sql = "SELECT  rec_FNAME ,rec_UNAME, rec_email ,rec_ADDRESS,rec_PHONE FROM receiver where rec_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       $fnm = $row["rec_FNAME"] ;
      $eml=  $row["rec_email"] ;
      $add = $row["rec_ADDRESS"]; 
      $phn = $row["rec_PHONE"]; 
      // $typ = $row["type"];
    }
} else {
    echo "0 results";
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receiver Menu</title>
      <!-- <link rel="stylesheet" href="home.css" /> -->
       
<style>  
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.text {
                position:absolute;
                left:700px;
                top:-120px;
}

    body{
  /* position:fixed; */
    background-image:url("../image/back.jpg");
  background-size: cover;
  min-height: 100vh;
  /* width:2000px */
  background-position: center;
  font-family: sans-serif;
  background-repeat: no-repeat;
  background-attachment: fixed;
  /* display: flex; */
}


   /*                                         Menu bar                     */
/*  */
/*  */
/*  */
.menu_bar{
    background:rgb(48, 48, 48);
    text-align:center;
    height:105px;
    opacity:.9;
     position:absolute;
     top:0px;
    position:fixed;
    cursor:pointer;
}

.menu_bar ul{
  display:inline-flex;
  list-style:none;
  color:#fff;
    

}

.menu_bar ul li{
  /* float: left; */
  line-height:100px;
width:384px;  /*distance*/
/* margin:20px;  */
/* padding:50px; */
font-size:20px;

}


.menu_bar ul li a{
  text-decoration:none;
  color:white;
}
/* .active, .menu_bar ul li:hover*/
.menu_bar ul li:hover{
  background:rgb(82, 82, 82);
  height:105px;
}
.menu_bar .fa{
  margin-right:8px;
}
.sub_medi
{
  display:none;
  /* opacity:  height:50px; */
}
.menu_bar ul li:hover .sub_medi{
      display:block;
      position:absolute;
      background:#616161;
      /* height:50px; */
      /* margin-top:15px; */
      /* margin-left:-15px; */
      /* width:50px; */
      /* text-align;center; */
      /* opacity:.9; */
}

.menu_bar ul li:hover .sub_medi ul{
  display:block;
      position:absolute;
background:#49a4c0;
/* opacity:.9; */
  /* margin:10px; */
}

.menu_bar ul li:hover .sub_medi ul li a{
  color:white;
}

/* sub_order */


.sub_order
{
  display:none;
}
.menu_bar ul li:hover .sub_order{
      display:block;
      position:absolute;
      background:#616161;
 
}

.menu_bar ul li:hover .sub_order ul{
  display:block;
      position:absolute;
background:#49a4c0;

}

.menu_bar ul li:hover .sub_order ul li a{
  color:white;
}



/* sub_delivery */
.sub_delivery
{
  display:none;
}
.menu_bar ul li:hover .sub_delivery{
      display:block;
      position:absolute;
      background:#616161;
 
}

.menu_bar ul li:hover .sub_delivery ul{
  display:block;
      position:absolute;
background:#49a4c0;

}

.menu_bar ul li:hover .sub_delivery ul li a{
  color:white;
}
  
/*        *************************End Menu bar***************************  */


 
.cat {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                left:250px;
                top:140px;
                
                }
.cat input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;
}
p{
  font-family: monospace;
}

label{
  font-family: monospace;
  font-size: 20px;

}
.cat input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat a:hover {
  color:  #616161;
}



.cat2 {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                left:650px;
                top:-110px;
                
                }
.cat2 input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat2 a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;

}
.cat2 input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat2 a:hover {
  color:  #616161;
}

.cat3 {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                left:1080px;
                top:-364px;
                
                }
.cat3 input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat3 a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;

}
.cat3 input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat3 a:hover {
  color:  #616161;
}

.cat4 {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                left:1450px;
                top:-615px;
                
                }
.cat4 input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat4 a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;

}
.cat4 input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat4 a:hover {
  color:  #616161;
}


.cat5 {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                 left:250px;
                top:-450px;
                
                }
.cat5 input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat5 a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;

}
.cat5 input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat5  a:hover {
  color:  #616161;
}


.cat6 {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                left:650px;
                top:-705px;
                
                }
.cat6 input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat6 a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;

}
.cat6 input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat6 a:hover {
  color:  #616161;
}



.cat7 {
                width: 250px;
                height: 250px;
                background-color: #afafaf;
                position:relative;
                left:1078px;
                top:-960px;
                
                }
.cat7 input[type="submit"] {
                       border: none;
                       outline: none;
                       height: 26px;
                       width: 150px;
                       background: #49a4c0;
                       color: #fff;
                       /* border-radius: 20px; */
                       font-family: monospace;
                      font-size: 15px;
                      cursor: pointer;
}
.cat7 a {
  text-decoration: none;
  color:  rgb(255, 255, 255);
  text-align: center;
  /* padding: 20px 0 0px 180px; */
  font-size: 15px;
  font-family: monospace;

}
.cat7 input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}
.cat7 a:hover {
  color:  #616161;
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
.fourth p {
  font-size: 35px;
  font-style: initial;
  color: rgb(56, 56, 56);
}

.fourth input[type="text"],
input[type="email"] {
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

    </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<form action="Antibiotic.php">
  <div class="cat" align="center">
    <br>
    <label for="">Antibiotic</label>
            
    <img src="../image/Antibiotic.jpg" alt="" width="200px" height="150px">
    <p>An antibiotic is a type of<br>antimicrobia...<a href="https://en.wikipedia.org/wiki/Antibiotic" target="_blank">Read More</a></p>
    
    <br>
    <input type="submit" value="Request Now" >
  </div>
</form>
<form action="Antiseptics.php">

   <div class="cat2" align="center">
    <br>
   <label for="">Antiseptics</label>
            
    <img src="../image/Antiseptics.jpg" alt="" width="200px" height="150px">
    <p>Antiseptics (from Greek<br>ἀντί anti, "agai.. <a href="https://en.wikipedia.org/wiki/Antiseptics"target="_blank">Read More</a></p>
    
    <br>
    <input type="submit" value="Request Now" >
  </div>
</form>
<form action="Antipyretics.php">
 <div class="cat3" align="center">
    <br>
    <label for="">Antipyretics</label>
            
    <img src="../image/Antipyretics.jpg" alt="" width="200px" height="150px">
    <p>An antipyretic (/ˌæntipaɪˈrɛtɪk<br>from anti- 'agai.. <a href="https://en.wikipedia.org/wiki/Antipyretic" target="_blank">Read More</a></p>
    
    <br>
    <input type="submit" value="Request Now" >
  </div>
</form>
<form action="MoodStabilizers.php">
 <div class="cat4" align="center">
    <br>
    <label for="">Mood Stabilizers</label>
            
    <img src="../image/moodstabiliz.jpg" alt="" width="200px" height="150px">
    <p>The term "mood stabilizer"<br> does not desc.. <a href="https://en.wikipedia.org/wiki/Mood_stabilizer" target="_blank">Read More</a></p>
    
    <br>
    <input type="submit" value="Request Now" >
  </div>
</form>
 <div class="cat5" align="center">
    <br>
    <label for="">Analgesic</label>
            
    <img src="../image/Analgesic.webp" alt="" width="200px" height="150px">
    <p>An analgesic or painkiller<br>is any membe..<a href="https://en.wikipedia.org/wiki/Analgesic" target="_blank">Read More</a></p>
    
    <br>
    <input type="submit" value="Request Now" >
  </div>

 <div class="cat6" align="center">
    <br>
    <label for="">Stimulant</label>
            
    <img src="../image/Stimulant.jpg" alt="" width="200px" height="150px">
    <p>Stimulants (also often c<br>referred to as..<a href="https://en.wikipedia.org/wiki/Stimulant" target="_blank">Read More</a></p>
    
    <br>
    <input type="submit" value="Request Now" >
  </div>
   <div class="cat7" align="center">
    <br>
    <label for="">Comming soon..</label>
            
    <img src="../image/add.jpg" alt="" width="200px" height="150px">
    <!-- <p>Stimulants (also often c<br>referred to as..<a href="https://en.wikipedia.org/wiki/Stimulant" target="_blank">Read More</a></p> -->
    <br><br>
    <br>
    <br>
    <input type="submit" value="Available Soon" >
  </div>
<!-- </div> -->




     <div class="menu_bar">
      <ul>
        <li class="hom"><a href="Receiver.php"><i class="fa fa-home"></i>Home</a> </li>

        <li  class="acc"><a href="Accountreceiver.php"><i class="fa fa-user"></i>Account</a> </li>
       
       <li  class="orderl"><a href="reqlist.php"> <i class="fa fa-sort"></i>Request List</a></li>

         <li  class="orderl"><a href="cancelReq.php"> <i class="fa fa-ban"></i> Cancel Request</a></li>

        <li  class="logo"><a href="../logout.php"><i class="fa fa-sign-out"></i>Logout</a> </li>
      </ul>
       
  
    </div>

         
  <!-- </div> -->

<!-- </div> -->



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
                    <!-- <span style="color:red"><?php echo $err ; ?></span> -->
            
               </td> 
        </tr>

        <tr><td><br></td></tr>
            
        <tr> <td> <br><!-- <label for="">Email</label>  --> </td></tr>
          
          
          <tr>
              <td>
                  <input type="email" name="" placeholder="E-Mail*">
                  <!-- <span style="color:red"><?php echo $err ; ?></span> -->
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


    <div class="foot" align="center">
      <br><br>
        
                  <a href="#">About us</a>
                  <!-- locale_get_display_language -->
 <br><br>
                 <h3>	&copyAhsanul, Copyright 2020.</h3 >
                
        </div>


</body>
</html>