$(function () {
  if ($(".single-product-main-wrapper").length > 0) {
    const variantMsgArea = $("#variant-msg");
    const productId = $("#product-id").val();
    //alert(productId);
    $("#color-selector").change(function () {
      let okToGetVariation = false;
      let size = "";
      const color = $(this).children("option:selected").val();
      if (color != "") {
        okToGetVariation = true;
        if ($("#size-selector").length > 0) {
          size = $("#size-selector").children("option:selected").val();
          if (size == "") {
            okToGetVariation = false;
            variantMsgArea.html("select size");
          } else {
            okToGetVariation = true;
            variantMsgArea.html("ok");
          }
        }
      }

      if (okToGetVariation) {
        getVariation(productId, color, size);
      }
    });
    $("#size-selector").change(function () {
      let okToGetVariation = false;
      let color = "";
      const size = $(this).children("option:selected").val();
      if (size != "") {
        okToGetVariation = true;
        if ($("#size-selector").length > 0) {
          color = $("#color-selector").children("option:selected").val();
          if (color == "") {
            okToGetVariation = false;
            variantMsgArea.html("select color");
          } else {
            okToGetVariation = true;
            variantMsgArea.html("ok");
          }
        }
      }

      if (okToGetVariation) {
        getVariation(productId, color, size);
      }
    });

    function getVariation(id, color, size) {
      $.ajax({
        url: mainUrl + "get-product-variation",
        type: "POST",
        dataType: "json",
        data: { id: id, color: color, size: size },
        beforeSend: function () {},
        success: function (response) {
          console.log(response);
          if (response.result) {
            $("#add-to-cart-btn").attr("data-item-id", response.item.id);
            $(".price2").html(response.price);
            $(".cart-add").unbind("click", false);
          } else {
            $(".cart-add").bind("click", false);
            $("#color-selector option:first").prop("selected", true);
            $("#size-selector option:first").prop("selected", true);
            variantMsgArea.html(
              '<span style="color:red;font-weight:bold">' +
                response.msg +
                "</span>"
            );
          }
        },
        error: function () {},
      });
    }
  }
});
