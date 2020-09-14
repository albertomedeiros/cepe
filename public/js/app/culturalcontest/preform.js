$(function () {
    "use strict";

    $("[data-nav_step]").click(function (e) {
        e.preventDefault();
        var step = $(this).data("nav_step");

        $("[data-step]").hide();
        $("[data-step= ]").hide();
    });

});