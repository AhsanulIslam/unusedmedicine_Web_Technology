<?php
include "../connection/dbConnection.php";
$inventoryquantity="";
 $medf = $med_brand =$cat=$med_donate_date=$sort=$brand1=$batchid=$expdate=$medname= "";
$mes="";

if (isset($_GET['edit']))
{
    $med_id =$_GET['edit'];

    $rec = mysqli_query($conn,"select * from inventory where inventory_id = '".$med_id."'");
    $record = mysqli_fetch_array($rec);
    $medname = $record['med_name'];
    $expdate =$record['ExpDate'];
    $batchid =$record['batchid'];
    $brand1 =$record['brand'];
    $inventoryquantity =$record['quantity'];
    $cat =$record['category'];
    $med_id = $record['inventory_id'];
}

// Select all  previous and next work
  $perPage = 5;
  $a = 1;
 
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

 $sqlTotalid2 = "SELECT inventory_id FROM inventory where category='Antipyretics';";
  $resultTotalid = mysqli_query($conn, $sqlTotalid2);
  $idCount = mysqli_num_rows($resultTotalid);


 if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter'])  ) {
      $MedQuery = "select * from 	inventory  where category='Antipyretics' and med_name like '%$medf%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) ){
      $MedQuery = "select * from inventory where category='Antipyretics' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }
 
 
// combination all
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter'])){
      $MedQuery = "select * from inventory where category='Antipyretics' and med_name like '%$medf%' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }

  // sort
else if(isset($_GET['sort1'])  && $_GET['sort'] == 'date'){
     $MedQuery = "select * from inventory where category='Antipyretics' order by expdate DESC limit $startingRow, $perPage";
  }
   else if(isset($_GET['sort1'])  && $_GET['sort'] == 'name'){
     $MedQuery = "select * from inventory where category='Antipyretics' order by med_name ASC limit $startingRow, $perPage";
  }
  else if(isset($_GET['showall'])){ $perPage = $idCount;
    $MedQuery = "select * from inventory where category='Antipyretics' LIMIT $startingRow, $perPage";
  }
  else{
      $MedQuery = "select * from inventory where category='Antipyretics' LIMIT $startingRow, $perPage;";
  }

  

// $sqlshow = "select * from medicine where category='Antipyretics' order by med_id DESC LIMIT $startingRow, $perPage;";
$results=mysqli_query($conn,$MedQuery);

  $sqlTotalid = "SELECT COUNT(*) as t_c FROM inventory where category='Antipyretics';";
  $resultTotalids = mysqli_query($conn, $sqlTotalid);
  $rowTotal = mysqli_fetch_assoc($resultTotalids);
  
  $totalc = $rowTotal['t_c'];

  $np = ceil($totalc/$perPage);



  $allmedname = "select med_name , COUNT(*) AS CountOf from inventory where category='Antipyretics' GROUP BY med_name HAVING COUNT(*)>0";
  $resultAllmedname = mysqli_query($conn, $allmedname);

  
  $allmedbrand = "SELECT brand , COUNT(*) AS CountOf FROM inventory where category='Antipyretics' GROUP BY brand ASC HAVING COUNT(*)>0";
  $resultAllBrand = mysqli_query($conn, $allmedbrand);



date_default_timezone_set("Asia/Dhaka");
$currentD = date("Y-m-d h:i:sa");
 $unam = $_SESSION['u_name'];
 $recid="";

 $sql = "SELECT rec_ID FROM receiver where rec_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       $recid = $row["rec_ID"] ;
    }
}

