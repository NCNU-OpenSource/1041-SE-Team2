<?php
require('dbconn.php');

$id=$_GET['Id'];
$data=$_GET['data'];

$sql="select COUNT(*) as unused from Oven where Owner='$id' and State=0";
$result=mysqli_query($conn,$sql);
if($rs=mysqli_fetch_array($result)){
	$unused=$rs['unused'];
}

$value=json_encode($data);

//json 轉成 stdClass Objects
$std_objects=json_decode($value);

//stdClass Objects 轉成 array
function objectToArray($d) {
	if (is_object($d)) {
	// Gets the properties of the given object
	// with get_object_vars function
		$d = get_object_vars($d);
	}
	if (is_array($d)) {
	/*
	* Return array converted to object
	* Using __FUNCTION__ (Magic constant)
	* for recursive call
	*/
		return array_map(__FUNCTION__, $d);
	}
	else {
	// Return array
		return $d;
	}
}
$number=0;
$array=objectToArray($std_objects);
// print_r ($array);
//echo $array[0]['name'];
foreach ($array as $key => $value) {
	foreach($value as $key1 => $value1){
		echo "$key:$key1 $value1 \n";
		if($key1=='value'){
			$number+=$value1;
		}
	}
}


//計算材料包夠不夠
$pack_num=0;
$select_owner_package="select Package from Account where id='$id' ";
$result_owner_package=mysqli_query($conn,$select_owner_package);
if($rs_owner_package=mysqli_fetch_array($result_owner_package)){
	$total_package=$rs_owner_package['Package'];
}

foreach ($array as $key => $value) {
	foreach($value as $key1 => $value1){
		if($key1=='name'){
			$sql1="select Count from Bread where Name='$value1' ";
			$result1=mysqli_query($conn,$sql1);
			if($rs1=mysqli_fetch_array($result1)){
				$count=$rs1['Count'];
			}
		}
		if($key1=='value'){
			$pack_num+=$count*$value1;
		}
	}
}

//查詢所有麵包花費的時間
$select_all_bread_cost="select Name,Cost_time from Bread";


if($number>$unused){
	echo "烤箱沒這麼多！請至商店購買";
}
else if($pack_num>$total_package){
	echo "材料包沒這麼多！請至商店購買";
}else{
	//烤的細節
	//查出所有能用的烤箱
	$select_oven="select * from Oven where Owner='$id' and State=0 order by No asc";
	$result_select_oven=mysqli_query($conn,$select_oven);
	while($rs_select_oven=mysqli_fetch_array($result_select_oven)){

	}
	echo "正在烤！請稍候";
}


?>