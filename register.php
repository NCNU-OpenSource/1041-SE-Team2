<?php
require('dbconn.php');
$id=mysqli_real_escape_string($conn,$_POST['id']);
$password=md5(mysqli_real_escape_string($conn,$_POST['password']));
$sex=mysqli_real_escape_string($conn,$_POST['sex']);
$name=mysqli_real_escape_string($conn,$_POST['name']);


if ($id) {
	$sql = "insert into Account (Id,Password,Sex,Name) values ('$id', '$password','$sex','$name');";
	mysqli_query($conn,$sql) or die("MySQL insert message error"); //執行SQL
	echo "<script>alert('註冊成功!');
			window.location.href=\"index.html\"; </script>";
	
} else {
	echo "error, cannot insert.";
}

?>