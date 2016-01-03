<?php
require('dbconn.php');

$id='user1';
$indentify_bake_time="select Time,No,State from Oven where Owner='$id' ";  
$result_indentify=mysqli_query($conn,$indentify_bake_time);
$now_time=time();
$convert_time=date("Y-m-d H:i:s",$now_time);

while($rs_identify=mysqli_fetch_array($result_indentify)){

    if(strtotime($convert_time) - strtotime($rs_identify['Time'])>=0 && ($rs_identify['Time'])!=null ){
        //時間到了 更改烤箱狀態 把東西放進背包(State=3)
        // $No=$rs_identify['No'];
        // $update_bake="update Oven set Time=null,State=2 where No=$No ";
        // mysqli_query($conn,$update_bake);
        echo "YES";
    }else{
    	echo "No";
    }
}

?>