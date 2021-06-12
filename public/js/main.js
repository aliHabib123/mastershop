$(function () {
  if ($("#main-banner").length > 0) {
    $("#main-banner").bxSlider({
      mode: "fade",
      captions: false,
      adaptiveHeight: true,
      controls: false,
    });
  }
  if ($(".product-images-slider").length > 0) {
    $(".product-images-slider").bxSlider({
      minSlides: 1,
      maxSlides: 4,
      adaptiveHeight: false,
      slideWidth: "100px",
      pager: false,
      touchEnabled: false,
    });
  }
  $("#popup-image").magnificPopup({
    type: "image",
    // other options
  });
  $(".product-images-slider").on("click", ".change-main-image", function (e) {
    e.preventDefault();
    src = $(this).prop("src");
    $("#popup-image").attr("href", src);
    $("#popup-image").find("img").attr("src", src);
    $("#popup-image").magnificPopup({
      type: "image",
      // other options
    });
  });
  //.input-wrapper
  $(document).on("click", ".input-wrapper i", function (e) {
    e.preventDefault();
    str = $(this).attr("class");
    let el = $("#qty");
    if (str.includes("plus")) {
      el.val(Number(el.val()) + 1);
    } else if (str.includes("minus")) {
      if (Number(el.val()) > 1) {
        el.val(Number(el.val()) - 1);
      }
    }
  });
  $("#qty").on("input", function () {
    if ($(this).val() < 1) {
      $(this).val(1);
    }
  });

  if ($(".related-slider").length > 0) {
    let width = $(".related").width();
    let slideWidth = width / 5;
    if ($(window).width() < 768) {
      slideWidth = width / 2;
    }
    slideWidth = slideWidth + "px";
    $(".related-slider").bxSlider({
      minSlides: 1,
      maxSlides: 4,
      adaptiveHeight: true,
      slideWidth: "250px",
      pager: false,
      controls: true,
    });
  }
  if ($("#categories-slider").length) {
    reloadcategoriesSlider();
  }

  let slider;
  $("#brands-li").on("shown.bs.dropdown", function () {
    let defaultId = $("#brands-li").find("ul li").first().attr("id");
    reloadBxSlider(defaultId);
  });
  $("body .brands-categories").on("click", "li", function (e) {
    e.preventDefault();
    let id = $(this).attr("id");
    if (id && id != "") {
      $(this).addClass("active").siblings().removeClass("active");
      reloadBxSlider(id);
    }
  });

  function reloadBxSlider(id) {
    if (slider) {
      slider.destroySlider();
    }
    $(".brands-slider").css("display", "none");
    var selector = ".brands-slider#brands-slider-" + id;
    $(selector).css("display", "block");
    slider = $(selector).bxSlider({
      minSlides: 1,
      maxSlides: 6,
      adaptiveHeight: true,
      slideWidth: "200px",
      pager: false,
    });
  }

  //Home page functions
  let specialTagsSlider;
  let defaultId = $(".special-tags").find("ul li").first().attr("id");
  reloadSpecialTagsSlider(defaultId);
  $("body .special-tags").on("click", "li", function (e) {
    e.preventDefault();
    let id = $(this).attr("id");
    if (id && id != "") {
      $(this).addClass("active").siblings().removeClass("active");
      reloadSpecialTagsSlider(id);
    }
  });
  function reloadSpecialTagsSlider(id) {
    if (specialTagsSlider) {
      specialTagsSlider.destroySlider();
    }
    let width = $(".special-tags-slider-container").width();
    let slideWidth = width / 5;
    if ($(window).width() < 768) {
      slideWidth = width / 2;
    }
    slideWidth = slideWidth + "px";
    $(".special-tags-slider").css("display", "none");
    var selector = ".special-tags-slider#special-tags-slider-" + id;
    $(selector).css("display", "block");
    specialTagsSlider = $(selector).bxSlider({
      minSlides: 1,
      maxSlides: 6,
      adaptiveHeight: true,
      slideWidth: slideWidth,
      pager: true,
      controls: false,
    });
  }
  function reloadcategoriesSlider() {
    let width = $(".categories-slider-wrapper").width();
    let slideWidth = width / 5;
    let config = {
      minSlides: 1,
      maxSlides: 5,
      adaptiveHeight: true,
      slideWidth: slideWidth,
      pager: false,
      infiniteLoop: true,
    };
    if ($(window).width() < 768) {
      slideWidth = width / 2;
      //alert(slideWidth);
      config = {
        minSlides: 1,
        maxSlides: 2,
        adaptiveHeight: true,
        slideWidth: slideWidth,
        pager: true,
        controls: false,
      };
    }
    slideWidth = slideWidth + "px";
    $("#categories-slider").bxSlider(config);
  }

  var resizeTimer;

  $(window).on("resize", function (e) {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      // Run code here, resizing has "stopped"
      reloadcategoriesSlider();
    }, 250);
  });

  // jQuery
  $("#mobile-number, #work-number").intlTelInput({
    // options here
    initialCountry: userCountry,
    separateDialCode: true,
  });

  // check if element is available to bind ITS ONLY ON HOMEPAGE
  var currentDate = moment().format("DD-MM-YYYY");

  var datePicker = $(".date").daterangepicker(
    {
      locale: {
        format: "DD-MM-YYYY",
      },
      alwaysShowCalendars: true,
      autoApply: true,
      autoUpdateInput: true,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    function (start, end, label) {}
  );
});

