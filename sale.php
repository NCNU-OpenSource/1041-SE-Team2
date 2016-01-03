<?php
require('dbconn.php');
$id=$_SESSION['Id'];
$No=$_GET['No'];
$Name=$_GET['Name'];

//查詢麵包經驗值，價錢
$select="select Exp,Price from Bread where Name='$Name' ";
$result=mysqli_query($conn,$select);
if($rs=mysqli_fetch_array($result)){
	$Money=$rs['Price'];
	$Exp=$rs['Exp'];
}


//更改烤箱狀態
$sql="update Oven set Now_id=null,State=0 where No=$No ";
mysqli_query($conn,$sql);

//更改使用者經驗值，錢
$user="update Account set Exp=Exp+$Exp , Money=Money+$Money where Id='$id' ";
mysqli_query($conn,$user);

echo "<script>alert('成功賣出，經驗值增加",$Exp,"，錢增加",$Money,"');window.location.href='game.php';</script>";
?>