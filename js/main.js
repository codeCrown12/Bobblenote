$(document).ready(function() {
    "use strict";

     var list = document.getElementsByClassName('data-bg-image');

    for(var i =0; i< list.length; i++){
        var bgimg = list[i].getAttribute('data-bg-image');
        list[i].style.backgroundImage = "url('" + bgimg + "')";
    }
    
    var $header = $(".header-default"),
    $clone = $header.before($header.clone().addClass("clone"));
    $(window).on("scroll", function(){
        var fromTop = $(window).scrollTop();
        $('body').toggleClass("down", (fromTop > 300));
    });
});

$(function(){
    "use strict";

    $('.sidebar').stickySidebar({
        topSpacing : 60,
        bottomSpacing : 30,
        containerSelector : '.main-content',
    });
    $(".submenu").before('<i class="icon-arrow-down switch"></i>');
    $(".vertical-menu li i.switch").on('click', function() {
    var $submenu = $(this).next(".submenu");
    $submenu.slideToggle(300);
    $submenu.parent().toggleClass("openmenu");
});

    $("button.burger-menu").on('click', function(){
        $(".canvas-menu").toggleClass("open");
        $(".main-overlay").toggleClass("active");
    });

    $(".canvas-menu .btn-close, .main-overlay").on('click', function() {
        $(".canvas-menu").removeClass("open");
        $(".main-overlay").removeClass("active");
    });

    $("button.search").on('click',function(){
        $(".search-popup").addClass("visible");
    });

    $(".search-popup .btn-close").on('click', function(){
        $(".search-popup").removeClass("visible");
    });

    $(document).keyup(function(e){
        if(e.key ===  "Escape"){
            $(".search-popup").removeClass("visible");
        }
    });

});