$(function () {
  // ------------------------------------------------------- //
  // Multi Level dropdowns
  // ------------------------------------------------------ //
  $(".mobile-menu ul.dropdown-menu [data-toggle='dropdown']").on(
    "click",
    function (event) {
      event.preventDefault();
      event.stopPropagation();

      $(this).siblings().toggleClass("show");

      if (!$(this).next().hasClass("show")) {
        $(this)
          .parents(".dropdown-menu")
          .first()
          .find(".show")
          .removeClass("show");
      }
      $(this)
        .parents("li.nav-item.dropdown.show")
        .on("hidden.bs.dropdown", function (e) {
          $(".dropdown-submenu .show").removeClass("show");
        });
    }
  );
});

//Import
$(function () {
  $("#import-form").submit(function (e) {
    var formData = new FormData(this);
    var formUrl = $(this).attr("action");
    $.ajax({
      url: formUrl,
      type: "POST",
      dataType: "json",
      data: formData,
      mimeType: "multipart/form-data",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        showMsg(
          ".notice-area",
          true,
          "Importing your file, please dont click anywhere..."
        );
      },
      success: function (response) {
        showMsg(".notice-area", response.status, response.msg);
        if (response.status == true) {
          //location.href = response.redirectUrl;
        }
      },
      error: function () {
        showMsg(".notice-area", false, "An error occured, please try again!");
      },
    });
    e.preventDefault();
  });
});

function showMsg(selector, status, msg) {
  let html = `<div class="${status ? "success" : "error"}">${msg}</div>`;
  $(selector).html(html);
}

//warehouse
$("html").on("click", ".delete-warehouse", function (e) {
  if (confirm("Are you sure?")) {
    let warehouseId = $(this).data("id");
    let contactId = $(this).data("contactId");
    let href = $(this).attr("href");
    $.ajax({
      url: href,
      type: "POST",
      dataType: "json",
      data: { warehouseId: warehouseId, contactId: contactId },
      beforeSend: function () {
        showMsg(".notice-area", true, "Logging you in, please wait...");
      },
      success: function (response) {
        showMsg(".notice-area", response.status, response.msg);
        if (response.status == true) {
          $("#warehouse-tbody")
            .find("tr#" + warehouseId)
            .remove();
        }
      },
      error: function () {
        showMsg(".notice-area", false, "An error occured, please try again!");
      },
    });
    e.preventDefault();
  }
});
//edit-warehouse
$("html").on("click", ".edit-warehouse", function (e) {
  e.preventDefault();
  $("#edit-warehouse-modal").modal("show");
  var warehouseId = $(this).data("warehouseId");
  var contactId = $(this).data("contactId");
  var warehouseName = $(this).data("title");
  var email = $(this).data("email");
  var mobile = $(this).data("mobile");
  var lastName = $(this).data("lastName");
  var firstName = $(this).data("firstName");

  $("#edit-warehouse-modal #warehouse-id").val(warehouseId);
  $("#edit-warehouse-modal #contact-id").val(contactId);
  $("#edit-warehouse-modal #warehouse-name").val(warehouseName);
  $("#edit-warehouse-modal #email").val(email);
  $("#edit-warehouse-modal #mobile-number").val(mobile);
  $("#edit-warehouse-modal #first-name").val(firstName);
  $("#edit-warehouse-modal #last-name").val(lastName);
});