$ermess =$succ="";




  
if (isset($_POST['request']) && empty($_POST['inventoryquantity']))
    {
      $ermess ="Check Quantity & Select a medicine First..!!" ; 
    }
    else if (isset($_POST['request']) && empty($_POST['quantity']))
    {
      $ermess ="Quantity can't be Empty..!!" ; 
    }
    else if (isset($_POST['request']) && empty($_POST['location']))
    {
      $ermess ="Location can't be Empty..!!" ; 
    }
    else if (isset($_POST['request']) && !empty($_POST['quantity']) && !empty($_POST['location']))
    {
  $medname  = $_POST['m_name'];
  $expdate  = $_POST['expdate'];
  $batchid  = $_POST['batchid'];
  $brand1  =$_POST['brand'];
  $cat  =$_POST['t_ype1'];
  $quantity  =$_POST['quantity'];    //new
  $loc  =$_POST['location'];
  $med_id  =$_POST['inventory_id'];
  $inventoryquantity  =$_POST['inventoryquantity'];  //previous


if($inventoryquantity>0 && $inventoryquantity  >= $quantity)
      {

        $updatequantity = $inventoryquantity - $quantity;

      if($updatequantity >= 0)
         {
            $sql1 ="update inventory set quantity='$updatequantity' where inventory_id ='$med_id'";
            mysqli_query($conn,$sql1);

            $sql = "INSERT INTO receiverrequest (	req_date,med_name,	expdate,	batchid,brand,category,quantity,location,rec_ID,	inventory_id) VALUES ('".$currentD."','".$medname."','".$expdate."', '".$batchid."', '".$brand1."', '".$cat."','".$quantity."','".$loc."','".$recid."','".$med_id."')";

                  $t= mysqli_query($conn, $sql);
                  if($t)
                  {
                    // header('location: Antipyretics.php');
                   $succ = "Request Sent Successfully..!!";
                   
                  }
          }
      }
            else{
              $ermess = "Not available ..!! Check available First..!!";
            }
}

// Not Exit Medicine

if (isset($_POST['add2']))
{
$medname1  = $_POST['mname'];
$batchid2  = $_POST['batchid'];
$brand12  =$_POST['brand'];
$cat1  =$_POST['t_ype'];
$unam = $_SESSION['u_name'];
$recid="";

$sql = "SELECT rec_ID FROM receiver where rec_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $recid = $row["rec_ID"] ;
    }
}
date_default_timezone_set("Asia/Dhaka");
$currentD = date("Y-m-d h:i:sa");
       $sql11 = "INSERT INTO notexit (req_date,med_name,category,batchid,	brand,rec_ID) VALUES ('".$currentD."','".$medname1."', '".$cat1."', '".$batchid2."', '".$brand12."','".$recid."')";
      
         mysqli_query($conn, $sql11);
         header('location: Antipyretics.php'); 
}
  
  

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Antipyretics</title>
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

.errortxt{
  position:absolute;
  top:120px;
  left:800px;
  color:red;
  font-size:27px;
}
.add{
  margin:200px 350px auto;
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
#three{
  float:left;
  padding :30px;
  margin:0px -430px;
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
    margin: 110px  auto;
    width: 440px;
    padding:2px 58px;
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
  top:0px;
  right:-350px;
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
    text-decoration: none;
    color: white;
}



/* select option */
.custom_select{
  margin:-100px auto;
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
  text-decoration: none;
  color: white;
}


</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
 <script>

 function checkforblank1(){
                  if(document.getElementById('mnam').value== ""){
                 Swal.fire('Sorry!','Medicine Name can not be empty!','error')
                 document.getElementById('mnam').style.bordercolor="red";
                  return false; // break that action that happening submit
                  }
                  
                   else{
                    Swal.fire('Thanks..!!','Medicine Request sent Successfully!!!','success')
                  return true;
                  }
                  
                }

              
</script>

</head>
<!-- ***************************** -->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="medicine" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Request For New Medicine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
<form action="Antipyretics.php" method="post" onsubmit="return checkforblank1()" name="frm">


  <!-- <div class="form-row"> -->
    <div class="form-group ">
      <label for="name">Name <span style="color :red;">*</span></label>
      <input type="text" class="form-control" id="mnam"  name="mname" placeholder="Medicine name">
    </div>
  
  <!-- </div> -->
  <div class="form-group">
      <label for="inputState">Category</label>
      <select id="inputState" class="form-control" name="t_ype" id="cate">
        <option value="Antipyretics" selected >Antipyretics</option>
      </select>
    </div>

  <div class="form-group">
    <label for="inputAddress">Batch Id</label>
    <input type="text" class="form-control" id="batchid" placeholder="Batch id" name="batchid">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Brand</label>
    <input type="text" class="form-control"  name="brand" id="brand" placeholder="Brand">
  </div>


    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-info" name="add2" value="Sent Request">
      </div>
      </form>
    </div>
  </div>
