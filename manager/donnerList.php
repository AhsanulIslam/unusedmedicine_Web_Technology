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
  $sqlTotalid2 = "SELECT med_id FROM donated_medicine;";
  $resultTotalid = mysqli_query($conn, $sqlTotalid2);
  $idCount = mysqli_num_rows($resultTotalid);

  if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])) {
      $MedQuery = "select * from donated_medicine  where med_name like '%$medf%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where location like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where category like '%$med_cate%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where donation_date like '%$med_donate_date%' limit $startingRow, $perPage";
  }
  // combination 2
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and location like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and category like '%$med_cate%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and donation_date like '%$med_donate_date%' DESC limit $startingRow, $perPage";
  }


  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where category like '%$med_cate%' and location like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where donation_date like '%$med_donate_date%' and location like '%$med_brand%' limit $startingRow, $perPage";
  }
 else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where donation_date like '%$med_donate_date%' and category like '%$med_cate%' limit $startingRow, $perPage";
  }

  // combination 3
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and location like '%$med_brand%' and category like '%$ %' limit $startingRow, $perPage";
  }
   else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and  donation_date like '%$med_donate_date%' and category like '%$med_cate%' limit $startingRow, $perPage";
  }
    else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and  donation_date like '%$med_donate_date%' and  location like '%$med_brand%' limit $startingRow, $perPage";
  }
   else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and  donation_date like '%$med_donate_date%' and  location like '%$med_brand%' limit $startingRow, $perPage";
  }
  else if(isset($_GET['filter']) &&  empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where  category like '%$med_cate%' and donation_date like '%$med_donate_date%' and location like '%$med_brand%' limit $startingRow, $perPage";
  }
// combination all
  else if(isset($_GET['filter']) &&  !empty($_GET['MeddicineFilter']) && !empty($_GET['brandFilter']) && !empty($_GET['categoryFilter']) && !empty($_GET['dateFilter'])){
      $MedQuery = "select * from donated_medicine where med_name like '%$medf%' and location like '%$med_brand%' and category like '%$med_cate%'and donation_date like '%$med_donate_date%' limit $startingRow, $perPage";
  }

  // sort
else if(isset($_GET['sort1'])  && $_GET['sort'] == 'date'){
     $MedQuery = "select * from donated_medicine order by donation_date DESC limit $startingRow, $perPage";
  }
   else if(isset($_GET['sort1'])  && $_GET['sort'] == 'name'){
     $MedQuery = "select * from donated_medicine order by med_name ASC limit $startingRow, $perPage";
  }
  else if(isset($_GET['showall'])){ $perPage = $idCount;
    $MedQuery = "select * from donated_medicine LIMIT $startingRow, $perPage";
  }
  else{
      $MedQuery = "select * from donated_medicine limit $startingRow, $perPage";
  }

  

$results=mysqli_query($conn,$MedQuery);



  $sqlTotalid = "SELECT COUNT(*) as t_c FROM donated_medicine";
  $resultTotalids = mysqli_query($conn, $sqlTotalid);
  $rowTotal = mysqli_fetch_assoc($resultTotalids);
  
  $totalc = $rowTotal['t_c'];

  $np = ceil($totalc/$perPage);




  $allmedname = "select med_name , COUNT(*) AS CountOf from donated_medicine GROUP BY med_name HAVING COUNT(*)>0";
  $resultAllmedname = mysqli_query($conn, $allmedname);

  $allmedbrand = "SELECT location , COUNT(*) AS CountOf FROM donated_medicine GROUP BY location ASC HAVING COUNT(*)>0";
  $resultAllBrand = mysqli_query($conn, $allmedbrand);
  
  
  $allmedcate = "SELECT category , COUNT(*) AS CountOf FROM donated_medicine GROUP BY category ASC HAVING COUNT(*)>0";
  $resultAllcate = mysqli_query($conn, $allmedcate);


  $allmeddontdate = "SELECT donation_date , COUNT(*) AS CountOf FROM donated_medicine GROUP BY donation_date ASC HAVING COUNT(*)>0";
  $resultAlldate = mysqli_query($conn, $allmeddontdate);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donation List</title>
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
 

.txt2{
color:rgb(94, 94, 94);
margin: 150px auto;  /* position*/
font-size:25px;
font-family: monospace;
border: 3px solid rgb(94, 94, 94);
width: 550px;
padding:2px 130px;

}
.total{
   color:rgb(94, 94, 94);
    margin: 20px auto;
    width: 440px;
    padding:2px 90px;
    font-size:16px;
    font-family: monospace;
    /* position*/
    border: 3px solid rgb(94, 94, 94);
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


    </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>



<div class="txt2"><h2>Donation List</h2></div>
<div class="total"><h2>Total Donation : <?php echo $idCount; ?></h2></div>


<div class="custom_select">
 <form action="donnerList.php" method="get">
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
          <option value="" disabled selected>Select location Name..</option>
          <?php
            while($rowAllbrand = mysqli_fetch_assoc($resultAllBrand)) { ?>
              <option value="<?php echo $rowAllbrand['location']; ?>"> <?php echo $rowAllbrand['location']; ?> </option>
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

  &nbsp;&nbsp;

<!-- <form class="" action="donnerList.php" method="post"> -->
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
                        <th>Quantity</th>
                        <th>Donation Date</th>
                        <th>Pickup Loaction</th>
                        <th>Donner Id</th>
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
                            <td> <?php echo $row["Don_ID"] ;?></td>
                            </tr> 
                      <?php endwhile; ?>
                          
            </table>
        </div>

   
<div class="btn_next_pre">

         
          <?php if ($startingRow>0): ?>
          <a class="btnpg" href="donnerList.php?x=<?php echo ($a-1); ?>" >Previous</a>
          <?php endif; ?>

         

    <?php
      for($i=1; $i<=$np; $i++){ ?>
        <a class="btnpg" href="donnerList.php?x=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php
      }
    ?>
  <?php if (($perPage+$startingRow) <= ($totalc-1)): ?>
    <a class="btnpg" href="donnerList.php?x=<?php echo ($a+1); ?>" >Next</a>
    <?php endif; ?>  

</div>



<div class="menu_bar">
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
       
  
    </div>



</body>
</html>