<?php
  // session_start();
include "../connection/dbConnection.php";
$perPage = 5;
  $a = 1;
  $medf = $med_brand =$med_cate=$med_donate_date=$sort= "";


 $unam = $_SESSION['u_name'];
//  echo $unam ;
 $donid="";

 $sql = "SELECT Don_ID FROM donner where Don_UNAME ='".$unam."'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       $donid = $row["Don_ID"] ;
      
      // $typ = $row["type"];
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
              
               if(!empty($_GET['categoryFilter'])){
                  $med_cate = $_GET['categoryFilter'];
                }
              
               if(!empty($_GET['dateFilter'])){
                  $med_donate_date = $_GET['dateFilter'];
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
  // id count for total number of medicine show 
  $sqlTotalid2 = "SELECT med_id FROM donated_medicine where Don_ID='$donid';";
  $resultTotalid = mysqli_query($conn, $sqlTotalid2);
  $idCount = mysqli_num_rows($resultTotalid);
 



if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])) {
      $MedQuery = "select * from donated_medicine  where Don_ID='$donid' and med_name like '%$medf%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and category like '%$med_cate%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and donation_date like '%$med_donate_date%' limit $startingRow, $perPage";
  }
  // combination 2
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and category like '%$med_cate%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and donation_date like '%$med_donate_date%' DESC limit $startingRow, $perPage";
  }


  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and category like '%$med_cate%' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and donation_date like '%$med_donate_date%' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }
 else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and donation_date like '%$med_donate_date%' and category like '%$med_cate%' limit $startingRow, $perPage";
  }

  // combination 3
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and brand like '%$med_brand%' and category like '%$ %' limit $startingRow, $perPage";
  }
   else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and  donation_date like '%$med_donate_date%' and category like '%$med_cate%' limit $startingRow, $perPage";
  }
    else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and  donation_date like '%$med_donate_date%' and  brand like '%$med_brand%' limit $startingRow, $perPage";
  }
   else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and  donation_date like '%$med_donate_date%' and  brand like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and category like '%$med_cate%' and donation_date like '%$med_donate_date%' and brand like '%$med_brand%' limit $startingRow, $perPage";
  }
// combination all
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' and med_name like '%$medf%' and brand like '%$med_brand%' and category like '%$med_cate%'and donation_date like '%$med_donate_date%' limit $startingRow, $perPage";
  }

  // sort
else if(isset($_GET['sort1'])  && $_GET['sort'] == 'date'){
     $MedQuery = "select * from donated_medicine where Don_ID='$donid' order by donation_date DESC limit $startingRow, $perPage";
  }
   else if(isset($_GET['sort1'])  && $_GET['sort'] == 'name'){
     $MedQuery = "select * from donated_medicine where Don_ID='$donid' order by med_name ASC limit $startingRow, $perPage";
  }
  else if(isset($_GET['showall'])){ $perPage = $idCount;
    $MedQuery = "select * from donated_medicine where Don_ID='$donid' LIMIT $startingRow, $perPage";
  }
  else{
      $MedQuery = "select * from donated_medicine where Don_ID='$donid' limit $startingRow, $perPage";
  }

  
$results=mysqli_query($conn,$MedQuery);

  $sqlTotalid = "SELECT COUNT(*) as t_c FROM donated_medicine where Don_ID='$donid' ";
  $resultTotalids = mysqli_query($conn, $sqlTotalid);
  $rowTotal = mysqli_fetch_assoc($resultTotalids);
  
  $totalc = $rowTotal['t_c'];

  $np = ceil($totalc/$perPage);

// same name show in select option one time
  $allmedname = "select med_name , COUNT(*) AS CountOf from donated_medicine where Don_ID='$donid' GROUP BY med_name HAVING COUNT(*)>0";
  $resultAllmedname = mysqli_query($conn, $allmedname);

  $allmedbrand = "SELECT brand , COUNT(*) AS CountOf FROM donated_medicine where Don_ID='$donid' GROUP BY brand ASC HAVING COUNT(*)>0";
  $resultAllBrand = mysqli_query($conn, $allmedbrand);
  
  
  $allmedcate = "SELECT category , COUNT(*) AS CountOf FROM donated_medicine where Don_ID='$donid' GROUP BY category ASC HAVING COUNT(*)>0";
  $resultAllcate = mysqli_query($conn, $allmedcate);


  $allmeddontdate = "SELECT donation_date , COUNT(*) AS CountOf FROM donated_medicine where Don_ID='$donid' GROUP BY donation_date ASC HAVING COUNT(*)>0";
  $resultAlldate = mysqli_query($conn, $allmeddontdate);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cancel Donation</title>
    
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
  

/* sub order */
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
    margin: 20px auto;
    width: 440px;
    padding:2px 90px;
    font-size:16px;
    font-family: monospace;
    border: 3px solid rgb(94, 94, 94);
}


/*        *************************End Menu bar***************************  */

