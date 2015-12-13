<?php
require('dbconn.php');
$id=mysqli_real_escape_string($conn,$_POST['id']);
$pwd=md5(mysqli_real_escape_string($conn,$_POST['password']));

if(isset($_POST['id']) && isset($_POST['password']))
{
	$userName = $id;
	$passWord = $pwd;
	$sql = "SELECT * FROM Account WHERE Id='" . $userName . "' AND Password= '" . $passWord . "'";
		if ($result = mysqli_query($conn,$sql)) {
			if ($row=mysqli_fetch_array($result)) {
				$_SESSION['Name']=$row['Name'];
				header("location:game.php");
			} else{
				echo "Invalid Username or Password - Please try again <br />";
			}
		}
}else{
	$userName = "";
	$passWord = "";
}
?>