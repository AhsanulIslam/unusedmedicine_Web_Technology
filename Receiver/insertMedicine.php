<?php
include "../connection/dbConnection.php";
  



// Select all  previous and next work
  $perPage = 5;
  $a = 1;
  $medf = $med_brand =$med_cate=$med_donate_date=$sort= "";


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

 $sqlTotalid2 = "SELECT med_id FROM medicine";
  $resultTotalid = mysqli_query($conn, $sqlTotalid2);
  $idCount = mysqli_num_rows($resultTotalid);


 if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter'])  ) {
      $MedQuery = "select * from medicine where med_name like '%$medf%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) ){
      $MedQuery = "select * from medicine where category like '%$med_brand%' limit $startingRow, $perPage";
  }
 
 
// combination all
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter'])){
      $MedQuery = "select * from medicine where med_name like '%$medf%' and category like '%$med_brand%' limit $startingRow, $perPage";
  }

  // sort
else if(isset($_GET['sort1'])  && $_GET['sort'] == 'date'){
     $MedQuery = "select * from medicine order by expdate DESC limit $startingRow, $perPage";
  }
   else if(isset($_GET['sort1'])  && $_GET['sort'] == 'name'){
     $MedQuery = "select * from medicine order by med_name ASC limit $startingRow, $perPage";
  }
  else if(isset($_GET['showall'])){$perPage = $idCount;
    $MedQuery = "select * from medicine LIMIT $startingRow, $perPage";
  }
  else{
      $MedQuery = "select * from medicine LIMIT $startingRow, $perPage;";
  }


// $sqlshow = "select * from medicine where  order by med_id DESC LIMIT $startingRow, $perPage;";
$results=mysqli_query($conn,$MedQuery);

  $sqlTotalid = "SELECT COUNT(*) as t_c FROM medicine ";
  $resultTotalids = mysqli_query($conn, $sqlTotalid);
  $rowTotal = mysqli_fetch_assoc($resultTotalids);
  
  $totalc = $rowTotal['t_c'];

  $np = ceil($totalc/$perPage);



  $allmedname = "select med_name , COUNT(*) AS CountOf from medicine GROUP BY med_name HAVING COUNT(*)>0";
  $resultAllmedname = mysqli_query($conn, $allmedname);

  
  $allmedbrand = "SELECT category , COUNT(*) AS CountOf FROM medicine GROUP BY category ASC HAVING COUNT(*)>0";
  $resultAllBrand = mysqli_query($conn, $allmedbrand);


    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Medicine</title>
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
width:318px;  /*distance*/
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
}

.refresh input[type="submit"]:hover {
  cursor: pointer;
  background: #616161;
  color: rgb(255, 255, 255);
}


#total{
color:rgb(94, 94, 94);
width: 540px;
height:20px;
padding:2px 90px;
font-size:16px;
font-family: monospace;
margin: 200px 700px;
}


/* select option */
.custom_select{
  margin:-70px auto;
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
  color: white;
  text-decoration: none;
}


</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
 <script>
          function checkforblank(){
                  if(document.getElementById('mnam').value== ""){
                 Swal.fire('Sorry!','Medicine Name can not be empty!','error')
                 document.getElementById('mnam').style.bordercolor="red";
                  return false; // break that action that happening submit
                  }
                  else if(document.getElementById('dat').value== "") {
                 Swal.fire('Sorry!','Expired Date can not be empty!','error')
                  return false;
                  }
                    else if(document.getElementById('dat').value== "") {
                 Swal.fire('Sorry!','Expired Date can not be empty!','error')
                  return false;
                  }
                   
                    else if(document.getElementById('batchid').value== "") {
                 Swal.fire('Sorry!','Batch id can not be empty!','error')
                  return false;
                  }
                   else if(document.getElementById('brand').value== "") {
                 Swal.fire('Sorry!','Brand name can not be empty!','error')
                  return false;
                  }
                   else if(frm.t_ype.selectedIndex==0) {
                 Swal.fire('Sorry!','Category must be selected!','error')
                 frm.t_ype.focus();
                  return false;
                  }
                  else{
                    Swal.fire('Thanks..!!','Medicine Donated Successfully!!!','success')
                  return true;
                  }
            }

</script>
</head>
<body>

<!-- ***************************** -->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="medicine" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Medicine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
<form action="../connection/dbConnection.php" method="post" onsubmit="return checkforblank()" name="frm">


  <!-- <div class="form-row"> -->
    <div class="form-group ">
      <label for="name">Name <span style="color :red;">*</span></label>
      <input type="text" class="form-control" id="mnam"  name="m_name" placeholder="Medicine name">
      <label for="name">Expired Date<span style="color :red;">*</span></label>
      <input type="date" class="form-control" id="dat"  name="expdat" placeholder="Expired date">
    </div>
  
  <!-- </div> -->
  <div class="form-group">
      <label for="inputState">Category</label>
      <select id="inputState" class="form-control" name="t_ype" id="cate">
         <option value="" selected  disabled>Category</option>
        <option value="Antibiotic">Antibiotic</option>
        <option value="Antiseptics">Antiseptics</option>
        <option value="Antipyretics">Antipyretics</option>
        <option value="MoodStabilizers">Mood Stabilizers</option>
      </select>
    </div>

  <div class="form-group">
    <label for="inputAddress">Batch Id<span style="color :red;">*</span></label>
    <input type="text" class="form-control" id="batchid" placeholder="Batch id" name="batchid">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Brand<span style="color :red;">*</span></label>
    <input type="text" class="form-control"  name="brand" id="brand" placeholder="Brand">
  </div>


    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-info" name="add" value="Add">
      </div>
      </form>
    </div>
  </div>