//sidebar-brand-menu
$(".sidebar-brand-menu").on("click", "span", function (e) {
  e.preventDefault();
  $(e.currentTarget).siblings().css("border-color", "#b7b7b7");
  $(e.currentTarget).css("border-color", "red");
  $("#brand_id").val($(e.currentTarget).attr("id"));
});

if ($(".sidebar-brand-menu").length > 0) {
  if ($("#brand_id").val() != "") {
    $(".sidebar-brand-menu")
      .find("span#" + $("#brand_id").val())
      .css("border-color", "red");
  }
}
$("#sidebar-filter").on("reset", function (e) {
  e.preventDefault();
  location.href = currentPageUrl;
});
$("html").on("click", ".wishlist-add", function (e) {
  alertify.set("notifier", "position", "top-right");
  if (isLoggedIn == "" || userType != 3) {
    alertify.error("Please Login.");
    return false;
  }
  let itemId = $(this).data("itemId");
  let customerId = $(this).data("customerId");
  $.ajax({
    url: mainUrl + "add-to-wishlist",
    type: "POST",
    dataType: "json",
    data: { itemId: itemId, customerId: customerId },
    beforeSend: function () {},
    success: function (response) {
      if (response.added == true) {
        alertify.success("Added to wishlist.");
        $(e.currentTarget).find("img").attr("src", "img/heart-on.png");
      } else if (response.deleted) {
        alertify.success("Deleted from wishlist.");
        if ($(e.currentTarget).hasClass("remove-item")) {
          $(e.currentTarget).parent().remove().fadeOut(500);
        } else {
          $(e.currentTarget).find("img").attr("src", "img/heart-off.png");
        }
      }
      let wishlistBadge = $("li.wishlist").find("span.badge");
      wishlistBadge.html(response.count);
      if (response.count == 0) {
        wishlistBadge.hide();
      } else {
        wishlistBadge.show();
      }
    },
    error: function () {
      showMsg(".notice-area", false, "An error occured, please try again!");
    },
  });
  e.preventDefault();
});

$("html").on("click", ".cart-add", function (e) {
  alertify.set("notifier", "position", "top-right");
  if (isLoggedIn == "" || userType != 3) {
    alertify.error("Please Login.");
    return false;
  }
  let itemId = $(this).data("itemId");
  $.ajax({
    url: mainUrl + "add-to-cart",
    type: "POST",
    dataType: "json",
    data: { itemId: itemId },
    beforeSend: function () {},
    success: function (response) {
      if (response.status == true) {
        alertify.success("Added to cart.");
      }
    },
    error: function () {
      showMsg(".notice-area", false, "An error occured, please try again!");
    },
  });
  e.preventDefault();
});
$("html").on("click", ".cart-delete", function (e) {
  let itemId = $(this).data("itemId");
  $.ajax({
    url: mainUrl + "delete-from-cart",
    type: "POST",
    dataType: "json",
    data: { itemId: itemId },
    beforeSend: function () {
      $("#checkout-btn").addClass("disabled");
    },
    success: function (response) {
      if (response.status == true) {
        $(e.target).closest("tr").remove().fadeOut(1000);
        $("#cart-total").html(response.total);
        if (!response.haveItems) {
          location.href = mainUrl + "my-cart";
        }
      }
      $("#checkout-btn").removeClass("disabled");
    },
    error: function () {
      $("#checkout-btn").removeClass("disabled");
    },
  });
  e.preventDefault();
});
$("html").on("click", ".cart-update", function (e) {
  let itemId = $(this).data("itemId");
  let cartQty = $(this).closest("tr").find("input").val();
  $.ajax({
    url: mainUrl + "update-cart",
    type: "POST",
    dataType: "json",
    data: { itemId: itemId, cartQty: cartQty },
    beforeSend: function () {
      $("#checkout-btn").addClass("disabled");
    },
    success: function (response) {
      if (response.status == true) {
        //item-subtotal
        $("#cart-item-" + itemId)
          .find(".item-subtotal")
          .html(response.subtotal);

        $("#cart-total").html(response.total);
      }
      $("#cart-item-" + itemId)
        .find("input")
        .val(response.qty);
      $("#checkout-btn").removeClass("disabled");
    },
    error: function () {
      $("#checkout-btn").removeClass("disabled");
    },
  });
  e.preventDefault();
});
$("#search-categories.dropdown-menu a").click(function (e) {
  e.preventDefault();
  let selText = $(this).text();
  let selId = $(this).data("id");
  $(this)
    .parent()
    .parent()
    .find(".dropdown-toggle")
    .html(selText + ' <span class="caret"></span>');
  $("#selected-category").val(selId);
  let href = mainUrl + "products/";
  if (selId != 0) {
    href += $(this).data("slug");
  }
  $(this).closest("form").attr("action", href);
});

