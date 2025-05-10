$(document).ready(function () {
  
  $(".share-btn").click(function () {
    $(".shareBtnContainer").addClass("share-active");
  });
  $(".share--closeBtn").click(function (e) {
    e.stopPropagation(); // Prevents event bubbling
    $(this).parent().removeClass("share-active");
  });

  $(".copy_text").click(function (e) {
    e.preventDefault();
    currentUrlLocation = $(location).attr("href");
    document.addEventListener(
      "copy",
      function (e) {
        e.clipboardData.setData("text/plain", currentUrlLocation);
        e.preventDefault();
      },
      true
    );
    document.execCommand("copy");
  });

  function checkHover() {
    if ($(window).width() > 1200) {
      if (
        $("#cssmenu > ul > li a.active").parent().find("ul:hover").length > 0
      ) {
        $("#cssmenu > ul > li a.active").addClass("hide-before");
      } else {
        $("#cssmenu > ul > li a.active").removeClass("hide-before");
      }
    } else {
      $("#cssmenu > ul > li a.active").removeClass("hide-before");
    }
  }

  // Bind hover events
  $("#cssmenu > ul > li a.active")
    .parent()
    .find("ul")
    .hover(checkHover, checkHover);

  // Check hover state on window resize
  $(window).resize(checkHover);

  $(".first-navigation-links-container > button").click(() => {
    $(".searchBarOpen").addClass("search-active");
  });
  $(".search-btn-flying-navbar").click(() => {
    $(".searchBarOpen").addClass("search-active");
  });
  $(".searchBarOpen--closeBtn").click(() => {
    $(".searchBarOpen").removeClass("search-active");
  });

  $(".dropdown.signin-btn > .dropdown-toggle").click(function () {
    // Remove menu-opened class from #menu-button
    $("#menu-button").removeClass("menu-opened");

    // Remove open class from #cssmenu ul
    $("#cssmenu ul").removeClass("open");

    // Remove display block from #cssmenu ul
    $("#cssmenu ul").css("display", "");

    // Add your further actions here if needed
  });
  $(".dropdown.signin-btn > .dropdown-toggle").click(function () {
    // Remove menu-opened class from #menu-button
    $("#menu-button").removeClass("menu-opened");

    // Remove open class from #cssmenu ul
    $(".cssmenu2 ul").removeClass("open");

    // Remove display block from #cssmenu ul
    $(".cssmenu2 ul").css("display", "");

    // Add your further actions here if needed
  });

  $(this).find(".fa-plus").show();
  $(this).find(".fa-minus").hide();

  $("#cssmenu").menumaker({
    title: "",
    format: "multitoggle",
  });

  // Footer
  $(".toggleButton").click(function () {
    // Check if the window width is less than or equal to 991px
    if ($(window).width() <= 991) {
      // Toggle the visibility of the target element using classes
      $(this).closest("div").next("ul").toggleClass("show");
      // Toggle the icon based on the presence of the 'show' class
      if ($(this).closest(".footer-item").find("ul").hasClass("show")) {
        $(this).find(".fa-plus").hide();
        $(this).find(".fa-minus").show();
      } else {
        $(this).find(".fa-plus").show();
        $(this).find(".fa-minus").hide();
      }
    }
  });
  // Back to top
  $(".backtotop-box").click(function () {
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });
});

// Navbar
$(".nav-link").click(function () {
  $(".nav-link").removeClass("active");
  $(this).addClass("active");
});

$(".search-icon").click(function () {
  $(".nav-search").addClass("active");
  $(".navbar-search-bar-container").addClass("active");
});

$(".close-icon").click(function () {
  $(".nav-search").removeClass("active");
  $(".navbar-search-bar-container").removeClass("active");
});

$(document).ready(function(){

  $("#menu-button").click(function () {
    $(".has-sub > .submenu-button").removeClass("submenu-opened");
    $(".has-sub > ul").removeClass("open").css("display","");
  });

});

$(function (){
   $("#phone").on('keypress', function (e){
      let regex = /^[0-9.١٢٣٤٥٦٧٨٩]+$/;
     var key = e.keyCode || e.which;
     key = String.fromCharCode(key);
      if (regex.test(key))
          return;
      e.preventDefault();
   })
})

