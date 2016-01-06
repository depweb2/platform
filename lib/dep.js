function init() {
    var m = Modernizr;
    var compatible = true;
    try {
        compatible = m.target && m.canvas && m.rgba && m.csscalc && m.opacity && m.displaytable && m.cssanimations && m.boxsizing;
    } catch (e) {
        compatible = false;
    }
    if (!compatible) {
        $("#compatible").hide().remove();
        $("#notcompatible").show();
        alert("Impossible de charger le module com.cfnt.si.depweb.init. Navigateur non compatible.\n" +
                "Vous devez utiliser un navigateur Web respectant les normes HTML5, CSS2.1 et CSS3 pour utiliser dep.web 2.0.");
        throw new Error("Browser not compatible, loading has been aborted. Please use an HTML5/CSS3 compilant browser or disable compatibility mode if you are using IE.");
        window.stop() || document.execCommand("Stop");
    } else {
        $("*[title]").addClass("tooltip");
        $(".tooltip").tooltipster({
            theme: "tooltipster-light",
            contentAsHTML: true
        });
        $("#time").html(formatAMPM());
        setInterval(function () {
            $("#time").html(formatAMPM());
        }, 1000);
        $(document).on("contextmenu", function (e) {
            if (!$(e.target).is(".w3-context, img, canvas, video, audio, object, applet")) {
                e.preventDefault();
                e.stopPropagation();
                e.cancelBubble = true;
                e.returnValue = false;
                return false;
            }
        });
        $("a").hammer().on("press contextmenu", function (e) {
            var link = $(this).attr("href");
            if (!$(e.target).is(".w3-context a") && !link.match("\#|javascript")) {
                $(".link-open").attr("href", link);
                $(".link-open-source").attr("onclick", "show_source('" + link + "')");
                $(".link-open-window").attr("onclick", "window.open('" + link + "', '_blank', 'menubar=yes,toolbar=yes,height=768,width=1024,modal=yes,alwaysRaised=yes');");
                if (e.type && e.type == "contextmenu") {
                    return link_context($(".link-context"), e);
                } else {
                    return link_context_touch($(".link-context"), e);
                }
                
            } else if ($(e.target).is(".w3-context a")){
                e.stopImPropagation();
            }else{
                e.preventDefault();
                e.stopPropagation();
                e.cancelBubble = true;
                e.returnValue = false;
                return false;
            }
        });
        $("img").on("contextmenu", function(e){
            if (!$(e.target).is(".w3-context a, .w3-btn-floating-large img")) {
                var link = $(this).attr("src");
                $(".image-open").attr("href", link);
                return link_context($(".image-context"), e);
            } else {
                e.stopPropagation();
            }
        });
        var navi = 0;
        $(".nav a").each(function(e){       
           if(!location.href.match("cours\.php")){
               if(location.href.match($(this).attr("href"))){
               navi++;
               if(!$(this).hasClass("nav-home") && navi > 1) {
                    $(this).addClass("nav-selected");
                    $(".nav-home").removeClass("nav-selected");
                } else{
                    $(".nav-home").addClass("nav-selected");
                }
            }
            }else{
                $(".nav-courses").addClass("nav-selected");
            }
        });
        $(document).on("keydown", function (e) {
            if (!$("input, text, textarea").is(":focus")) {
                switch (e.which || e.keyCode) {
                    case 72:
                    case 48:
                        location.hash = "#hotkeys";
                        break;
                    case 77:
                    case 49:
                        w3_toggle();
                        location.hash = "#";
                        break;
                    case 80:
                    case 50:
                        location.hash = "#teachers";
                        break;
                    case 57:
                    case 73:
                        location.hash = "#about";
                        break;
                }
            }
        });
    }
}
$(function () {
    init();
});
jQuery.ajaxSetup({
    beforeSend: function () {
        $("#loading").show();
    },
    complete: function () {
        $("#loading").hide();
    },
    error: function (xhr) {
        $("#loading, #loading2").hide();
        alert("Impossible de charger le module.\n Erreur " + xhr.status + ".");
    }
});
$(window).load(function () {
    $("#loading, #loading2").hide();
});
var lic_loaded = false;
function teacher(id) {
    try {
        $("#tol").load("/include/tollist.php?t=" + id + "");
    } catch (e) {
        alert("Erreur lors de l'exécution du module com.cfnt.si.depweb.teacherInfo. Erreur inconnue.");
    }
}
function showCredits() {
    if (!lic_loaded) {
        try {
            $("#licences").load("./include/licences.html", function (response, status, xhr) {
                if (xhr.status === 200 | xhr.status === 201) {
                    lic_loaded = true;
                }
            });
        } catch (e) {
            alert("Impossible de charger le module free.depweb.licences. Erreur inconnue.");
        }
    }
    $("#licences").toggle(0, function () {
        setTimeout(function () {
            $("#credits").animate({
                scrollTop: 190
            }, 200);
            $(".lic-open, .lic-close").toggle();
        }, 400);
    });
}
function cresize() {
    $("#cfnt").toggleClass("fs");
}
var home = false;
function w3_home() {
    if (home) {
        $("body").animate({
            scrollTop: 0
        }, 200);
        home = false;

    } else {
        $("body").animate({
            scrollTop: 295
        }, 200);
        home = true;
        ;
    }
}
function w3_toggle() {
    $("#compatible, #slides, .ctitle.fixed, .w3-sidenav, #topbar, body, #dropmore.dropnav, .nav-more, #index_nav").toggleClass("sideopen");
    setTimeout(function () {
        $(".sideclose").fadeToggle(200);
        $(".crp").fadeToggle(200);
        $(".classes-container").scrollTop(0);
    }, 200);
    $(".sidebar-block").fadeToggle(200);
    /*switch(location.hash){
     case "#sidebar":
     case "#dropmore":
     location.hash = "#";
     break;
     case "#":
     case "":
     location.hash = "#sidebar";
     break;
     }*/
}
function w3_open() {
    w3_toggle();
}
function w3_close() {
    w3_toggle();
}
function w3_crop() {
    $("#compatible, #slides, .ctitle.fixed, #topbar, #index_nav").toggleClass("crop");
}
$(window).scroll(function (e) {
    if (!$(this).scrollTop()) {
        $(".top").fadeOut(200);
        $(".home").fadeIn(200);
        $("#main").removeClass("scroll");
    } else {
        $(".top").fadeIn(200);
        $(".home").fadeOut(200);
        $("#main").addClass("scroll");
    }
});
function gototop() {
    $("html, body").stop().animate({
        scrollTop: 0
    }, 200, function () {
        $(".top").fadeOut(200);
    });
}
// ce bout de code permet que lorsque ;a souris clique à l'extérieur d'une boîte de dialogue
// celle-ci se dissipe.
/*$(document).on("click touchend",function(e){
 if($(e.target).closest(".w3-modal-content").length === 0 && $(".w3-modal").is(":visible")){
 location.hash = "#";
 }else{
 e.stopPropagation();
 }
 });*/
