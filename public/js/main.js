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
      alert(slideWidth);
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

  //Pagination
  $("#product-pagination").twbsPagination({
    totalPages: 35,
    visiblePages: 5,
    first: "",
    last: "",
    next: '<i class="fas fa-chevron-right"></i>',
    prev: '<i class="fas fa-chevron-left"></i>',
    onPageClick: function (event, page) {
      //alert(page);
    },
  });

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


//Register/Login
$(function () {

});

function showMsg(selector, status, msg) {
  let html = `<div class="${status ? 'success' : 'error'}">${msg}</div>`;
  $(selector).html(html);
}