</div>



<form action="Antipyretics.php" method="post" name="frm">
<input type="hidden" name="inventory_id" value="<?php echo $med_id; ?>">

<div class="errortxt"><label for=""><?php echo $ermess; echo $succ; ?></label></div>

  <div class="add">
              <input type="text" readonly name="m_name" id="mnam1" size="40" heigth="50px" placeholder="Medicine name" value="<?php echo $medname; ?>">
               <input type="date" readonly name="expdate"  id="dat" size="40" placeholder="Expired Date" value="<?php echo $expdate; ?>">
                <div class="select" hidden> 
                 <select name="t_ype1" >
                    <option value="Antipyretics" selected>Antipyretics</option>
               </select>
                
                <input type="text" readonly name="batchid"  id="batchid" size="40" placeholder="Batch id" value="<?php echo $batchid; ?>">
                <input type="text" readonly name="brand" id="brand" size="40"placeholder="Brand" value="<?php echo $brand1; ?>">  </div>
<!-- //********* */ -->
                <input type="number"  name="quantity" id="quantity1" min="2"  max="20" size="40"placeholder="Quantity">

               <div hidden><input type="number" readonly name="inventoryquantity" id="quantity" size="40"placeholder="Inventory Quantity" value="<?php echo $inventoryquantity; ?>"> </div> 
               <!-- ****************************** -->
                <input type="text" name="location" id="location" size="35"placeholder="Delivery Location">
      </div>

            <div class="addbut" id="one">  <input type="submit" value="Sent Request" name="request"></div>
     <!-- </div> -->
</form>


     <div class="refresh" id="two">  <input type="submit" name="newmedicine" value="Not Exist" class="btn btn-info" data-toggle="modal" data-target="#medicine"></div>
     <div class="refresh" id ="three"> <a href="Antipyretics.php"> <input type="submit" value="Refesh"></a> </div>



<div class="total">
    <h2>Total Medicine : <?php echo $idCount; ?></h2>
</div>




<div class="custom_select">
 <form action="Antipyretics.php" method="get">
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
                        <!-- <th>Category</th> -->
                        <th>Available</th>
                        <th>Batch id</th>
                        <th>Brand</th>
                        <th>Remaining Days To Be expired</th>
                        <th>Action</th>
                    </tr>
                    <tbody>
                    <?php while($row = $results->fetch_assoc()):  ?>
                       
                            <tr>
                            <!-- <td> <?php echo  $row["inventory_id"] ; ?> </td> -->
                            <td> <?php echo $row["med_name"] ;?> </td>
                            <td> <?php echo $row["ExpDate"] ;?> </td>
                            <td> <?php echo $row["quantity"] ;?> </td>
                            <td> <?php echo $row["batchid"]; ?> </td>
                            <td> <?php echo $row["brand"] ;?></td>
                             <td> 
                                <?php $now =strtotime( date("Y-m-d"));
                              $expd =  strtotime( $row["ExpDate"] ); 
                                $value= ceil(abs($expd -$now)/86400);
                              if($value>0){
                                echo $value;
                           }
                           else{
                             echo $value =0;
                           }
                           ?>
                           </td>
                            <td>  
                          <a href="Antipyretics.php?edit= <?php echo $row['inventory_id']; ?>" class="edit_btn">Request</a> 
                               
                            </td>

                            </tr> 
                      <?php endwhile; ?>
                       </tbody>       
            </table>
        </div>



 <div class="btn_next_pre">

          <?php if ($startingRow>0): ?>
          <a class="btnpg" href="Antipyretics.php?x=<?php echo $a-1; ?>" >Previous</a>
          <?php endif; ?>

    <?php
      for($i=1; $i<=$np; $i++){ ?>
        <a class="btnpg" href="Antipyretics.php?x=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php
      }
    ?>
  <?php if (($perPage+$startingRow) <= ($totalc-1)): ?>
    <a class="btnpg" href="Antipyretics.php?x=<?php echo $a+1; ?>" >Next</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>