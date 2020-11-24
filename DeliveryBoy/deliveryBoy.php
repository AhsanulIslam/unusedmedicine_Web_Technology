<?php
include "../connection/dbConnection.php";
 $unam = $_SESSION['u_name'];
 $dboyid=$typ="";

$sql = "SELECT DBoy_ID FROM deliveryboy where DBoy_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
   
    while($row = mysqli_fetch_assoc($result)) {
       $dboyid = $row["DBoy_ID"] ;
      
     
    }
}

$delid=$notavailable=$quan=$delnam ="";
if (isset($_GET['edit']))
{
    $med_id =$_GET['edit'];
$q="select * from donnersentdelivery where idsentd = '$med_id'";
    $rec = mysqli_query($conn,$q);
    $record = mysqli_fetch_array($rec);
    $medname = $record['med_name'];
    $expdate =$record['ExpDate'];
    $batchid2 =$record['batchid'];
    $brand1 =$record['brand'];
    $cat =$record['category'];
    $med_id = $record['idsentd'];
    $loca = $record['location'];
    $quan = $record['quantity'];
    $dboy_id = $record['DBoy_ID'];
    $typ = $record['type'];



date_default_timezone_set("Asia/Dhaka");
$currentD = date("Y-m-d h:i:sa");
if($typ == "Donner")
{
 $sql1 = "INSERT INTO instore (	med_name ,expdate, batchid, brand,category,quantity,location,DBoy_ID) VALUES ('".$medname."','".$expdate."', '".$batchid2."', '".$brand1."', '".$cat."', '".$quan."', '".$loca."', '".$dboy_id."')";
  mysqli_query($conn, $sql1);
}
else{
  $sql2 = "INSERT INTO deliveryDoneRece (del_date,	med_name ,expdate, batchid, brand,category,quantity,location,DBoy_ID) VALUES ('".$currentD."','".$medname."','".$expdate."', '".$batchid2."', '".$brand1."', '".$cat."', '".$quan."', '".$loca."', '".$dboy_id."')";
  mysqli_query($conn, $sql2);
}

 $sql3 = "INSERT INTO delbhistory (	del_date ,med_name ,category,type,quantity,location,DBoy_ID) VALUES ('".$currentD."','".$medname."','".$cat."', '".$typ."','".$quan."', '".$loca."', '".$dboy_id."')";
  mysqli_query($conn, $sql3);


 $sql ="delete from donnersentdelivery where idsentd = '$med_id'";
  mysqli_query($conn,$sql);

         mysqli_query($conn, $sql);
         header('location: deliveryBoy.php');
  
}

// Select all  previous and next work
  $perPage = 5;
  $a = 1;
  $medf = $med_brand =$med_cate=$med_donate_date=$sort= "";
$mes="";

  if($_SERVER["REQUEST_METHOD"]=="GET"){
  
              if(isset($_GET['filter'])){
                if(!empty($_GET['MeddicineFilter'])){
                  $medf = $_GET['MeddicineFilter'];
                }

                if(!empty($_GET['brandFilter'])){
                  $med_brand = $_GET['brandFilter'];
                }
              
               
                
              }
              if(isset($_GET['sort1'])){
                 if(!empty($_GET['sort'])){
                  $sort = $_GET['sort'];
                    }
              }
         
             if(isset($_GET['showRec'])){
               $perPage = $_GET['numOfRec'];
                }
                
                if(!empty($_GET['x'])){
                    $a = $_GET['x'];
                  }

  }

    $startingRow = ($a-1)*$perPage;

 $sqlTotalid2 = "SELECT idsentd FROM donnersentdelivery  where DBoy_ID='$dboyid'";
  $resultTotalid = mysqli_query($conn, $sqlTotalid2);
  $idCount = mysqli_num_rows($resultTotalid);

 if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter'])  ) {
      $MedQuery = "select * from donnersentdelivery where DBoy_ID='$dboyid' and med_name like '%$medf%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) ){
      $MedQuery = "select * from donnersentdelivery where brand like '%$med_brand%' limit $startingRow, $perPage";
  }
 
 
// combination all
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter'])){
      $MedQuery = "select * from donnersentdelivery where  DBoy_ID='$dboyid' and med_name like '%$medf%' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }

  // sort
else if(isset($_GET['sort1'])  && $_GET['sort'] == 'date'){
     $MedQuery = "select * from donnersentdelivery where  DBoy_ID='$dboyid' order by expdate DESC limit $startingRow, $perPage";
  }
   else if(isset($_GET['sort1'])  && $_GET['sort'] == 'name'){
     $MedQuery = "select * from donnersentdelivery where  DBoy_ID='$dboyid' order by med_name ASC limit $startingRow, $perPage";
  }
  else if(isset($_GET['showall'])){$perPage = $idCount;
    $MedQuery = "select * from donnersentdelivery where DBoy_ID='$dboyid' LIMIT $startingRow, $perPage";
  }
  else{
      $MedQuery = "select * from donnersentdelivery where DBoy_ID='$dboyid' LIMIT $startingRow, $perPage;";
  }

  





