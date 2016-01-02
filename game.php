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
    $owner_oven=$rs['Oven_num'];
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
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="k.ico">
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
    <style type="text/css">
    #bakedbread{
        position:absolute;
        left:81.5%;
        width:18%;
        background:#ddd;
    }
  #breadbar ul#gallery{
    position:absolute;
    top:50%;
    width:100%;
    height:140px;
    margin-top:200px;
  }
  #gallery { float: left; width: 65%; }
  .gallery.custom-state-active { background: #eee; }
  .gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
  .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
  .gallery li a { float: right; }
  .gallery li a.ui-icon-zoomin { float: left; }
  .gallery li img { width: 100%; cursor: move; }
  #panel input{width:50px;}
 
  #trash {float: left; width: 20%; min-height: 18em;   }
  #trash h4 { line-height: 16px; margin: 0 0 0.4em; }
  #trash .gallery h5 { display: none; }
    	.imga{
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
        .level{
            position:absolute;
            left:50%;
            top:50%;
            margin-top:-190px;
            margin-left:-366px;
        }
        .money{
            position:absolute;
            left:50%;
            top:50%;
            margin-top:-220px;
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
    	<img src="background.jpg" alt="背景" class="imga" >
        <?php 
        if($_SESSION['Sex']=='m'){
            echo "<img src=\"boy.jpg\" alt=\"boy\" class=\"sex\" \> ";
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
        <div class="level">
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
            <button type="button" class="btn btn-default"> 背 包 <span class="badge"></span><span class="glyphicon glyphicon-briefcase"></span></button><br/><br/>
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
        alert(ui.draggable.find("h5").text());
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
</script>
<?php
$select_bread="select Name,Count from Bread where Level <= $level";
$result_bread=mysqli_query($conn,$select_bread);

echo "<script>$('#gallery')";
while($rs_bread=mysqli_fetch_array($result_bread)){
  echo ".append('<li class=\"ui-widget-content ui-corner-tr\"><h5 class=\"ui-widget-header\">",$rs_bread['Name'],"</h5><img src=\"material/",$rs_bread['Name'],".png\" alt=\"Bread\" width=\"96\" height=\"72\"><a href=\"#\" class=\"ui-icon-zoomin\">cost:",$rs_bread['Count'],"</a></li>')";
}
echo ";</script>";

$select_all_oven="select COUNT(*) as total,Package from Oven left join Account on Account.Id=Oven.Owner where Owner='$id'
";
$result_all_oven=mysqli_query($conn,$select_all_oven);
if($rs_all_oven=mysqli_fetch_array($result_all_oven)){
    $total=$rs_all_oven['total'];
    $package_num=$rs_all_oven['Package'];
}

$select_oven="select COUNT(*) as used from Oven where Owner='$id' and State=1 ";
$result_oven=mysqli_query($conn,$select_oven);
if($rs_oven=mysqli_fetch_array($result_oven)){
    $used=$rs_oven['used'];
}
echo "<script>$('#oven_status').append('你有",$rs_all_oven['total']-$rs_oven['used'],"個烤箱可以使用，使用",$rs_oven['used'],"個烤箱中。<br/>材料包數量： ",$package_num,"');</script>";
$canuse=$total-$used;
echo "<script>var canuse=",$canuse,";</script>";

//使用中的烤箱顯示在螢幕右邊，缺倒數，時間到自動放進包包
//包包還沒完成 ，點擊可以賣掉 經驗值增加，錢增加
$select_used_oven="select Count(*) as total,* from Oven where Owner='$id' and State=1 ";
$result_used_oven=mysqli_query($conn,$select_used_oven);
if(empty($result_used_oven)){
    //do nothing
}else{
    while($rs_used_oven=mysqli_fetch_array($result_used_oven)){

    }
}
?>
