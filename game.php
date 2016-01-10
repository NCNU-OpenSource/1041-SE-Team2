<?php
require('dbconn.php');
if(empty($_SESSION['Id'])){
    header("location:index.html");
}
$id = $_SESSION['Id'];
// echo $_SESSION['Name']." ";
// echo $_SESSION['Id']." ";
// echo $_SESSION['Sex']." ";
$sql="select * from Account where Id='$id' ";
$result=mysqli_query($conn,$sql);
if($rs=mysqli_fetch_array($result)){
    $money=$rs['Money'];
    $exp=$rs['Exp'];
    $level=$rs['Level'];
    $id=$rs['Id'];
    $owner_oven=$rs['Oven_num'];
	$photo_name = $rs['filename'];
}

$sql2="select Exp from Level where Lev=$level+1";
$results=mysqli_query($conn,$sql2);
if($rs2=mysqli_fetch_array($results)){
    $experience=$rs2['Exp'];
}

echo "<script>var exp1=".$exp/$experience."*100;var exp=exp1+\"%\";</script>";  //傳值給javascript

//等級提升
$level_up="select * from Level where Lev=$level+1";
$result_level=mysqli_query($conn,$level_up);
if($rs_level=mysqli_fetch_array($result_level)){  
  //如果經驗值達到可以升等的話
  if($exp>=$rs_level['Exp']){
      $UP="update Account set Level=Level+1 where id='$id' ";
      mysqli_query($conn,$UP);
      echo "<script>alert('等級提升！');setTimeout('window.location.href=\"game.php\"',10)</script>";
      //header('location:game.php');
  }  
}


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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="fork3.ico">
    <title>開心廚房-第二組</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.css">
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <!-- 選擇性佈景主題 -->
    <link rel="stylesheet" href="dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="sky.css">
    <script src="jquery-1.10.2.min.js"></script>
    <!-- 最新編譯和最佳化的 JavaScript -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="jquery-ui-1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="happyK.css">
