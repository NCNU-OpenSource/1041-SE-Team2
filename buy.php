<?php
require('dbconn.php');
$id=$_POST['Id'];

if(isset($_POST['Oven_num'])){
	$oven_num=$_POST['Oven_num'];
	$sql="select Money,Oven_num from Account where Id='$id'";
	$result=mysqli_query($conn,$sql);
	if($rs=mysqli_fetch_array($result)){
		$money=$rs['Money'];
		$Oven=$rs['Oven_num'];
	}
	if(( $money >= $oven_num * 1000)){
		$amount = $money-$oven_num*1000;
		$sql1="update Account set Money=$amount ,Oven_num=$Oven+$oven_num where Id='$id' ";
		mysqli_query($conn,$sql1);
		echo "<script>alert('購買成功！')</script>";
		echo $amount;
	}else{
		echo "<script>alert('餘額不足！')</script>"; 
		echo "$money";
	}
}

if(isset($_POST['Package'])){
	$package=$_POST['Package'];
	$sql="select Money,Package from Account where Id='$id'";
	$result=mysqli_query($conn,$sql);
	if($rs=mysqli_fetch_array($result)){
		$money=$rs['Money'];
		$Package=$rs['Package'];
	}
	if(( $money >= $package * 100)){
		$amount = $money-$package*100;
		$sql1="update Account set Money=$amount ,Package=$Package+$package where Id='$id' ";
		mysqli_query($conn,$sql1);
		echo "<script>alert('購買成功！')</script>";
		echo $amount;
	}else{
		echo "<script>alert('餘額不足！')</script>"; 
		echo "$money";
	}
}


?>