.displayData{
  margin: 0px auto;
}
table{
    /* width:1910px; */
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

    </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
 <header class="menu_bar">
      <ul>
        <li class="hom"><a href="donner.php"><i class="fa fa-home"></i>Home</a> </li>

        <li  class="acc"><a href="Accountdonner.php"><i class="fa fa-user"></i>Account</a> </li>
       
        <li  class="orderl"><a href="Donationlist.php"> <i class="fa fa-sort"></i>Donation List</a>
            <div class="sub_order">
                  <ul>
                     <li><a href="cancelDonation.php" class="order"><i class="fa fa-sort"></i>Cancel Donner</a></li> 
                     <!-- <li><a href="Receiverlist.php" class="order"><i class="fa fa-sort"></i>Request List</a></li> -->
                  </ul>
              </div>
        
        </li>

        <li  class="logo"><a href="../logout.php"><i class="fa fa-sign-out"></i>Logout</a> </li>
      </ul>
       
  
    </header>


<div class="txt2">
    <h2>Donation List</h2>
</div>
<?php if (isset($_SESSION['message'])): ?>
<div class="msg">
<?php 
echo $_SESSION['message'] ;
unset($_SESSION['message']);
?>
</div>
<?php endif ?>
<div class="total">
    <h2>Total Donation : <?php echo $idCount; ?></h2>
</div>



<div class="custom_select">
 <form action="cancelDonation.php" method="get">
      <fieldset>

        <legend>Filter</legend>
        
        &nbsp;
        <!-- <label>Search by Medicine Name: </label> -->
        <select name="MeddicineFilter">
          <option value="" disabled selected>Medicine Name..</option>
          <?php
            while($rowAllMedicine = mysqli_fetch_assoc($resultAllmedname)) { ?>
              <option value="<?php echo $rowAllMedicine['med_name']; ?>"> <?php echo $rowAllMedicine['med_name']; ?> </option>
          <?php
            }
          ?>
        </select>
        &nbsp;&nbsp;

       <select name="brandFilter">
          <option value="" disabled selected>Select Brand.</option>
          <?php
            while($rowAllbrand = mysqli_fetch_assoc($resultAllBrand)) { ?>
              <option value="<?php echo $rowAllbrand['brand']; ?>"> <?php echo $rowAllbrand['brand']; ?> </option>
          <?php
            }
          ?>
        </select>

        &nbsp;

       <select name="categoryFilter">
          <option value="" disabled selected>Select Category...</option>
          <?php
            while($rowAllcategory = mysqli_fetch_assoc($resultAllcate)) { ?>
              <option value="<?php echo $rowAllcategory['category']; ?>"> <?php echo $rowAllcategory['category']; ?> </option>
          <?php
            }
          ?>
        </select>
      
        &nbsp;
        
        <select name="dateFilter">
          <option value="" disabled selected>Donation Date...</option>
          <?php
            while($rowAlldate = mysqli_fetch_assoc($resultAlldate)) { ?>
              <option value="<?php echo $rowAlldate['donation_date']; ?>"> <?php echo $rowAlldate['donation_date']; ?> </option>
          <?php
            }
          ?>
        </select>
      
        &nbsp;

        <input type="submit" name="filter" value="Search">

  &nbsp;

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
&nbsp;


<label>Sort by: </label>
       <select name="sort">
        <option value="" disabled selected>Select</option>
        <option value="date" >Donation Date</option>
          <option value="name" >Name</option>
        </select>

         &nbsp;
        <input type="submit" name="sort1" value="Sort">

&nbsp;&nbsp;
<input type="submit" name="showall" value="View All">
<br> <br>
      </fieldset>
 </form>
<div>


<form action="../connection/dbConnection.php" method="POST">
 <div class="displayData">
              <table>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Medicine Name</th>
                        <th>Expired Date</th>
                        <th>Category</th>
                        <th>Batch id</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Donation Date</th>
                        <th>Pickup Location</th>
                        <th>Select</th>
                    </tr>
                      <?php while($row = mysqli_fetch_assoc($results)):  ?>
                       
                            <tr>
                          
                            <td> <?php echo $row["med_name"] ;?> </td>
                            <td> <?php echo $row["ExpDate"] ;?> </td>
                            <td> <?php echo $row["category"] ;?> </td>
                            <td> <?php echo $row["batchid"]; ?> </td>
                            <td> <?php echo $row["brand"] ;?></td>
                            <td> <?php echo $row["quantity"] ;?></td>
                            <td> <?php echo $row["donation_date"] ;?></td>
                            <td> <?php echo $row["location"] ;?></td>
                            <td> <input type="checkbox" name=ids[] value="<?php echo  $row["med_id"] ; ?>"></td>
                            </tr> 
                      <?php endwhile; ?>
                          
            </table>
        </div>
        <div class="del">
        <input type="submit" name="delete" value="Cancel">
        
        </div>
</form>
  






<div class="btn_next_pre">

         
          <?php if ($startingRow>0): ?>
          <a class="btnpg" href="cancelDonation.php?x=<?php echo $a-1; ?>" >Previous</a>
          <?php endif; ?>

         

    <?php
      for($i=1; $i<=$np; $i++){ ?>
        <a class="btnpg" href="cancelDonation.php?x=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php
      }
    ?>
  <?php if (($perPage+$startingRow) <=  ($totalc-1)): ?>
    <a class="btnpg" href="cancelDonation.php?x=<?php echo $a+1; ?>" >Next</a>
    <?php endif; ?>  

</div>




</body>
</html>