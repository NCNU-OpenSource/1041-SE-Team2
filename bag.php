<?php
require('dbconn.php');
$id=$_POST['Id'];

$sql="select * from Oven left join Bread on Bread.Name=Oven.Now_id where Owner='$id' and State=2 ";
$result=mysqli_query($conn,$sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) { 
    $data[] = $row;
} 
$json_string = json_encode($data);
echo $json_string;	

?>