// $sqlshow = "select * from medicine where  order by med_id DESC LIMIT $startingRow, $perPage;";
$results=mysqli_query($conn,$MedQuery);

  $sqlTotalid = "SELECT COUNT(*) as t_c FROM donnersentdelivery  where DBoy_ID='$dboyid'";
  $resultTotalids = mysqli_query($conn, $sqlTotalid);
  $rowTotal = mysqli_fetch_assoc($resultTotalids);
  
  $totalc = $rowTotal['t_c'];

  $np = ceil($totalc/$perPage);



  $allmedname = "select med_name , COUNT(*) AS CountOf from donnersentdelivery where DBoy_ID='$dboyid' GROUP BY med_name HAVING COUNT(*)>0 ";
  $resultAllmedname = mysqli_query($conn, $allmedname);

  
  $allmedbrand = "SELECT brand , COUNT(*) AS CountOf FROM donnersentdelivery  where DBoy_ID='$dboyid' GROUP BY brand ASC HAVING COUNT(*)>0";
  $resultAllBrand = mysqli_query($conn, $allmedbrand);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
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

/* end menu */
.add{
  margin:200px 110px auto;
}

.add input[type="text"],
input[type="date"] ,
input[type="number"]{
  border: 1px solid rgb(139, 139, 139);
  border-radius: 5px;
  background: transparent;
  outline: none;
  height: 35px;
  width: 280px;
  color: rgb(43, 43, 43);
  font-size: 25px;
  text-align: left;
  padding:5px 10px;
}


#one{
  float :left;
  padding :30px ;
  margin:120px 670px;
}
#two{
  float:left;
  padding :30px;
  margin:100px -670px;
}
.addbut input[type="submit"] {
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

.addbut input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}

.refresh input[type="submit"] {
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

.refresh input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}

.total{
color:rgb(94, 94, 94);
margin: 250px auto;
width: 440px;
padding:2px 90px;
font-size:16px;
font-family: monospace;
border: 3px solid rgb(94, 94, 94);
}

/* seletion */
.add select {
  width: 100%;
  height: 100%;
  background: none;
  border: 0.5px solid #000000;
  padding: 0 50px 0 20px;
  cursor: pointer;
  font-family: monospace;
  font-size: 21px;
  text-indent: 5px;
}

.add select:focus {
  outline: none;
}

.add option {
  font-family: monospace;
  font-size: 21px;
}

.add .select {
  position: absolute;;
  border: 0.5px solid #000000;
  height: 35px;
  width:340px;
  top:200px;
  right:310px;
  cursor: pointer;
}

.add .select:before {
  content: "";
  background: #000000;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  width: 20px;
  pointer-events: none;
}

.add .select:after {
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


.displayData{
  margin: 0px auto;
}
table{
    margin:10px auto;
    width:100%;
    text-align:center;
    table-layout:fixed;
}
table, tr,td{
  padding:20px;
  color:white;
  border:.5px solid #fff;
  border-collapse:collapse;
  font-size:18px;
  font-family:Arial;
  background-color:rgb(48, 48, 48);
  opacity:.9;
}


 th{
  padding:20px;
  color:white;
  border-collapse:collapse;
  font-size:18px;
  font-family:Arial;
  background-color:black;
}
td{
  border:0px solid rgb(48, 48, 48);
}

/* pagination */
.btn_next_pre{
  margin:30px;
  text-decoration: none;
    text-align:center;

}
.btnpg{
  text-decoration: none;
    padding: 2px 20px;
    background: black;
    color: white;
    border-radius: 3px;
}
.btnpg:hover{
    background:#49a4c0;
}



/* select option */
.custom_select{
  margin:-200px auto;
}
.custom_select label{
color:rgb(94, 94, 94);
font-size:21px;
font-family: monospace;
   

}
.custom_select {
  --radius: 0;
  --baseFg: white;
  --baseBg: black;
  --accentFg: black;
  --accentBg: #49a4c0;
    font-family: sans-serif;
}
.custom_select input[type="submit"] {
  border: none;
  outline: none;
  height: 35px;
  width: 190px;
  background: #49a4c0;
  color: #fff;
  border-radius: 5px;
  font-family: monospace;
  font-size: 21px;
  cursor: pointer;

}

.custom_select input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}

