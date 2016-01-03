<?php
require('dbconn.php');
$id=$_POST['Id'];

//判斷烤箱是否到期
$indentify_bake_time="select Time,No,State from Oven where Owner='$id' ";  
$result_indentify=mysqli_query($conn,$indentify_bake_time);
$now_time=time();
$convert_time=date("Y-m-d H:i:s",$now_time);

while($rs_identify=mysqli_fetch_array($result_indentify)){
    if(strtotime($convert_time) - strtotime($rs_identify['Time'])>=0 && ($rs_identify['Time'])!=null){
        //時間到了 更改烤箱狀態 把東西放進背包(State=3)
        $No=$rs_identify['No'];
        $update_bake="update Oven set Time=null,State=2 where No=$No ";
        mysqli_query($conn,$update_bake);
    }
}

$sql="select * from Oven left join Bread on Bread.Name=Oven.Now_id where Owner='$id' and State=2 ";
$result=mysqli_query($conn,$sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) { 
    $data[] = $row;
} 
$json_string = json_encode($data);
echo $json_string;	

?>