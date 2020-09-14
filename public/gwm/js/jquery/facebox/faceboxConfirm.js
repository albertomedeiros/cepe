/*
 * faceboxConfirm (for jQuery)
 * version: 1.1 (03/01/2008)
 * @requires jQuery v1.2 or later
 *
 * Examples at http://famspam.com/faceboxConfirm/
 *
 * Licensed under the MIT:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2007, 2008 Chris Wanstrath [ chris@ozmm.org ]
 *
 * Usage:
 *  
 *  jQuery(document).ready(function() {
 *    jQuery('a[rel*=faceboxConfirm]').faceboxConfirm() 
 *  })
 *
 *  <a href="#terms" rel="faceboxConfirm">Terms</a>
 *    Loads the #terms div in the box
 *
 *  <a href="terms.html" rel="faceboxConfirm">Terms</a>
 *    Loads the terms.html page in the box
 *
 *  <a href="terms.png" rel="faceboxConfirm">Terms</a>
 *    Loads the terms.png image in the box
 *
 *
 *  You can also use it programmatically:
 * 
 *    jQuery.faceboxConfirm('some html')
 *
 *  This will open a faceboxConfirm with "some html" as the content.
 *    
 *    jQuery.faceboxConfirm(function() { ajaxes })
 *
 *  This will show a loading screen before the passed function is called,
 *  allowing for a better ajax experience.
 *
 */
(function($) {
  $.faceboxConfirm = function(data,klass,callback) {
    callbackFunction = callback;
    $.faceboxConfirm.init()
    $.faceboxConfirm.loading()
    $.isFunction(data) ? data.call($) : $.faceboxConfirm.reveal(data, klass,callback)
  }

  $.faceboxConfirm.settings = {
    loading_image : __base_url + '../public/gwm/js/jquery/facebox/img/loading.gif',
    close_image   : __base_url + '../public/gwm/js/jquery/facebox/img/closelabel.gif',
    image_types   : [ 'png', 'jpg', 'jpeg', 'gif' ],
    faceboxConfirm_html  : '\
  <div id="faceboxConfirm" style="display:none;"> \
    <div class="popup"> \
      <table> \
        <tbody> \
          <tr> \
            <td class="tl"/><td class="b"/><td class="tr"/> \
          </tr> \
          <tr> \
            <td class="b"/> \
            <td class="body"> \
              <div class="faceboxcontent"> \
              </div> \
              <div class="footer"> \
                <input type="button" value="OK" onclick="javascript:setResult(1)"> \
                <input type="button" value="Cancelar" onclick="javascript:setResult(0)"> \
              </div> \
            </td> \
            <td class="b"/> \
          </tr> \
          <tr> \
            <td class="bl"/><td class="b"/><td class="br"/> \
          </tr> \
        </tbody> \
      </table> \
    </div> \
  </div>'
  }

  $.faceboxConfirm.loading = function() {
    if ($('#faceboxConfirm .loading').length == 1) return true

    $('#faceboxConfirm .faceboxConfirmcontent').empty()
    $('#faceboxConfirm .body').children().hide().end().
      append('<div class="loading"><img src="'+$.faceboxConfirm.settings.loading_image+'"/></div>')
    var pageScroll = $.faceboxConfirm.getPageScroll()
    $('#faceboxConfirm').css({
      top:	pageScroll[1] + ($.faceboxConfirm.getPageHeight() / 10),
      left:	pageScroll[0]
    }).show()

    $(document).bind('keydown.faceboxConfirm', function(e) {
      if (e.keyCode == 27) $.faceboxConfirm.close()
    })
  }

  $.faceboxConfirm.reveal = function(data, klass, callback) {

    if (klass) $('#faceboxConfirm .faceboxcontent').addClass(klass)
    $('#faceboxConfirm .faceboxcontent').html("");
    $('#faceboxConfirm .faceboxcontent').append(data)
    $('#faceboxConfirm .loading').remove()
    $('#faceboxConfirm .body').children().fadeIn('normal')
  }

  $.faceboxConfirm.close = function() {
    $(document).trigger('close.faceboxConfirm')
    return false
  }

  $(document).bind('close.faceboxConfirm', function() {
    $(document).unbind('keydown.faceboxConfirm')
    $('#faceboxConfirm').fadeOut(function() {
      $('#faceboxConfirm .faceboxcontent').removeClass().addClass('faceboxcontent')
    })
  })

  $.fn.faceboxConfirm = function(settings) {
    $.faceboxConfirm.init(settings)

    var image_types = $.faceboxConfirm.settings.image_types.join('|')
    image_types = new RegExp('\.' + image_types + '$', 'i')

    function click_handler() {
      $.faceboxConfirm.loading(true)

      // support for rel="faceboxConfirm[.inline_popup]" syntax, to add a class
      var klass = this.rel.match(/faceboxConfirm\[\.(\w+)\]/)
      if (klass) klass = klass[1]

      // div
      if (this.href.match(/#/)) {
        var url    = window.location.href.split('#')[0]
        var target = this.href.replace(url,'')
        $.faceboxConfirm.reveal($(target).clone().show(), klass)

      // image
      } else if (this.href.match(image_types)) {
        var image = new Image()
        image.onload = function() {
          $.faceboxConfirm.reveal('<div class="image"><img src="' + image.src + '" /></div>', klass)
        }
        image.src = this.href

      // ajax
      } else {
        $.get(this.href, function(data) { $.faceboxConfirm.reveal(data, klass) })
      }

      return false
    }

    this.click(click_handler)
    return this
  }

  $.faceboxConfirm.init = function(settings) {
    if ($.faceboxConfirm.settings.inited) {
      return true
    } else {
      $.faceboxConfirm.settings.inited = true
    }

    if (settings) $.extend($.faceboxConfirm.settings, settings)
    $('body').append($.faceboxConfirm.settings.faceboxConfirm_html)

    var preload = [ new Image(), new Image() ]
    preload[0].src = $.faceboxConfirm.settings.close_image
    preload[1].src = $.faceboxConfirm.settings.loading_image

    $('#faceboxConfirm').find('.b:first, .bl, .br, .tl, .tr').each(function() {
      preload.push(new Image())
      preload.slice(-1).src = $(this).css('background-image').replace(/url\((.+)\)/, '$1')
    })

    $('#faceboxConfirm .close').click($.faceboxConfirm.close)
    //$('#faceboxConfirm .close_image').attr('src', $.faceboxConfirm.settings.close_image)
  }

  // getPageScroll() by quirksmode.com
  $.faceboxConfirm.getPageScroll = function() {
    var xScroll, yScroll;
    if (self.pageYOffset) {

      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;

    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;	
    }
    return new Array(xScroll,yScroll) 
  }

  // adapter from getPageSize() by quirksmode.com
  $.faceboxConfirm.getPageHeight = function() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }	
    return windowHeight
  }
})(jQuery);

function setResult(val){
    $.faceboxConfirm.close() 
    if(val == 1){
        callbackFunction();
    }
}