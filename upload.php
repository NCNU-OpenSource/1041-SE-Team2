<?php   
	session_start();
	$id = $_SESSION['Id'];
    //取得上傳檔案資訊

    $filename = $_FILES['upfile']['name'];

    $tmpname = $_FILES['upfile']['tmp_name'];

    $filetype = $_FILES['upfile']['type'];

    $filesize = $_FILES['upfile']['size'];    

    $file = NULL;
	
	if($filesize > 100000){
		echo "<script>alert('上傳檔案不符合標準 - Please try again');window.location.href='uploadpic.php';</script>";
	}
	if($filetype == "image/jpeg" || $filetype == "image/png")
	{	
	
		if( $_FILES["upfile"]["size"] > 0 )
        {
		
         //開啟圖片檔
         $file = fopen($_FILES["upfile"]["tmp_name"], "rb");
         // 讀入圖片檔資料
         $fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"]));
         //關閉圖片檔
         fclose($file);

         // 圖片檔案資料編碼
         $fileContents = base64_encode($fileContents);

         //連結MySQL Server
         $conn = mysqli_connect("localhost","myid","12345","kitchen");
         mysqli_query($conn,"SET NAMES utf8");
         //組合查詢字串 
         $SQLSTR="Update Account set filename = '$filename', filetype = '$filetype', filepic = '$fileContents' where Id='$id';";
         //將圖片檔案資料寫入資料庫 
         mysqli_query($conn,$SQLSTR) or die("MySQL update message error");
            echo "<a href=\"showpic.php?filename="
                 . $_FILES["upfile"]["name"] . "\">"
                 . $_FILES["upfile"]["name"] . "</a>";
		header("location:game.php");
        }
	}
      else	
        {
         echo "<script>alert('上傳檔案不符合標準2 - Please try again');window.location.href='uploadpic.php';</script>";
        }
?>