select {
  font: 400 15px/1.3 sans-serif;
  -webkit-appearance: none;
  appearance: none;
  color: var(--baseFg);
  border: 1px solid var(--baseFg);
  line-height: 1;
  outline: 0;
  padding: 0.65em 2.5em 0.55em 0.75em;
  border-radius: 5px;
  background-color: var(--baseBg);
  background-image: linear-gradient(var(--baseFg), var(--baseFg)),
    linear-gradient(-135deg, transparent 50%, var(--accentBg) 50%),
    linear-gradient(-225deg, transparent 50%, var(--accentBg) 50%),
    linear-gradient(var(--accentBg) 42%, var(--accentFg) 42%);
  background-repeat: no-repeat, no-repeat, no-repeat, no-repeat;
  background-size: 1px 100%, 20px 22px, 20px 22px, 20px 100%;
  background-position: right 20px center, right bottom, right bottom, right bottom;   
}

select:hover {
  background-image: linear-gradient(var(--accentFg), var(--accentFg)),
    linear-gradient(-135deg, transparent 50%, var(--accentFg) 50%),
    linear-gradient(-225deg, transparent 50%, var(--accentFg) 50%),
    linear-gradient(var(--accentFg) 42%, var(--accentBg) 42%);
}

select:active {
  background-image: linear-gradient(var(--accentFg), var(--accentFg)),
    linear-gradient(-135deg, transparent 50%, var(--accentFg) 50%),
    linear-gradient(-225deg, transparent 50%, var(--accentFg) 50%),
    linear-gradient(var(--accentFg) 42%, var(--accentBg) 42%);
  color: var(--accentBg);
  border-color: var(--accentFg);
  background-color: var(--accentFg);
}


fieldset { border:4px solid  rgb(94, 94, 94) }

legend {
  padding: 0.2em 0.5em;
  border: 1.5px solid rgb(94, 94, 94);
  color: rgb(94, 94, 94);
  font-family: monospace;
  letter-spacing: 7px;
  font-size: 21px;
  text-align:Left;
  }


.edit_btn {
    text-decoration: none;
    padding: 2px 18px;
    background: black;
    color: white;
    border-radius: 3px;
}
.edit_btn:hover {
  background:#49a4c0;
}


    </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

 <script>
                // function checkforblank(){
                //   if(document.getElementById('delid').value== ""){
                //  Swal.fire('Sorry!','Please select Delivery Boy First !!','error')
                //  document.getElementById('delid').style.bordercolor="red";
                //   return false; // break that action that happening submit
                //   }
                
                //    else{
                //     Swal.fire('Thanks..!!','Delivery Done Successfully!!!','success')
                //   return true;
                //   }
                  
                // }
                function checkforblank2(){
                  Swal.fire('Thanks..!!','Delivery Done Successfully!!!','success')
                }

</script>
</head>

<body>
  

<!-- text fields -->

<!-- <div class="together"> -->
<form action="deliveryBoy.php" method="post" onsubmit="return checkforblank()" name="frm">
<input type="hidden" name="med_id" value="<?php echo $med_id; ?>">
  <div class="add" hidden>
              <input type="text" name="m_name" id="mnam" size="40" heigth="50px" placeholder="Medicine name" value="<?php echo $medname; ?>">
               <input type="date" name="expdate"  id="dat" size="40" placeholder="Expired Date" value="<?php echo $expdate; ?>">
                <div class="select">
                <select name="t_ype">
                     <option value="" selected  disabled>Category</option>
                    <option value="Antibiotic" <?php if($record['category']=="Antibiotic"){echo "selected";}?>>Antibiotic</option>
                    <option value="Antiseptics"  <?php if($record['category']=="Antiseptics"){echo "selected";}?>>Antiseptics</option>
                    <option value="Antipyretics" <?php if($record['category']=="Antipyretics"){echo "selected";}?>>Antipyretics</option>
                    <option value="MoodStabilizers" <?php if($record['category']=="MoodStabilizers"){echo "selected";}?>>Mood Stabilizers</option>
                 </select>
                 </div>
                <!-- <input type="text" name="batchid1"  id="batchid1" size="40" placeholder="Batch id" value="<?php //echo $batchid; ?>"> -->
                 <input type="text" name="brand" id="brand" size="40"placeholder="Brand" value="<?php echo $brand1; ?>">
                 <input type="text" name="batchid" id="batchid1" size="40"placeholder="batchid" value="<?php echo $batchid; ?>">
                 <input type="text" name="location" id="brand" size="40"placeholder="location" value="<?php echo $loc; ?>">
                 <input type="text" name="DBoy_ID" id="delid" size="40"placeholder="id" value="<?php echo $delid; ?>">
                 <input type="number" name="quantity" id="brand" size="40"placeholder="quantity" value="<?php echo $quan; ?>">
                 <input type="text" name="type" id="typ" size="40"placeholder="type" value="<?php echo $typ; ?>">
                 
           
         
        </div>

    
</form>




