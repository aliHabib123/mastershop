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
      //alert("plus");
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

  // //Pagination
  // $("#product-pagination").twbsPagination({
  //   totalPages: 35,
  //   visiblePages: 5,
  //   first: "",
  //   last: "",
  //   next: '<i class="fas fa-chevron-right"></i>',
  //   prev: '<i class="fas fa-chevron-left"></i>',
  //   onPageClick: function (event, page) {
  //     //alert(page);
  //   },
  // });

  // jQuery
  $("#mobile-number, #work-number").intlTelInput({
    // options here
    initialCountry: "LB",
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
    function (start, end, label) {
      console.log(start, end, label);
    }
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

// var element =  document.getElementById('elementId');
// if(typeof( document.querySelector(".custom-file-input")) != undefined){
//   document
//   .querySelector(".custom-file-input")
//   .addEventListener("change", function (e) {
//     var name = this.files[0].name;
//     var nextSibling = e.target.nextElementSibling;
//     nextSibling.innerText = name;
//   });

// }
//warehouse
$("html").on("click", ".delete-warehouse", function (e) {
  if (confirm("Are you sure?")) {
    let warehouseId = $(this).data("id");
    let contactId = $(this).data("contactId");
    let href = $(this).attr("href");
    console.log(warehouseId, contactId, href);
    // let data = { warehouseId: "warehouseId", contactId: "contactId" };
    $.ajax({
      url: href,
      type: "POST",
      dataType: "json",
      data: { warehouseId: warehouseId, contactId: contactId },
      // mimeType: "multipart/form-data",
      // contentType: false,
      // cache: false,
      // processData: true,
      beforeSend: function () {
        showMsg(".notice-area", true, "Logging you in, please wait...");
      },
      success: function (response) {
        console.log(response);
        showMsg(".notice-area", response.status, response.msg);
        if (response.status == true) {
          //alert("ok");
          console.log($(this).closest("tr"));
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

$("html").on("click", ".wishlist-add", function (e) {
  let itemId = $(this).data("itemId");
  let customerId = $(this).data("customerId");
  console.log(itemId, customerId);
  // let data = { warehouseId: "warehouseId", contactId: "contactId" };
  $.ajax({
    url: mainUrl + "add-to-wishlist",
    type: "POST",
    dataType: "json",
    data: { itemId: itemId, customerId: customerId },
    // mimeType: "multipart/form-data",
    // contentType: false,
    // cache: false,
    // processData: true,
    beforeSend: function () {
      //showMsg(".notice-area", true, "Logging you in, please wait...");
    },
    success: function (response) {
      console.log(response);
      //showMsg(".notice-area", response.status, response.msg);
      if (response.added == true) {
        //alert("ok");
        //console.log($(e.currentTarget));
        $(e.currentTarget).find("img").attr("src", "img/heart-on.png");
      } else if (response.deleted) {
        $(e.currentTarget).find("img").attr("src", "img/heart-off.png");
      }
    },
    error: function () {
      showMsg(".notice-area", false, "An error occured, please try again!");
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
