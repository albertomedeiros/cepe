/*
 * bootmenu v0.1.3
 * A simple and easy jQuery plugin for Bootstrap select menu.
 * Author : Mario Medhat
 */
(function($) {
    $.fn.bootmenu = function(options, callback) {

        var settings = $.extend({
            // These are the defaults.
            items: ["Please add items to the dropdown!"],
            defaultText: "Select here!",
            listName: "listOne",
            color: "white",
            background: "#3498DB",
            hoverColor: "#2C3E50",
            listAnimation: "slideDown",
            animationDuration: 500,
            callback: function() {}
        }, options);

        var dropDown = "<div list=\"" + settings.listName + "\" class=\"input-group\">";
        dropDown += "<input list=\"" + settings.listName + "\" id=\"bootmenu\" class=\"form-control\" type=\"text\" placeholder=\"" + settings.defaultText + "\" title=\"" + settings.defaultText + "\">";
        dropDown += "<span class=\"input-group-addon\" style=\"cursor: pointer\"><i class=\"glyphicon glyphicon-chevron-down\"></i></span></div>";
        dropDown += "<ul class=\"nav nav-pills nav-stacked\" style=\"display:none;cursor:pointer\" id=\"" + settings.listName + "\">";

        // Add list items
        for (i = 0, j = settings.items.length; i < j; i++)
            dropDown += "<a class=\"list-group-item\" currentValue=\"" + settings.items[i] + "\">" + settings.items[i] + "</a>";

        dropDown += "</ul>";

        // Add the drop down to the element
        this.html(dropDown);

        // Style the dropdown menu
        $("#" + settings.listName + " a").css({
                color: settings.color,
                background: settings.background
            })
            .hover(function() {
                $(this).css({
                    background: settings.hoverColor
                })
            }, function() {
                $(this).css({
                    color: settings.color,
                    background: settings.background
                });
            });

        // All animations
        var angle = 0;
        var animateIt = $.fn.animateIt = function(type, angle, direction) {
            switch (type) {
                case "rotation":
                    $(this).css({
                        '-webkit-transform': 'rotate(' + angle + 'deg)',
                        '-moz-transform': 'rotate(' + angle + 'deg)',
                        '-o-transform': 'rotate(' + angle + 'deg)',
                        '-ms-transform': 'rotate(' + angle + 'deg)',
                        'transform': 'rotate(' + angle + 'deg)',
                        'transition': 'transform 700ms'
                    });
                    break;
                case "submit":
                    $(this).css({
                        'background': '#BF2953'
                    });
                    break;
                case "slideDown":
                    direction === "in" ? $(this).slideDown() : $(this).slideUp();
                    break;
                case "fade":
                    direction === "in" ? $(this).fadeIn() : $(this).fadeOut();
                    break;
                case "slideLeft":
                    if (direction == "in")
                        $(this).css({
                            '-webkit-transform': 'translateX(-100px)',
                            '-moz-transform': 'translateX(-100px)',
                            '-o-transform': 'translateX(-100px)',
                            '-ms-transform': 'translateX(-100px)',
                            'transform': 'translateX(-100px)'
                        }).fadeIn().css({
                            '-webkit-transform': 'translateX(0px)',
                            '-moz-transf/*orm': 'translateX(0px)',
                            '-o-transform': 'translateX(0px)',
                            '-ms-transform': 'translateX(0px)',
                            'transform': 'translateX(0px)',
                            'transition': 'transform ' + settings.animationDuration + 'ms'
                        });
                    else
                        $(this).css({
                            '-webkit-transform': 'translateX(100px)',
                            '-moz-transform': 'translateX(100px)',
                            '-o-transform': 'translateX(100px)',
                            '-ms-transform': 'translateX(100px)',
                            'transform': 'translateX(100px)',
                            'transition': 'transform ' + settings.animationDuration + 'ms',
                        }).fadeOut();
                    break;
                case "rotate":
                    if (direction === 'in')
                        $(this).css({
                            '-webkit-transform': 'rotate(180deg)',
                            '-moz-transform': 'rotate(180deg)',
                            '-o-transform': 'rotate(180deg)',
                            '-ms-transform': 'rotate(180deg)',
                            'transform': 'rotate(180deg)'
                        }).fadeIn().css({
                            '-webkit-transform': 'rotate(360deg)',
                            '-moz-transform': 'rotate(360deg)',
                            '-o-transform': 'rotate(360deg)',
                            '-ms-transform': 'rotate(360deg)',
                            'transform': 'rotate(360deg)',
                            'transition': 'transform ' + settings.animationDuration + 'ms'
                        });
                    else
                        $(this).css({
                            '-webkit-transform': 'rotate(180deg)',
                            '-moz-transform': 'rotate(180deg)',
                            '-o-transform': 'rotate(180deg)',
                            '-ms-transform': 'rotate(180deg)',
                            'transform': 'rotate(180deg)',
                            'transition': 'transform ' + settings.animationDuration + 'ms'
                        }).fadeOut();
                    break;
                case "fly":
                    if (direction === 'in')
                        $(this).css({
                            '-webkit-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            '-moz-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            '-o-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            '-ms-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            'transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                        }).fadeIn().css({
                            '-webkit-transform': 'rotate(0deg) translateY(0px)',
                            '-moz-transform': 'rotate(0deg) translateY(0px)',
                            '-o-transform': 'rotate(0deg) translateY(0px)',
                            '-ms-transform': 'rotate(0deg) translateY(0px)',
                            'transform': 'rotate(0deg) translateY(0px)',
                            'transition': 'transform ' + settings.animationDuration + 'ms'
                        });
                    else
                        $(this).css({
                            '-webkit-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            '-moz-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            '-o-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            '-ms-transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            'transform': 'rotate(90deg) translateY(-' + $(this).height() + 'px)',
                            'transition': 'transform ' + settings.animationDuration + 'ms'
                        }).fadeOut("slow");
                    break;
            }
        }


        $("div[list=" + settings.listName + "] span").mouseenter(function() {
            $(this).animateIt("hoverIn");
        }).mouseleave(function() {
            $(this).animateIt("hoverOut");
        });

        // Slide dropdown menu on click and slide up on clicking anywhere  or input field twice
        $(document).mouseup(function(e) {

            var list = $("div[list=" + settings.listName + "]");
            // if the target of the click isn't the list, nor a descendant of the list or the user clicks twice, hide the list & rotate the button
            if (!list.is(e.target) && list.has(e.target).length === 0 || angle === 180) {
                angle = 0;
                $("div[list=" + settings.listName + "] span i").animateIt("rotation", angle);
                $("#" + settings.listName).animateIt(settings.listAnimation, "0", "out");
            } else { // Show the menu when the user clicks the input field or the button
                angle = 180;
                $("div[list=" + settings.listName + "] span i").animateIt("rotation", angle);
                $("#" + settings.listName).animateIt(settings.listAnimation, "180", "in");
            }
        });

        // When user press a list item
        var select = $('ul#' + settings.listName + ' a').on("click", function() {
            var value = $(this).attr('currentValue'),
                angle = 0;
            $(this).animateIt("submit");
            $("div[list=" + settings.listName + "] span i").animateIt("rotation", angle);
            $("input[list=" + settings.listName + "]").val(value);
            $("#" + settings.listName).animateIt(settings.listAnimation, "0", "out");

            // make sure the callback is a function
            if (typeof settings.callback == 'function')
                settings.callback.apply(this, [value]); // callback the requested function and return the encrypted value
        });

        // When user searches for an item
        $("input[list=" + settings.listName + "]").on('keyup', function() {
            angle = 180;
            $("div[list=" + settings.listName + "] span i").animateIt("rotation", angle);
            $("#" + settings.listName).animateIt(settings.listAnimation, "180", "in");
            var string = $(this).val().toLowerCase();
            $("ul#" + settings.listName + ' a').each(function() {
                if ($(this).text().toLowerCase().search(string) > -1)
                    $(this).fadeIn('fast');
                else
                    $(this).slideUp('fast');
            });
        });
    }
})(jQuery);
