$(function(){
    $("#q").on("input", function(e){
        var q = e.target.value;
        $("#predict").load("/include/search.php", {
            "q": q
        });
    });
});
jQuery.ajaxSetup({
    beforeSend: function () {
        $("#loading").hide();
        $("#ls").show();
    },
    complete: function () {
        $("#ls").hide();
        $("#loading").hide();
    },
    error: function (xhr) {
        $("#loading, #loading2").hide();
        alert("Impossible de charger le module.\n Erreur " + xhr.status + ".");
    }
});