</head>
<body>
<iframe width="0" height="0" src="https://www.youtube.com/embed/i3yH9mIliBk?list=PLw0uG_yajKILMajsl42xid54TxREOuakM&autoplay=1" frameborder="0" allowfullscreen></iframe>
    <div class="container">
    	<img src="background.jpg" alt="背景" class="imga" >
        <?php 
        if(!empty($photo_name)){
			echo "<a href='uploadpic.php'><img src=\"showpic.php?filename=$photo_name\" alt=\"boy\" class=\"sex\" \></a> ";
		}
		else{
			if($_SESSION['Sex']=='m'){
				echo "<a href='uploadpic.php'><img src=\"boy.jpg\" alt=\"boy\" class=\"sex\" \></a> ";
			}else{
				echo "<a href='uploadpic.php'><img src=\"girl.jpg\" alt=\"girl\" class=\"sex\" \></a> ";
			}
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
        <div class="level">
            <?php echo $_SESSION['Name'];?><br/>
            LV <?php echo $level; ?>
            <br/>    
        </div>
        <div class="money">
            <span class="glyphicon glyphicon-usd" id="Addmoney"><?php echo $money; ?></span>
        </div>
        <button type="button" class="btn btn-info" id="logout"> 登出 <span class="glyphicon glyphicon-user"></span></button><br/><br/><br/>
        <div class="btn-group-lg">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#storeModal"> 商 店 <span class="glyphicon glyphicon-shopping-cart"></span></button><br/><br/>
            <button type="button" class="btn btn-default" id="opener"> 烘 培 <span class="glyphicon glyphicon-fire"></span></button><br/><br/>
            <button type="button" class="btn btn-default" id="Bag_Modal"> 背 包 <span class="badge"></span><span class="glyphicon glyphicon-briefcase"></span></button><br/><br/>
        </div>
    </div>


    <div id="trash" class="ui-widget-content ui-state-default">
        <form enctype='application/json' id="breadform"  >
        <h4 class="ui-widget-header"> Oven</h4>
        <button type="button" class="btn btn-default" id="bake">烘！</button>
        <h5 id="oven_status"></h5>
        <div id="panel"></div>
        <hr/>
        </form>
    </div>

    <div id="bakedbread" >
        <h4 class="ui-widget-header"> Baking</h4>
        <table class="table" id="breadtable">
        </table>
    </div>

    <div class="ui-widget ui-helper-clearfix" id="breadbar">
        <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
        </ul>
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

    <!-- Bag Modal -->
    <div class="modal fade" id="BagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <br/>
              <table class="table" id="bagtable">
              </table>
            </div>

            <div class="modal-body">
            </div>
        </div>
      </div>
    </div>




</body>
</html>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
<script>
$(document).ready(function() {
    $('#bake').hide();  
    $("#trash").hide();
    $('#bakedbread').hide();
    $('#breadbar').hide();

   $('.progress-bar').css("width",exp);  //產生經驗值條
   //烤箱箭頭
   $('#o_right').on("click",oadd);
   $('#o_left').on('click',osubtract);
   //材料包箭頭
   $('#p_right').on("click",padd);
   $('#p_left').on('click',psubtract);
   //登出
    $('#logout').on("click",out);

        $( "#opener" ).click(function() {
        $("#trash").slideToggle();
        $('#breadbar').fadeToggle();
        $('#bakedbread').fadeToggle();
    });
    // there's the gallery and the trash
    var $gallery = $( "#gallery" ),
      $trash = $( "#trash" );
 
    // let the gallery items be draggable
    $( "li", $gallery ).draggable({
      cancel: "a.ui-icon", // clicking an icon won't initiate dragging
      revert: "invalid", // when not dropped, the item will revert back to its initial position
      containment: "document",
      helper: "clone",
      cursor: "move",
    });
 
    // let the trash be droppable, accepting the gallery items
    $trash.droppable({
      accept: "#gallery > li",
      activeClass: "ui-state-highlight",
      drop: function( event, ui ) {
        deleteImage( ui.draggable );
        //alert(ui.draggable.find("h5").text());
         if($("ul#oven >li").length+1>0){
            $('#bake').show();
        }   
      }
    });
 
    // let the gallery be droppable as well, accepting items from the trash
    $gallery.droppable({
      accept: "#trash li",
      activeClass: "custom-state-active",
      drop: function( event, ui ) {
        recycleImage( ui.draggable );
        var item= ui.draggable.find("h5").text();
        $('#'+item).remove();     
    }
    });
 
    // image deletion function
    function deleteImage( $item ) {
      $item.fadeOut(function() {
        var $list = $( "ul", $trash ).length ?
          $( "ul", $trash ) :
          $( "<ul class='gallery ui-helper-reset' id='oven'/>" ).appendTo( $trash );
 
        $item.find( "a.ui-icon-trash" ).remove();
        $item/*.append( recycle_icon )*/.appendTo( $list ).fadeIn(function() {
          $item
            .animate({ width: "48px" })
            .find( "img" )
              .animate({ height: "36px" });
        });
      }); 
    }
    // image recycle function
    function recycleImage( $item ) {
      $item.fadeOut(function() {
        $item
          .find( "a.ui-icon-refresh" )
            .remove()
          .end()
          .css( "width", "96px")
          // .append( trash_icon )
          .find( "img" )
            .css( "height", "72px" )
          .end()
          .appendTo( $gallery )
          .fadeIn();
      });
    }
     // 檢查烤箱數量以及長度是否符合
    $trash.on( "drop", function( event, ui ) {
       setTimeout(function () {
                 $("#droppable").promise().done(function () {
                     if( $("ul#oven>li").length > canuse){
                        alert('超過你擁有的烤箱數量'); 
                        recycleImage( ui.draggable );
                     }else{
                        $('#panel').append("<div id="+ui.draggable.find('h5').text()+">"+ui.draggable.find('h5').text()+':'+"<input type='text' name='"+ui.draggable.find('h5').text()+"' value='1' ></div>");
                     }
                 });
             }, 1000);
    });
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
                location.reload();
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
                location.reload();
            }
        });
});

