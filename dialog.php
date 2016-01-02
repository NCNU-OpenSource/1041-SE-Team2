<?php
require('dbconn.php');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Dialog - Animation</title>
  <link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.css">
  <script src="jquery-1.10.2.min.js"></script>
  <script src="jquery-ui-1.11.4/jquery-ui.js"></script>

  <link rel="stylesheet" href="oven.css">
  <script>

  $(function() {

    $("#trash").hide();
    $('#breadbar').hide();
    $( "#opener" ).click(function() {
        $("#trash").slideToggle();
        $('#breadbar').fadeToggle();
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
      start:function(){
        activeClass: "zposition"
      }
    });
 
    // let the trash be droppable, accepting the gallery items
    $trash.droppable({
      accept: "#gallery > li",
      activeClass: "ui-state-highlight",
      drop: function( event, ui ) {
        deleteImage( ui.draggable );
        alert(ui.draggable.find("h5").text());
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
          if( $("ul#oven>li").length >2){
            alert('Exceed'); 
              recycleImage( ui.draggable );
            }else{
              $('#panel').append("<div id="+ui.draggable.find('h5').text()+">"+ui.draggable.find('h5').text()+':'+"<input type='text' name='"+ui.draggable.find('h5').text()+"' value='1' ></div>");
            }
          });
        }, 1000);
    });
  });

  </script>
</head>
<body>

<div id="trash" class="ui-widget-content ui-state-default">
  <h4 class="ui-widget-header"> Oven</h4>
  <input type="submit">
  <h5></h5>
  <h5></h5>
<div id="panel"></div>
  <hr/>
</div>

<div class="ui-widget ui-helper-clearfix" id="breadbar">
<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
</ul>
 </div>

<button id="opener">Open Dialog</button>
 
</body>
</html>
<?php
$select_bread="select Name,Count from Bread where Level<=2";
$result_bread=mysqli_query($conn,$select_bread);

echo "<script>$('#gallery')";
while($rs_bread=mysqli_fetch_array($result_bread)){
  echo ".append('<li class=\"ui-widget-content ui-corner-tr\"><h5 class=\"ui-widget-header\">",$rs_bread['Name'],"</h5><img src=\"material/",$rs_bread['Name'],".png\" alt=\"Bread\" width=\"96\" height=\"72\"><a href=\"#\" class=\"ui-icon-zoomin\">cost:",$rs_bread['Count'],"</a></li>')";
}
echo ";</script>";

$select_all_oven="select COUNT(*) as total from Oven where Owner='user2'";
$result_all_oven=mysqli_query($conn,$select_all_oven);
if($rs_all_oven=mysqli_fetch_array($result_all_oven)){
  echo $rs_all_oven['total'];
}

$select_oven="select COUNT(*) as used from Oven where Owner='user2' and State=1 ";
$result_oven=mysqli_query($conn,$select_oven);
if($rs_oven=mysqli_fetch_array($result_oven)){
  echo  $rs_oven['used'];
}
?>