$("#update-user").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      showMsg(".notice-area", true, "Updating user info...");
    },
    success: function (response) {
      showMsg(".notice-area", response.status, response.msg);
      $("html, body").animate(
        { scrollTop: $(".notice-area").offset().top - 100 },
        1000
      );
      if (response.status == true) {
        //location.href = response.redirectUrl;
      }
    },
    error: function () {
      showMsg(".notice-area", false, "An error occured, please try again!");
    },
  });
  e.preventDefault();
});

//vendor-contact-update
$("#vendor-contact-update").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      showMsg(
        ".vendor-page-wrapper .notice-area",
        true,
        "Updating contact info..."
      );
    },
    success: function (response) {
      showMsg(
        ".vendor-page-wrapper .notice-area",
        response.status,
        response.msg
      );
      $("html, body").animate(
        {
          scrollTop: $(".vendor-page-wrapper .notice-area").offset().top - 100,
        },
        1000
      );
      if (response.status == true) {
        //location.href = response.redirectUrl;
      }
    },
    error: function () {
      showMsg(
        ".vendor-page-wrapper .notice-area",
        false,
        "An error occured, please try again!"
      );
    },
  });
  e.preventDefault();
});

//order-complete
$("#order-complete").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      $(".complete-btn").addClass("disabled");
      showMsg(".notice-area", true, "sending Order ...");
    },
    success: function (response) {
      showMsg(".notice-area", response.status, response.msg);
      $("html, body").animate(
        { scrollTop: $(".notice-area").offset().top - 100 },
        500
      );
      // if (response.status == true) {
      //   location.href = response.redirectUrl;
      // } else{
      // }
      $(".complete-btn").removeClass("disabled");
      location.href = response.redirectUrl;
    },
    error: function () {
      $(".complete-btn").removeClass("disabled");
      showMsg(".notice-area", false, "An error occured, please try again!");
    },
  });
  e.preventDefault();
});

$("#contact-submit").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      showMsg(".notice-area", true, "sending Your Message ...");
    },
    success: function (response) {
      showMsg(".notice-area", response.status, response.msg);
      $("html, body").animate(
        { scrollTop: $(".notice-area").offset().top - 100 },
        500
      );
      if (response.status == true) {
        $("#contact-submit")[0].reset();
      }
    },
    error: function () {
      showMsg(".notice-area", false, "An error occured, please try again!");
    },
  });
  e.preventDefault();
});

$("#vendor-login-form").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      showMsg(
        ".vendor-login-wrap .notice-area",
        true,
        "Logging you in, please wait..."
      );
    },
    success: function (response) {
      showMsg(".vendor-login-wrap .notice-area", response.status, response.msg);
      if (response.status == true) {
        location.href = response.redirectUrl;
      }
    },
    error: function () {
      showMsg(
        ".vendor-login-wrap .notice-area",
        false,
        "An error occured, please try again!"
      );
    },
  });
  e.preventDefault();
});

//forgot-form
$("#forgot-form").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      showMsg(
        ".forgot-password .notice-area",
        true,
        "Sending email, please wait..."
      );
    },
    success: function (response) {
      showMsg(".forgot-password .notice-area", response.status, response.msg);
    },
    error: function () {
      showMsg(
        ".forgot-password .notice-area",
        false,
        "An error occured, please try again!"
      );
    },
  });
  e.preventDefault();
});

//reset-form
$("#reset-form").submit(function (e) {
  var formData = new FormData(this);
  var formUrl = $(this).attr("action");
  $.ajax({
    url: formUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      showMsg(".reset-password .notice-area", true, "Updating, please wait...");
    },
    success: function (response) {
      showMsg(".reset-password .notice-area", response.status, response.msg);
      if (response.status) {
        let redirectUrl =
          userType == 3
            ? mainUrl + "my-profile"
            : mainUrl + "vendor/my-dashboard";
        $("#reset-form")[0].reset();
        location.href = redirectUrl;
      }
    },
    error: function () {
      showMsg(
        ".reset-password .notice-area",
        false,
        "An error occured, please try again!"
      );
    },
  });
  e.preventDefault();
});
