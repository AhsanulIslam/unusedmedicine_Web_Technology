<?php
session_start();

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



// Add

if (isset($_POST['add']))
{
   $medname  = $_POST['m_name'];
    $expdate  = $_POST['expdat'];
    $batchid  = $_POST['batchid'];
$brand1  =$_POST['brand'];
$cat  =$_POST['t_ype'];
$med_id  =$_POST['med_id'];

       $sql = "INSERT INTO medicine (	med_name,ExpDate,batchid,brand,category) VALUES ('".$medname."','".$expdate."', '".$batchid."', '".$brand1."', '".$cat."')";
      
         mysqli_query($conn, $sql);
        //  $_SESSION['message']="Medicine Added Successfully!!";
         header('location: ../manager/insertMedicine.php');
  
}




//Update manager

if (isset($_POST['update']))
{
  $medname  = $_POST['m_name'];
  $expdate  = $_POST['expdat'];
  $batchid  = $_POST['batchid'];
  $brand1  =$_POST['brand'];
  $cat  =$_POST['t_ype'];
  $med_id  =$_POST['med_id'];
  mysqli_query($conn,"update medicine set med_name='$medname', ExpDate ='$expdate' , batchid='$batchid', brand='$brand1',category='$cat' where med_id ='$med_id'");
  header('location: ../manager/UpdateMedicine.php');
}




// Delete manager

if (isset($_GET['delete']))
{
  $med_id  =$_GET['delete'];
  $sql ="delete from medicine where med_id = '$med_id'";
  mysqli_query($conn,$sql);
  $_SESSION['message']="Medicine Removed Successfully!!";
  header('location: ../manager/DeleteMedicine.php');
}




// CalcelDOnation
if (isset($_POST['delete']))
{
$ids = $_POST['ids'];
foreach ($ids as $key => $value){
  $sql ="delete from donated_medicine where med_id=$value;";
  $result = mysqli_query($conn,$sql);
}
    $_SESSION['message']="Medicine Donation Cancel!!";
    header("location:../donner/cancelDonation.php");
}

// CalcelRequestOfMedicine
if (isset($_POST['delete2']))
{
$ids = $_POST['ids'];
foreach ($ids as $key => $value){
  $sq = "select quantity from receiverrequest where req_id = $value;";
  $quantity22 = mysqli_query($conn,$sq);
while($row = mysqli_fetch_assoc($quantity22)) {
       $quantity2 = $row["quantity"] ;
    }

  $sqq = "select med_name from receiverrequest where req_id = $value;";
  $medname11 = mysqli_query($conn,$sqq);
while($row = mysqli_fetch_assoc($medname11)) {
       $medname1 = $row["med_name"] ;
    }
$qq = "select quantity from inventory where med_name = $medname1;";
$preQuantity = mysqli_query($conn,$qq);
while($row = mysqli_fetch_assoc($preQuantity)) {
       $preQuantity1 = $row["quantity"] ;
    }
 $newqu = $preQuantity1 + $quantity2 ;

  $s = "update inventory set quantity='$newqu' where med_name = $medname1;";
  $ee = mysqli_query($conn,$s);

  $sql ="delete from receiverrequest where req_id = $value;";
  $result = mysqli_query($conn,$sql);
}
    $_SESSION['message']="Medicine Request Cancel!!";
    header("location:../receiver/cancelReq.php");

}


?>




