/**
 *
 * Copyright (c) 2007 Tom Deater (http://www.tomdeater.com)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 * 
 */
 
(function($) {
	/**
	 * attaches a character counter to each textarea element in the jQuery object
	 * usage: $("#myTextArea").charCounter(max, settings);
	 */
	
	$.fn.charCounter = function(max, settings) {
		max = max || 100;
		settings = $.extend({
			container: "<span>",
			classname: "charcounter",
			format: "(%1 characters remaining)",
			pulse: true
		}, settings);
		var p;
		
		function count(el, container) {
			el = $(el);
			if (el.val().length > max) {
			    el.val(el.val().substring(0, max));
			    if (settings.pulse && !p) {
			    	pulse(container, true);
			    };
			};
			//Regressivo
			//container.html(settings.format.replace(/%1/, (max - el.val().length)));
			
			//Progressivo
			container.html(settings.format.replace(/%1/, (el.val().length)));
		};
		
		function pulse(el, again) {
			if (p) {
				window.clearTimeout(p);
				p = null;
			};
			el.animate({ opacity: 0.1 }, 100, function() {
				$(this).animate({ opacity: 1.0 }, 100);
			});
			if (again) {
				p = window.setTimeout(function() { pulse(el) }, 200);
			};
		};
		
		return this.each(function() {
			var container = (!settings.container.match(/^<.+>$/)) 
				? $(settings.container) 
				: $(settings.container)
					.insertAfter(this)
					.addClass(settings.classname);
			$(this)
				.bind("keydown", function() { count(this, container); })
				.bind("keypress", function() { count(this, container); })
				.bind("keyup", function() { count(this, container); })
				.bind("focus", function() { count(this, container); })
				.bind("mouseover", function() { count(this, container); })
				.bind("mouseout", function() { count(this, container); })
				.bind("paste", function() { 
					var me = this;
					setTimeout(function() { count(me, container); }, 10);
				});
			if (this.addEventListener) {
				this.addEventListener('input', function() { count(this, container); }, false);
			};
			count(this, container);
		});
	};

})(jQuery);