</div>



<div class="addbut" id="one">  <input type="submit" name="add" value="Add Medicine" class="btn btn-info" data-toggle="modal" data-target="#medicine"></div>
<div class="refresh" id ="two"> <a href="insertmedicine.php"> <input type="submit" value="Refesh" class="btn btn-info" ></a> </div>

<div class="total" id="total"><h2>Total Medicine : <?php echo $idCount; ?></h2></div>

<div class="custom_select">
 <form action="insertMedicine.php" method="get">
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
          <option value="" disabled selected>Select Category Name..</option>
          <?php
            while($rowAllbrand = mysqli_fetch_assoc($resultAllBrand)) { ?>
              <option value="<?php echo $rowAllbrand['category']; ?>"> <?php echo $rowAllbrand['category']; ?> </option>
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
                        <th>ID</th>
                        <th>Medicine Name</th>
                        <th>Expired Date</th>
                        <th>Category</th>
                        <th>Batch id</th>
                        <th>Brand</th>
                    </tr>
                      <?php while($row = $results->fetch_assoc()):  ?>
                       
                            <tr>
                            <td> <?php echo  $row["med_id"] ; ?> </td>
                            <td> <?php echo $row["med_name"] ;?> </td>
                            <td> <?php echo $row["ExpDate"] ;?> </td>
                            <td> <?php echo $row["category"] ;?> </td>
                            <td> <?php echo $row["batchid"]; ?> </td>
                            <td> <?php echo $row["brand"] ;?></td>
                             </tr> 
                      <?php endwhile; ?>
                          
            </table>
        </div>



 <div class="btn_next_pre">

          <?php if ($startingRow>0): ?>
          <a class="btnpg" href="insertmedicine.php?x=<?php echo $a-1; ?>" >Previous</a>
          <?php endif; ?>

    <?php
      for($i=1; $i<=$np; $i++){ ?>
        <a class="btnpg" href="insertmedicine.php?x=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php
      }
    ?>
  <?php if (($perPage+$startingRow) <= ($totalc-1)): ?>
    <a class="btnpg" href="insertmedicine.php?x=<?php echo $a+1; ?>" >Next</a>
    <?php endif; ?>  

</div>





<header class="menu_bar">
      <ul>
        <li class="hom"><a href="manager.php"><i class="fa fa-home"></i>Home</a> </li>
        <li  class="acc"><a href="AccountManager.php"><i class="fa fa-user"></i>Account</a> 
        <div class="sub_order">
                  <ul>
                     <li><a href="inventory.php" class="order"><i class="fa fa-cart-plus"></i>Inventory</a></li> 
                  </ul>
              </div>
        </li>
        <li  class="medi"><a href="#"><i class="fa fa-medkit"></i>Medicine</a> 
              <div class="sub_medi">
                  <ul>
                     <li><a href="insertMedicine.php" class="Medicine"><i class="fa fa-plus-square-o"></i>Insert</a></li> 
                     <li><a href="UpdateMedicine.php" class="Medicine"><i class="fa fa-retweet"></i>Update</a></li>
                     <li><a href="DeleteMedicine.php" class="Medicine"><i class="fa fa-trash-o"></i>Delete</a></li>                
                  </ul>
              </div>
        </li>
        <li  class="orderl"><a href="#"> <i class="fa fa-sort"></i>Order List</a>
        <div class="sub_order">
                  <ul>
                     <li><a href="donnerList.php" class="order"><i class="fa fa-list"></i>Donner List</a></li> 
                     <li><a href="Receiverlist.php" class="order"><i class="fa fa-list"></i>Request List</a></li>
                  </ul>
              </div>
        </li>
        <li  class="Deliv"><a href="#"><i class="fa fa-motorcycle"></i>Delivery</a>
          <div class="sub_delivery">
                  <ul>
                     <li><a href="deliveryDonner.php" class="del"><i class="fa fa-bicycle"></i>Sent to Donner</a></li> 
                     <li><a href="deliveryReceiver.php" class="del"><i class="fa fa-bicycle"></i>Sent to Receiver</a></li>
                  </ul>
              </div>
        
         </li>
        <li  class="logo"><a href="../logout.php"><i class="fa fa-sign-out"></i>Logout</a> </li>
      </ul>
       
  
    </header>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>