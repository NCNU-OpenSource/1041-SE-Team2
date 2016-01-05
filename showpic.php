<?php
	
    require('dbconn.php');
    $SQLSTR="select * from Account where filename='"
         . $_REQUEST["filename"] . "'";
	$result = mysqli_query($conn,$SQLSTR);
	
	if($rs = mysqli_fetch_array($result)){
		$ph = $rs['filetype'];
	}
	
	header("Content-Type: $ph");//設定網頁資料格式
	
	echo base64_decode($rs['filepic']);// 輸出圖片資料
	echo $rs['filename'];
	
	
	
	
?>
    
