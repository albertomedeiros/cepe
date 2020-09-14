$(function () {
    "use strict";
    $("[name=terms_agreed]").on("change", function(e){
        if ($(this).is(":checked")) {
            $("button").removeAttr("disabled");
        } else {
            $("button").attr("disabled", "disabled");
        }
    });

})