$(function () {
  if ($("#main-banner").length > 0) {
    $("#main-banner").bxSlider({
      mode: "fade",
      captions: false,
      adaptiveHeight: true,
      controls: false,
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
        controls: false
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
  $('#product-pagination').twbsPagination({
    totalPages: 35,
    visiblePages: 5,
    first: '',
    last: '',
    next: '<i class="fas fa-chevron-right"></i>',
    prev: '<i class="fas fa-chevron-left"></i>',
    onPageClick: function (event, page) {
        alert(page)
    }
});
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
