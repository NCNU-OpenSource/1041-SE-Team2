<?php
require('dbconn.php');
if(empty($_SESSION['Id'])){
    header("location:index.html");
}
$id = $_SESSION['Id'];
echo $_SESSION['Name']." ";
echo $_SESSION['Id']." ";
echo $_SESSION['Sex']." ";
$sql="select * from Account where Id='$id' ";
$result=mysqli_query($conn,$sql);
if($rs=mysqli_fetch_array($result)){
    $money=$rs['Money'];
    $exp=$rs['Exp'];
    $level=$rs['Level'];
    $id=$rs['Id'];
}

$sql2="select Exp from Level where Lev=$level+1";
$results=mysqli_query($conn,$sql2);
if($rs2=mysqli_fetch_array($results)){
    $experience=$rs2['Exp'];
}

echo "<script>var exp1=".$exp/$experience."*100;var exp=exp1+\"%\";</script>";  //傳值給javascript

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="k.ico">
    <title>開心廚房-第二組</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- 選擇性佈景主題 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="sky.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 最新編譯和最佳化的 JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
    	.img{
			position:absolute;
			left:50%;
			top:50%;
			margin-top:-300px;
			margin-left:-400px;
			border:solid;
    	}
    	.sex{
    		position:absolute;
    		left:50%;
			top:50%;
			margin-top:-270px;
			margin-left:-280px;
    		border:solid;
            max-width:100px;
            max-height:100px;
    	}
        .btn-group-lg{
            position:absolute;
            left:50%;
            top:50%;
            margin-top:-260px;
            margin-left:230px;
        }
        #logout{
            position:absolute;
            left:50%;
            top:50%;
            margin-top:-270px;
            margin-left:-370px;       
        }
        .money{
            position:absolute;
            left:50%;
            top:50%;
            margin-top:-190px;
            margin-left:-370px;
        }
        .col-md-2 {
            position:absolute;
            left:50%;
            top:50%;
            margin-top:-170px;
            margin-left:-380px;
        }
        .img-thumbnail{
            max-width:200px;
            max-height:200px;
        }
        
    </style>
</head>
<body>
    <div class="container">
    	<img src="background.jpg" alt="背景" class="img" >
        <?php 
        if($_SESSION['Sex']=='m'){
            echo "<img src=\"material/people.jpg\" alt=\"boy\" class=\"sex\" \> ";
        }else{
            echo "<img src=\"girl.jpg\" alt=\"girl\" class=\"sex\" \> ";
        }

        ?>
        <div class="row">
            <div class="col-md-2">
                Exp
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" >
                        <span><?php echo $exp."/".$experience; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="money">
            <span class="glyphicon glyphicon-usd" id="Addmoney"><?php echo $money; ?></span>
        </div>
        <button type="button" class="btn btn-info" id="logout"> 登出 <span class="glyphicon glyphicon-user"></span></button><br/><br/><br/>
        <div class="btn-group-lg">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#storeModal"> 商 店 <span class="glyphicon glyphicon-shopping-cart"></span></button><br/><br/>
            <button type="button" class="btn btn-default"> 烘 培 <span class="glyphicon glyphicon-fire"></span></button><br/><br/>
            <button type="button" class="btn btn-default"> 背 包 <span class="badge"></span><span class="glyphicon glyphicon-briefcase"></span></button><br/><br/>
        <div>
    </div>



    <!-- Store Modal -->
    <div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <br/>
          </div>

          <div class="modal-body">
            <form class="form-inline" role="form">
                <div class="form-group">&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="material/oven.png" alt="烤箱數量" class="img-thumbnail">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-chevron-left" id="o_left"></span>&nbsp;
                    <input type="text" class="form-control" value="0" id="oven" style="width:100px">&nbsp;
                    <span class="glyphicon glyphicon-chevron-right" id="o_right"></span>&nbsp;
                    <button type="button" class="btn btn-default" id="o_buy">購買</button>  <br/>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-usd" id="Addmoney"></span> 1000          
                </div>
                    <hr/>&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="material/food_bag.png" alt="材料包數量" class="img-thumbnail">   
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-chevron-left" id="p_left"></span>&nbsp;
                    <input type="text" class="form-control" value="0" id="package" style="width:100px">&nbsp;
                    <span class="glyphicon glyphicon-chevron-right" id="p_right"></span>&nbsp;
                    <button type="button" class="btn btn-default" id="p_buy">購買</button>  <br/>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-usd" id="Addmoney"></span> 100       
                 
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End -->
</body>
</html>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
<script>
$(document).ready(function() {
   $('.progress-bar').css("width",exp);  //產生經驗值條
   //烤箱箭頭
   $('#o_right').on("click",oadd);
   $('#o_left').on('click',osubtract);
   //材料包箭頭
   $('#p_right').on("click",padd);
   $('#p_left').on('click',psubtract);
   //登出
    $('#logout').on("click",out);
    
});
function out(){ 
    window.location.href="logout.php";
}
function oadd(){
    var value=$('#oven').val();
    value++;
    $('#oven').val(value);
}
function osubtract(){
    var value=$('#oven').val();
    value--;
    if(value<=0){
        $('#oven').val(0);
    }
    else{
        $('#oven').val(value);
    }
}
function padd(){
    var value=$('#package').val();
    value++;
    $('#package').val(value);
}
function psubtract(){
    var value=$('#package').val();
    value--;
    if(value<=0){
        $('#package').val(0);
    }
    else{
        $('#package').val(value);
    }
}
// 烤箱購買
$('#o_buy').on("click",function (){
    var buy = $('#oven').val();
    $.ajax({
            url: 'buy.php',
            dataType: 'html',
            type: 'POST',
            data: { 
                Oven_num: buy,
                Id:'<?php echo $rs['Id'] ?>'
            },
            error: function(xhr) {
               // $('#'+DIV).html(xhr);
                },
            success: function(response) {
                //$('#'+DIV).html(response); //set the html content of the object msg
                $('.money').empty();
                $('.money').append("<span class='glyphicon glyphicon-usd' id='Addmoney'></span>").append(response);
            }
        });
});
// 材料包購買
$('#p_buy').on("click",function (){
    var buy = $('#package').val();
    $.ajax({
            url: 'buy.php',
            dataType: 'html',
            type: 'POST',
            data: { 
                Package: buy,
                Id:'<?php echo $rs['Id'] ?>'
            },
            error: function(xhr) {
               // $('#'+DIV).html(xhr);
                },
            success: function(response) {
                //$('#'+DIV).html(response); //set the html content of the object msg
                $('.money').empty();
                $('.money').append("<span class='glyphicon glyphicon-usd' id='Addmoney'></span>").append(response);
            }
        });
});
</script>