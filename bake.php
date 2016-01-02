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
		//echo "$key:$key1 $value1 \n";
		if($key1=='value'){
			$number+=$value1;
		}
	}
}
//echo $number;

//計算材料包夠不夠
$pack_num=0;
$select_owner_package="select Package from Account where id='$id' ";
$result_owner_package=mysqli_query($conn,$select_owner_package);
if($rs_owner_package=mysqli_fetch_array($result_owner_package)){
	$total_package=$rs_owner_package['Package'];
}

$bread=array();
$i=0;
foreach ($array as $key => $value) {
	foreach($value as $key1 => $value1){
		if($key1=='name'){
			$sql1="select Count,Cost_time from Bread where Name='$value1' ";
			$result1=mysqli_query($conn,$sql1);
			if($rs1=mysqli_fetch_array($result1)){
				$count=$rs1['Count'];
				$bread[$i++]=$rs1['Cost_time'];
			}
		}
		if($key1=='value'){
			$pack_num+=$count*$value1;
		}
	}
}
//print_r($bread);
// //查詢所有麵包花費的時間
// $select_all_bread_cost="select Name,Cost_time from Bread";
// $result_select_all_bread_cost=mysqli_query($conn,$select_all_bread_cost);
// while($rs_all_bread_cost=mysqli_fetch_array($result_select_all_bread_cost)){
// 	$bread[$i]=$rs_all_bread_cost['Name'];
// 	$i++;
// 	$bread[$i]=$rs_all_bread_cost['Cost_time'];
// 	$i++;
// }


if($number>$unused){
	echo "烤箱沒這麼多！請至商店購買";
}
else if($pack_num>$total_package){
	echo "材料包沒這麼多！請至商店購買";
}else{
	//烤的細節

	$all_oven=array();
	$j=0;
	//查出所有能用的烤箱
	$select_oven="select * from Oven where Owner='$id' and State=0 order by No asc LIMIT $number";
	$result_select_oven=mysqli_query($conn,$select_oven);
	while($rs_select_oven=mysqli_fetch_array($result_select_oven)){
		$all_oven[$j]=$rs_select_oven['No'];
		$j++;
	}
	//print_r($all_oven);

	$time=time();
	$in=0;
	for($index=0;$index<$number;$index++){  //有幾個麵包跑幾次
		
		//將倒數時間update,state設為1
		$bread_name=$array[$in]['name'];
		
		if($array[$in]['value']!=1){
			for($times=0;$times<$array[$in]['value'];$times++){
				$No=$all_oven[$index];
				$arrive_time=$time+$bread[$in];
				// echo $bread[$in];
				$update="update Oven set Time=FROM_UNIXTIME(".$arrive_time."),Now_id='$bread_name',State=1 where No=$No ";
				mysqli_query($conn,$update);
				$index++;
			}
			$in++;
			$index--;
		}else{
			$No=$all_oven[$index];
			$arrive_time=$time+$bread[$in];
			$update="update Oven set Time=FROM_UNIXTIME(".$arrive_time."),Now_id='$bread_name',State=1 where No=$No ";
			mysqli_query($conn,$update);
			// echo $bread[$in];
			$in++;

		}
	}
	//更改使用者材料包數量
	$pack=$total_package-$pack_num;
	$update_owner="update Account set Package=$pack where Id='$id' ";
	mysqli_query($conn,$update_owner);

	echo "正在烤！請稍候";
}


?>