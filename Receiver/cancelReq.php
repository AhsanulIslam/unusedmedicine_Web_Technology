<?php
include "../connection/dbConnection.php";
 $unam = $_SESSION['u_name'];
$preq ="";
 if (isset($_GET['edit']))
{
    $req_id =$_GET['edit'];

    $rec = mysqli_query($conn,"select * from receiverrequest where req_id = '".$req_id."'");
    $record = mysqli_fetch_array($rec);
    $medname = $record['med_name'];
    $quantityyreq =$record['quantity'];

$qq = "select quantity from inventory where med_name  ='".$medname."'";
$preQuantity = mysqli_query($conn,$qq);
     // echo $preQuantity;
if (mysqli_num_rows($preQuantity) > 0) {
    while($row = mysqli_fetch_assoc($preQuantity)) {
       $preq = $row["quantity"] ;
      
    }
  }
// echo $preq;
 $newqu = $preq + $quantityyreq ;
// echo $newqu;
  $s = "update inventory set quantity='$newqu' where med_name  ='".$medname."'";
  $ee = mysqli_query($conn,$s);

  $sql ="delete from receiverrequest where req_id = $req_id;";
  $result = mysqli_query($conn,$sql);
}

  $perPage = 5;
  $a = 1;
  $medf = $med_brand =$med_cate=$med_donate_date=$sort= "";
  $mes="";

  $reqid="";

$sql = "SELECT  rec_ID FROM receiver where rec_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $reqid = $row["rec_ID"] ;
      
     
    }
}

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

 $sqlTotalid2 = "SELECT req_id FROM receiverrequest  where rec_ID =' $reqid'";
  $resultTotalid = mysqli_query($conn, $sqlTotalid2);
  $idCount = mysqli_num_rows($resultTotalid);


 if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter'])  ) {
      $MedQuery = "select * from 	receiverrequest where rec_ID =' $reqid' and med_name like '%$medf%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) ){
      $MedQuery = "select * from receiverrequest where rec_ID =' $reqid' and  req_date like '%$med_brand%' limit $startingRow, $perPage";
  }
 
 
// combination all
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter'])){
      $MedQuery = "select * from receiverrequest where rec_ID =' $reqid' and  med_name like '%$medf%' and req_date like '%$med_brand%' limit $startingRow, $perPage";
  }

  // sort
else if(isset($_GET['sort1'])  && $_GET['sort'] == 'date'){
     $MedQuery = "select * from receiverrequest where rec_ID =' $reqid' order by req_date DESC limit $startingRow, $perPage";
  }
   else if(isset($_GET['sort1'])  && $_GET['sort'] == 'name'){
     $MedQuery = "select * from receiverrequest where rec_ID =' $reqid' order by med_name ASC limit $startingRow, $perPage";
  }
  else if(isset($_GET['showall'])){$perPage = $idCount;

    $MedQuery = "select * from receiverrequest where rec_ID =' $reqid' LIMIT $startingRow, $perPage";
  }
  else{
      $MedQuery = "select * from receiverrequest where rec_ID =' $reqid' LIMIT $startingRow, $perPage;";
  }

  





// $sqlshow = "select * from medicine where category='Antibiotic' order by med_id DESC LIMIT $startingRow, $perPage;";
$results=mysqli_query($conn,$MedQuery);

  $sqlTotalid = "SELECT COUNT(*) as t_c FROM receiverrequest where rec_ID =' $reqid'";
  $resultTotalids = mysqli_query($conn, $sqlTotalid);
  $rowTotal = mysqli_fetch_assoc($resultTotalids);
  
  $totalc = $rowTotal['t_c'];

  $np = ceil($totalc/$perPage);



  $allmedname = "select med_name , COUNT(*) AS CountOf from receiverrequest where rec_ID =' $reqid' GROUP BY med_name HAVING COUNT(*)>0";
  $resultAllmedname = mysqli_query($conn, $allmedname);

  
  $allmedbrand = "SELECT req_date , COUNT(*) AS CountOf FROM receiverrequest  where rec_ID =' $reqid' GROUP BY req_date DESC HAVING COUNT(*)>0";
  $resultAllBrand = mysqli_query($conn, $allmedbrand);

date_default_timezone_set("Asia/Dhaka");
$currentD = date("Y-m-d h:i:sa");
 $unam = $_SESSION['u_name'];
  // echo $unam ;
 $recid="";

 $sql = "SELECT rec_ID FROM receiver where rec_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $recid = $row["rec_ID"] ;
      
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Request List</title>
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
width:384px;  /*distance*/
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


.add{
  margin:200px 80px auto;
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
  margin:0px 670px;
}
#two{
  float:left;
  padding :30px;
  margin:0px -670px;

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
  /* margin:10px 650px; */
}

.refresh input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}



.txt2{
color:rgb(94, 94, 94);
margin: 120px auto;  /* position*/
font-size:25px;
font-family: monospace;
border: 3px solid rgb(94, 94, 94);
width: 550px;
padding:2px 130px;
}

.msg {
  margin: 10px auto; 
    padding: 10px; 
    border-radius: 5px; 
    color: rgb(94, 94, 94); 
    background: #d1d1d1; 
    border: 1px solid rgb(94, 94, 94);
    width: 40%;
    text-align: center;
}
.total{
   color:rgb(94, 94, 94);
    margin: 0px auto;
    width: 440px;
    padding:2px 90px;
    font-size:16px;
    font-family: monospace;
    border: 3px solid rgb(94, 94, 94);
}


