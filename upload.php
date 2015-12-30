<?php   

    //取得上傳檔案資訊

    $filename = $_FILES['image']['name'];

    $tmpname = $_FILES['image']['tmp_name'];

    $filetype = $_FILES['image']['type'];

    $filesize = $_FILES['image']['size'];    

    $file = NULL;

    echo "$filename,$tmpname,$filetype,$filesize,$file";
	
    if(isset($_FILES['image']['error'])){    

        if($_FILES['image']['error']==0){                                 
            $instr = fopen($tmpname,"rb" );
            $file = addslashes(fread($instr,filesize($tmpname)));
        }
	}	
	
	move_uploaded_file($_FILES["image"]["tmp_name"],"upload/".$_FILES["image"]["name"]);
?>