$(document).on("click touchend contextmenu", function (e) {
    if ($(e.target).closest(".dropnav, .title, .nav-more, .more, #dropmore, #dropmore2, .w3-modal").length == 0) {
        if ($(".nav-more, #dropmore").is(":visible")) {
            if (location.hash == "#dropmore") {
                location.hash = "";
            }
        }
        if ($("#dropmore2").is(":visible")) {
            $("#dropmore2").slideUp(200);
        }
    } else {
        e.stopPropagation();
    }
    if ($(e.target).closest(".sidebar-block").length !== 0) {
        w3_toggle();
    }
    if ($(e.target).closest(".w3-context-open").length === 0 && $(".w3-context").is(":visible")) {
        if($(window).width() < 601){
            $(".w3-context").removeClass("mobile").slideUp(150);
        }else{
            $(".w3-context").removeClass("mobile").fadeOut(150);
        }
        $(".blockUI").hide();
    }
});
function w3_more_menu() {
    if ($("#dropmore").is(":visible")) {
        location.hash = "";
    } else {
        location.hash = "#dropmore";
    }
}
function w3_menu_toggle_shortcut() {
    if ($("#dropmore2.dropnav").is(":visible")) {
        $("#dropmore2").slideUp(200);
    } else {
        $("#dropmore2").slideDown(200);
    }
}
function search_focus() {
    document.getElementById("q2").focus();
}
function formatAMPM() {
    var d = new Date(),
            minutes = d.getMinutes().toString().length == 1 ? '0' + d.getMinutes() : d.getMinutes(),
            hours = d.getHours().toString().length == 1 ? '0' + d.getHours() : d.getHours(),
            seconds = d.getSeconds().toString().length == 1 ? '0' + d.getSeconds() : d.getSeconds(),
            months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aoùt', 'septembre', 'octobre', 'novembre', 'décembre'],
            days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    day = d.getDate() == 1 ? "1<sup>er</sup>" : d.getDate();
    return "<b>" + days[d.getDay()] + ' ' + day + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + '</b><br>' + hours + ':' + minutes + ':' + seconds;
    // this line is used to verify if enough space for the date string
    //return "<b>Vendredi 28 septembre 2020</b><br>12:00:00";
}
function show_source(link) {
    $.ajax({
        method: "GET",
        url: link,
        dataType: "html",
        success: function (data) {
            var source = data;
            //now we need to escape the html special chars, javascript has escape
            //but this does not do what we want
            source = source.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            //now we add <pre> tags to preserve whitespace
            source = "<!DOCTYPE html>" +
                    "<html><head>" +
                    "<meta name='viewport' content='width=device-width, initial-scale=1.0'/>"+
                    "<link rel='stylesheet' href='/css/include/default.css'>" +
                    "<link rel='stylesheet' href='/css/w3.css'>" +
                    "<link rel='stylesheet' href='/css/main.css'>" +
                    "<style>html, body{max-height: 99999px;-webkit-text-size-adjust: 100%;-moz-text-size-adjust: 100%;-ms-text-size-adjust:100%;margin: 0 !important;; padding: 0 !important;}pre{font-family: monospace;line-height:1;white-space: -moz-pre-wrap;white-space: -o-pre-wrap;white-space: pre-wrap; word-wrap: break-word;}</style>" +
                    "<script src='/lib/include/highlight.pack.js'></script>" +
                    "<script>hljs.initHighlightingOnLoad();</script>" +
                    "</head>" +
                    "<body><div class='w3-modal fs' style='display: table !important;'><div class='w3-modal-dialog'><div class='w3-modal-content'><header class='w3-container w3-green'><h2><a class='nou arrow-link' href='javascript:window.close()'>" +
                    "<img class='icon30' src='/images/ic_close_white_18dp.png' alt=''/>Code source de la page" +
                    "</a></h2></header>" +
                    "<div class='w3-modal-main-container'>" +
                    "<pre id='code'><code class='html'>" + source + "</code></pre>" +
                    "</div></div></div></div>" +
                    "</body></html>";
            //now open the window and set the source as the content
            var sourceWindow = window.open('', 'Code source de ' + link + '', 'height=600,width=800,scrollbars=1,resizable=1');
            if (!sourceWindow || sourceWindow.closed || typeof sourceWindow.closed == 'undefined') {
                alert("Impossible de charger le module com.cfnt.si.depweb.sourcePageViewer. Accès refusé.\nVeuillez autoriser l'affichage de fenêtres publicitaires interprestives (popups) pour dep.web\nafin d'utiliser le lecteur de code source.");
            } else {
                sourceWindow.document.write(source);
                sourceWindow.document.close(); //close the document for writing, not the window
                //give source window focus
                if (window.focus) {
                    sourceWindow.focus();
                }

            }
        },
        error: function () {
            window.open("view-source:" + link + "", "_blank");
        }});
}
function link_context(menu, e) {
    var ww = $(window).width();
    var wh = $(window).height();
    var mh = $(menu).height();
    var mw = $(menu).width();
    if ((mh + 30) < wh && ww > 600) {
        e.preventDefault();
        e.stopPropagation();
        e.cancelBubble = true;
        e.returnValue = false;
        setTimeout(function () {
            var pageX = e.clientX;
            var pageY = e.clientY;
            $(menu).css("position", "fixed");
            if ((ww - pageX) < mw) {
                $(menu).css({
                    right: (ww - pageX),
                    left: "auto"
                });
            } else {
                $(menu).css({
                    right: "auto",
                    left: pageX
                });
            }
            if (wh - pageY < mh) {
                $(menu).css({
                    top: "auto",
                    bottom: (wh - pageY)
                });
            } else {
                $(menu).css({
                    top: pageY,
                    bottom: "auto"
                });
            }
            $(menu).fadeIn(150);
        }, 151);
        return false;
    }else if((mh) < wh && ww < 601){
        link_context_touch(menu, e);
        return false;
    }else{
        e.preventDefault();
        e.stopPropagation();
        e.cancelBubble = true;
        e.returnValue = false;
        return false;
    }
}
function link_context_touch(menu, e) {
    var ww = $(window).width();
    var wh = $(window).height();
    var mh = $(menu).height();
    if (mh < wh && ww < 601) {
        e.preventDefault();
        e.stopPropagation();
        e.cancelBubble = true;
        e.returnValue = false;
        $(".blockUI").show();
        setTimeout(function () {
            $(menu).css({
                position: "fixed",
                left: 0,
                right: 0,
                top: "auto",
                bottom: 0
            }).addClass("mobile").slideDown(150);
        }, 151);
        return false;
    } else {
        e.preventDefault();
        e.stopPropagation();
        e.cancelBubble = true;
        e.returnValue = false;
        return false;
    }
}
function open_context(node) {
    $(node).fadeIn(150);
}