.displayData{
  margin: 20px auto;
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
    /* padding:10px 100px ; */
}
.custom_select input[type="submit"] {
  border: none;
  outline: none;
  height: 35px;
  width: 130px;
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

.del input[type="submit"] {
  border: none;
  outline: none;
  height: 40px;
  width: 200px;
  background: #49a4c0;
  color: #fff;
  border-radius: 5px;
  font-family: monospace;
  font-size: 21px;
  cursor: pointer;
  text-align:center;
   position: absolute; 
  top :300px; 
  right:30px;
}
.del input[type="submit"]:hover {
   cursor: pointer;
  background: red;
  color: rgb(255, 255, 255);
}
.del a:hover {
  color:  #616161;
} 

input[type="checkbox"]
{
    position:relative;
    top:10px;
    width:20px;
    height:20px;
    -webkit-appearance:none;
    outline:none;
    transition:.5s;
}
input[type="checkbox"]:before
{
 content: '';
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
border: 4px solid white;
box-sizing: border-box;
    transition:.5s;

}

input:checked[type="checkbox"]:before
{
    border-left: none;
    border-top:none;
    width:13px;
    height:20px;
    border-color:#0f0;
    transform:rotate(45deg) translate(5px,-10px);
}
.edit_btn {
    text-decoration: none;
    padding: 2px 18px;
    background: black;
    color: white;
    border-radius: 3px;
}
.edit_btn:hover {
  background:red;
}
    </style>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</head>


<div class="txt2"> <h2>Request List</h2></div>
<?php if (isset($_SESSION['message'])): ?>
<div class="msg">
<?php 
echo $_SESSION['message'] ;
unset($_SESSION['message']);
?>
</div>
<?php endif ?>
<div class="total"><h2>Total Request : <?php echo $idCount; ?></h2></div>


<div class="custom_select">
 <form action="cancelReq.php" method="get">
      <fieldset>

        <legend>Filter</legend>
        
        &nbsp;
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
          <option value="" disabled selected>Select Request Date..</option>
          <?php
            while($rowAllbrand = mysqli_fetch_assoc($resultAllBrand)) { ?>
              <option value="<?php echo $rowAllbrand['req_date']; ?>"> <?php echo $rowAllbrand['req_date']; ?> </option>
          <?php
            }
          ?>
        </select>
      
        &nbsp;

        <input type="submit" name="filter" value="Search">

  &nbsp;&nbsp;

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
&nbsp;&nbsp;


<label>Sort by: </label>
       <select name="sort">
        <option value="" disabled selected>Select</option>
        <option value="date" >Request Date</option>
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


<form action="cancelReq.php" method="POST">
 <div class="displayData">
              <table>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Medicine Name</th>
                        <th>Expired Date</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Request Date</th>
                        <th>Batch id</th>
                        <th>Brand</th>
                        <th>Remaining Days To Be expired</th>
                        <th>Action</th>
                    </tr>
                    <tbody>
                    <?php while($row = $results->fetch_assoc()):  ?>
                       
                            <tr>
                            <!-- <td> <?php //echo  $row["req_id"] ; ?> </td> -->
                            <td> <?php echo $row["med_name"] ;?> </td>
                            <td> <?php echo $row["expdate"] ;?> </td>
                            <td> <?php echo $row["category"] ;?> </td>
                            <td> <?php echo $row["quantity"] ;?> </td>
                            <td> <?php echo $row["req_date"] ;?> </td>
                            <td> <?php echo $row["batchid"]; ?> </td>
                            <td> <?php echo $row["brand"] ;?></td>
                             <td> 
                                            <?php $now =strtotime( date("Y-m-d"));
                                            $expd =  strtotime( $row["expdate"] ); 
                                            $value= ceil(abs($expd -$now)/86400);
                                                if($value>0){
                                                  echo $value;
                                                }
                                                else{
                                                  echo $value =0;
                                                }
                                            ?> 
                           </td>
                    <td>  <a href="cancelReq.php?edit= <?php echo $row['req_id']; ?>" class="edit_btn">Cancel</a> </td>
                          
                          </tr> 
 
                      <?php endwhile; ?>
                       </tbody>       
            </table>
        </div>
  <!-- <div class="del">
        <input type="submit" name="delete2" value="Cancel">
        
        </div> -->
</form>


 <div class="btn_next_pre">

          <?php if ($startingRow>0): ?>
          <a class="btnpg" href="cancelReq.php?x=<?php echo $a-1; ?>" >Previous</a>
          <?php endif; ?>

    <?php
      for($i=1; $i<=$np; $i++){ ?>
        <a class="btnpg" href="cancelReq.php?x=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php
      }
    ?>
  <?php if (($perPage+$startingRow) <= ($totalc-1)): ?>
    <a class="btnpg" href="cancelReq.php?x=<?php echo $a+1; ?>" >Next</a>
    <?php endif; ?>  

</div>


      <div class="menu_bar">
      <ul>
        <li class="hom"><a href="Receiver.php"><i class="fa fa-home"></i>Home</a> </li>

        <li  class="acc"><a href="Accountreceiver.php"><i class="fa fa-user"></i>Account</a> </li>
       
        <li  class="orderl"><a href="reqlist.php"> <i class="fa fa-sort"></i>Request List</a></li>

         <li  class="orderl"><a href="cancelReq.php"> <i class="fa fa-ban"></i> Cancel Request</a></li>

        <li  class="logo"><a href="../logout.php"><i class="fa fa-sign-out"></i>Logout</a> </li>
      </ul>
       
  
    </div>


</body>
</html>