//烘
$('#bake').on("click",function (){ 
    var data=$('#breadform').serializeArray();
    $.ajax({
        url: 'bake.php',
        dataType: 'html',
        type: 'GET',
        data: { 
            Id:'<?php echo $id; ?>',
            data:data
        },
        error: function(xhr) {
               // $('#'+DIV).html(xhr);
            },
        success: function(response) {
           alert(response);
           console.log(response);
           location.reload();
        }
    });
});

//背包畫面
$('#Bag_Modal').on('click',function(){
    $.ajax({
        url: 'bag.php',
        dataType: 'html',
        type: 'POST',
        data: { 
            Id:'<?php echo $id; ?>',
        },
        error: function(xhr) {
               // $('#'+DIV).html(xhr);
            },
        success: function(response) {
          $('#bagtable').empty();
          $('#bagtable').append('<tr><td>麵包名稱</td><td>經驗值</td><td>金錢</td><td>賣掉</td><tr/>');
          var cart= JSON.parse(response);
          //alert(cart.length);
          for(var i=0;i<cart.length;i++){
            var number=cart[i]['No'];
            $('#bagtable').append('<tr><td>'+cart[i]['Now_id']+'</td><td>'+cart[i]['Exp']+'</td><td>'+cart[i]['Price']+'</td><td><a href="sale.php?No='+cart[i]['No']+'&Name='+cart[i]['Now_id']+'" >賣掉</a></td><tr/>');
	    $('tr#'+number).empty();
          }
          console.log(response);
            //location.reload();
        }
    });
    $('#BagModal').modal('toggle');
});
</script>
<?php
$select_bread="select Name,Count from Bread where Level <= $level order by Count desc";
$result_bread=mysqli_query($conn,$select_bread);

echo "<script>$('#gallery')";
while($rs_bread=mysqli_fetch_array($result_bread)){
  echo ".append('<li class=\"ui-widget-content ui-corner-tr\"><h5 class=\"ui-widget-header\">",$rs_bread['Name'],"</h5><img src=\"material/",$rs_bread['Name'],".png\" alt=\"Bread\" width=\"96\" height=\"72\"><a href=\"#\" class=\"ui-icon-zoomin\">cost:",$rs_bread['Count'],"</a></li>')";
}
echo ";</script>";

$select_all_oven="select COUNT(*) as total,Package from Oven left join Account on Account.Id=Oven.Owner where Owner='$id'";
$result_all_oven=mysqli_query($conn,$select_all_oven);
if($rs_all_oven=mysqli_fetch_array($result_all_oven)){
    $total=$rs_all_oven['total'];
    $package_num=$rs_all_oven['Package'];
}

$select_oven="select COUNT(*) as used from Oven where Owner='$id' and (State =1 or State =2)";
$result_oven=mysqli_query($conn,$select_oven);
if($rs_oven=mysqli_fetch_array($result_oven)){
    $used=$rs_oven['used'];
}
$canuse=$total-$used;
echo "<script>$('#oven_status').append('你有",$canuse,"個烤箱可以使用，使用",$rs_oven['used'],"個烤箱中。<br/>材料包數量： ",$package_num,"');</script>";
echo "<script>var canuse=",$canuse,";</script>";

//使用中的烤箱顯示在螢幕右邊，缺倒數
$select_used_oven="select * from Oven where Owner='$id' and State=1 order by Time";
$result_used_oven=mysqli_query($conn,$select_used_oven);
if(empty($result_used_oven)){
    //do nothing
}else{
    echo "<script>$('#breadtable').append('<tr><td> 時間 </td><td> 麵包名稱 </td>')";
    while($rs_used_oven=mysqli_fetch_array($result_used_oven)){
        echo ".append('</tr><tr id=",$rs_used_oven['No'],"><td> ",$rs_used_oven['Time']," </td><td>",$rs_used_oven['Now_id'],"</td>')";
    }
    echo ".append('</tr>');</script>";
}
?>
