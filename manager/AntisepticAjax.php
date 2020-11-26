<?php
include "../connection/dbConnection.php";

 if(isset($_POST['searchval'])){
        $sv = $_POST['searchval'];
         if(!empty($_POST['searchval'])){
        $Query = "select * from medicine where category='Antiseptics' and med_name like '$sv%' or ExpDate like '$sv%' or batchid like  '$sv%' or brand like  '$sv%'   limit 5";
         }
         else
         {
         $Query = "select * from medicine where category='Antiseptics' limit 5";
         }
          $result = mysqli_query($conn, $Query);
    }
 else if(isset($_POST['searchval1'])){
        $sv = $_POST['searchval1'];
        $Query = "select * from medicine where category='Antiseptics' and med_name like '$sv%' limit 5";
        $result = mysqli_query($conn, $Query);
 }
else if(isset($_POST['searchval2'])){
        $sv = $_POST['searchval2'];
        $Query = "select * from medicine where category='Antiseptics' and brand like '$sv%' limit 5";
        $result = mysqli_query($conn, $Query);
 }
 else{
     $Query = "select * from medicine where category='Antiseptics' limit 5";
     $result = mysqli_query($conn, $Query);
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div class="displayData" id="medicine">
              <table>
                    <tr>
                        
                        <th>Medicine Name</th>
                        <th>Expired Date</th>
                        <th>Batch id</th>
                        <th>Brand</th>
                        <th>Remaining Days To expired</th>
                       
                    </tr>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()):  ?>
                       
                            <tr>
                           
                            <td> <?php echo $row["med_name"] ;?> </td>
                            <td> <?php echo $row["ExpDate"] ;?> </td>
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

                            </tr> 
                      <?php endwhile; ?>
                       </tbody>       
            </table>
        </div>"
</body>
</html>