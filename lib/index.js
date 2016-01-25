$(window).scroll(function (e) {
    var $w = $(window).width();
    var $h = $(window).height();
    if ($w > 980 && $h > 400) {
        if ($(this).scrollTop() >= 268) {
            $("#index_nav.index_nav, #compatible").addClass("index_nav_fixed");
        } else {
            $("#index_nav.index_nav, #compatible").removeClass("index_nav_fixed");
        }
        $("#slides").css("height", 300 - ($(this).scrollTop()) + "px");
        $("#slides img").css("opacity", (((250 - ($(this).scrollTop())) * 100) / 250) / 100);
        $(".si-ctitle-c").css("opacity", (((250 - ($(this).scrollTop())) * 100) / 250) / 100);
    }
});


