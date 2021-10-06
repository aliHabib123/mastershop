$(function () {
  $("#color-selector").change(function () {
    let size = "";
    const color = $(this).children("option:selected").val();
    if ($("#size-selector").length > 0) {
      size = $("#size-selector").children("option:selected").val();
      if(size == ""){
        $(){
          
        }
      }
    }
    alert("color: " + color + " size: " + size);
  });
  $("#size-selector").change(function () {
    const color = $("#color-selector").children("option:selected").val();
    const size = $(this).children("option:selected").val();
    alert("color: " + color + " size: " + size);
  });
});