<div class="total">
    <h2>Total Medicine : <?php echo $idCount; ?></h2>
</div>




<div class="custom_select">
 <form action="deliveryBoy.php" method="get">
      <fieldset>

        <legend>Filter</legend>
        
        &nbsp;
        <!-- <label>Search by Medicine Name: </label> -->
        <select name="MeddicineFilter">
          <option value="" disabled selected>Select Medicine Name..</option>
          <?php
            while($rowAllMedicine = mysqli_fetch_assoc($resultAllmedname)) { ?>
              <option value="<?php echo $rowAllMedicine['med_name']; ?>"> <?php echo $rowAllMedicine['med_name']; ?> </option>
          <?php
            }
          ?>
        </select>
        &nbsp;&nbsp;

       <select name="brandFilter">
          <option value="" disabled selected>Select Brand Name..</option>
          <?php
            while($rowAllbrand = mysqli_fetch_assoc($resultAllBrand)) { ?>
              <option value="<?php echo $rowAllbrand['brand']; ?>"> <?php echo $rowAllbrand['brand']; ?> </option>
          <?php
            }
          ?>
        </select>
      
        &nbsp;

        <input type="submit" name="filter" value="Search">

  &nbsp;&nbsp;

<!-- <form class="" action="Donationlist.php" method="post"> -->
      <label>Number of  rows: </label>
      <select name="numOfRec">
        <option value="" selected  disabled>ALL</option>
        <option value="3" <?php if ($perPage == "3") echo ' selected="selected"'; ?> >3</option>
        <option value="5" <?php if ($perPage == "5") echo ' selected="selected"'; ?>>5</option>
        <option value="7" <?php if ($perPage == "7") echo' selected="selected"'; ?>>7</option>
        <option value="10" <?php if ($perPage == "10") echo ' selected="selected"'; ?>>10</option>
      </select>
      &nbsp;
      <input type="submit" name="showRec" value="Show">
<!-- </form> -->
&nbsp;&nbsp;


<label>Sort by: </label>
       <select name="sort">
        <option value="" disabled selected>Select</option>
        <option value="date" >Date</option>
          <option value="name" >Name</option>
        </select>

         &nbsp;&nbsp;

        <input type="submit" name="sort1" value="Sort">

&nbsp;&nbsp;
<input type="submit" name="showall" value="View All">
<br> <br>
      </fieldset>
 </form>
<div>



 <div class="displayData">
              <table>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Medicine Name</th>
                        <th>Expired Date</th>
                        <th>Category</th>
                        <th>Batch id</th>
                        <th>Brand</th>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    <tbody>
                    <?php while($row = $results->fetch_assoc()):  ?>
                       
                            <tr>
                            <!-- <td> <?php //echo  $row["idsentd"] ; ?> </td> -->
                            <td> <?php echo $row["med_name"] ;?> </td>
                            <td> <?php echo $row["ExpDate"] ;?> </td>
                            <td> <?php echo $row["category"] ;?> </td>
                            <td> <?php echo $row["batchid"]; ?> </td>
                            <td> <?php echo $row["brand"] ;?></td>
                            <td> <?php echo $row["location"] ;?></td>
                            <td> <?php echo $row["quantity"] ;?></td>
                            <td> <?php echo $row["type"] ;?></td>
                            <td>  
                          <a onclick="checkforblank2()" href="deliveryBoy.php?edit= <?php echo $row['idsentd']; ?>" class="edit_btn">Delivery Done</a> 
                               
                            </td>

                            </tr> 
                      <?php endwhile; ?>
                       </tbody>       
            </table>
        </div>


 <footer class="btn_next_pre">

          <?php if ($startingRow>0): ?>
          <a class="btnpg" href="deliveryBoy.php?x=<?php echo $a-1; ?>" >Previous</a>
          <?php endif; ?>

    <?php
      for($i=1; $i<=$np; $i++){ ?>
        <a class="btnpg" href="deliveryBoy.php?x=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php
      }
    ?>
  <?php if (($perPage+$startingRow) <= ($totalc-1)): ?>
    <a class="btnpg" href="deliveryBoy.php?x=<?php echo $a+1; ?>" >Next</a>
    <?php endif; ?>  

</footer>

  <header class="menu_bar">
      <ul>
        <li class="hom"><a href="deliveryBoy.php"><i class="fa fa-home"></i>Home</a> </li>

        <li  class="acc"><a href="AccountDeliveryBoy.php"><i class="fa fa-user"></i>Account</a> </li>
       
        <li  class="orderl"><a href="history.php"> <i class="fa fa-sort"></i>Delivery History</a></li>

        <li  class="logo"><a href="../logout.php"><i class="fa fa-sign-out"></i>Logout</a> </li>
      </ul>
       
  
    </header>

</body>
</html>