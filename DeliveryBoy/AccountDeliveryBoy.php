<?php
include "../connection/dbConnection.php";

 $unam = $_SESSION['u_name'];
$fnm = $eml =$add =$typ=$phn="";

echo "<br>";

$sql = "SELECT  Dboy_FNAME ,Dboy_UNAME, Dboy_email ,Dboy_ADDRESS,Dboy_PHONE FROM deliveryboy where Dboy_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {
       $fnm = $row["Dboy_FNAME"] ;
      $eml=  $row["Dboy_email"] ;
      $add = $row["Dboy_ADDRESS"]; 
      $phn = $row["Dboy_PHONE"]; 

    }
} else {
    echo "0 results";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Account Information</title>
    <style>
      
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body{
  background-image:url("../image/back.jpg");
  background-size: cover;
  min-height: 100vh;
  background-position: center;
  font-family: sans-serif;
  background-repeat: no-repeat;
  background-attachment: fixed;
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

  line-height:100px;
width:490px;  /*distance*/
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
 
}
.menu_bar ul li:hover .sub_medi{
      display:block;
      position:absolute;
      background:#616161;

}

.menu_bar ul li:hover .sub_medi ul{
  display:block;
      position:absolute;
background:#49a4c0;

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
.text{
               position: absolute;
               top:30%;
               left:40%;

}
.userimg {
              width: 150px;
              height: 150px;
              border-radius: 50%;
               position: absolute;
               top: -40%;
              left: calc(50% - 50px);
    } 
    
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


  <header class="menu_bar">
      <ul>
        <li class="hom"><a href="deliveryBoy.php"><i class="fa fa-home"></i>Home</a> </li>

        <li  class="acc"><a href="AccountDeliveryBoy.php"><i class="fa fa-user"></i>Account</a> </li>
       
        <li  class="orderl"><a href="history.php"> <i class="fa fa-sort"></i>Delivery History</a></li>

        <li  class="logo"><a href="../logout.php"><i class="fa fa-sign-out"></i>Logout</a> </li>
      </ul>
       
  
    </header>

<div class="text" align="center">
   <img src="../image/images.jpeg" alt="user" class="userimg"  /> 
<br>
<br>
<br>
<table>
              <tr>
                <td><label for="">Full Name : </label> </td>
                <td><?php echo $fnm ; ?></td>
               </tr>
 <tr><td><br><br></td></tr>

               <tr>
               <td><label for="">Email : </label> </td>
                <td><?php echo $eml ; ?></td>
               </tr>
              
 <tr><td><br><br></td></tr>

              <tr>
              
                <td><label for="">UserName : </label> </td>
                <td><?php echo $unam ; ?></td>
                
              </tr>
 <tr><td><br><br></td></tr>

        <tr>
        <td><label for="">Phone : </label> </td>
                <td><?php echo $phn ; ?></td>
        </tr>
 <tr><td><br><br></td></tr>

               <tr>
                <td><label for="">Address : </label> </td>
                <td><?php echo $add ; ?></td>
               </tr>
</table>



    
</body>
</html>