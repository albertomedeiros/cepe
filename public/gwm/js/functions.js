function send_post (url, params) {
    var form = document.createElement('form');
    form.action = url;
    form.method = 'POST';
    form.style.display = 'none';

    for (key in params) {
        if (params[key] instanceof Array) {
            for (var i = 0; i < params[key].length; i++) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = key + '[]';
                input.value = params[key][i];

                form.appendChild(input);
            }
        } else {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = params[key];

            form.appendChild(input);
        }
    }

    document.body.appendChild(form);

    form.submit();
}

$.fn.exists = function () {
    return $(this).length > 0 ? true : false;
};

jQuery(document).ready(function(){
    jQuery('a[rel=external]').attr('target','_blank');
    jQuery('.clear-text').clearDefault();

    $('.add-dependent').click(function() {
        $( ".box-dependent" ).fadeIn( "slow", function() {
        // Animation complete.
        });
    });

    $('.btn-close-lb').click(function() {
        $( ".box-dependent, .lb-cards-arena" ).fadeOut( "slow", function() {
        // Animation complete.
        });
    });

    $('#permits_admin').click(function(){
        if ($(this).is(':checked')) {
            $('input:checkbox').each(function(){
                $(this).attr('checked', true);
            });
        } else {
            $('input:checkbox').each(function(){
                $(this).attr('checked', false);
            });
        }
    });

    $('.list-permits input:checkbox').click(function(){
        var checked = true;

        $('.list-permits input:checkbox[id!=permits_admin]').each(function(){
            if (!$(this).is(':checked')) {
                checked = false;
            }
        });

        if (checked) {
            $('#permits_admin').attr('checked', true);
        } else {
            $('#permits_admin').attr('checked', false);
        }
    });

    $('#header_checker').click(function() {
        $('.lista input:checkbox.lista-check').attr('checked', this.checked ? 'checked' : '');
    });

    if ($('#date_publish_f_field').exists()) {
        $('#date_publish_f_field').mask('99/99/9999');
    };

    /* Erro ao fazer o login */
    function shake(){
        $('#login-page .login').animate({'left':'-15px'}, 70).animate({'left':'15px'}, 70).animate({'left':'-15px'}, 70).animate({'left':'15px'}, 70).animate({'left':'-7px'}, 70).animate({'left':'0'}, 70);
    };

    $('#login-page .login .right a').click(function(){
        shake();
        return false;
    });

    $('#frm-login').submit(function(){
        var login = $('#login');
        var password = $('#password');
        var error = false;

        $("input.error").removeClass('error');

        $("p.error").fadeOut(400);

        if (login.val() == "") {
            login.addClass('error');
            error = true;
        };

        if (password.val() == "") {
            password.addClass('error');
            error = true;
        };

        if (error) {
            $("p.error").fadeIn(400);
        } else {
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: "data[login]=" + login.val() + '&data[password]=' + escape(password.val()),
                success: function(msg){
                    console.log(msg);
                    if (msg == 1) {
                        window.location = $('#frm-login').attr('rel');
                    } else {
                        password.val('');
                        shake();
                    };
                }
            });
        };

        return false;
    });

    /* Área do usuário no topo */
    $('.client-area .open-options').click(function(){
        $(this).toggleClass('active');
        $(this).next().toggle();
        return false;
    });

    /* Menu */
    $('#menu nav ul').hide();
    $('#menu nav.active ul').show();

    $('#menu .show-menu').click(function(){
        if( $(this).next().is(':hidden') ){
            $('#menu nav ul').slideUp();
            $(this).next().slideToggle();
        };
        return false;
    });

    /* Mensagens de alerta */
    $('.alert .close').click(function(){
        $(this).parent().fadeOut();
        return false;
    });

    /* Selecionar todo o texto do input no click */
    $('#data li input').click(function(){
        $(this).select();
    });

    /* Ordenar a tabela */
    if ($('#sort-table').exists()) {
        $("#sort-table").tablesorter();
    }

    /* Marcar e desmacar checkbox */
    $('.select-which a.all').click(function(){
        $('input:checkbox').each(function(){
            if (!$(this).is(':checked')) {
                $(this).attr('checked', true);
            }
        });
    });

    $('.select-which a.none').click(function(){
        $('input:checkbox').each(function(){
            if ($(this).is(':checked')) {
                $(this).attr('checked', false);
            }
        });
    });

    $('.take-action select').change(function(){
        _remove_selected();
    });

    if ($('textarea.tinymce').exists()) {
        tinymce.init({
        selector: 'textarea.tinymce',
        width: 699,
        height: 400,
        menubar: false,
        branding: false,
        toolbar_items_size: 'small',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu powerpaste code moxiemanager'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | removeformat | fullscreen code',
        powerpaste_allow_local_images: true,
        moxiemanager_image_settings : { 
          view : 'thumbs', 
          extensions : 'jpg,png,gif'
        },
        relative_urls: false,
        remove_script_host : false,
      });
    }

    if ($('textarea.tinymce2').exists()) {
        tinymce.init({
        selector: 'textarea.tinymce2',
        width: 460,
        height: 200,
        menubar: false,
        branding: false,
        toolbar_items_size: 'small',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu powerpaste code moxiemanager'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | removeformat | fullscreen code',
        powerpaste_allow_local_images: true,
        moxiemanager_image_settings : { 
          view : 'thumbs', 
          extensions : 'jpg,png,gif'
        },
        relative_urls: false,
        remove_script_host : false,
      });
    }
});

/* Clear forms */
(function($){
    $.fn.clearDefault = function(){
        return this.each(function(){
            var default_value = $(this).val();
            $(this).focus(function(){
                if ($(this).val() == default_value) $(this).val("");
            });
            $(this).blur(function(){
                if ($(this).val() == "") $(this).val(default_value);
            });
        });
    };
})(jQuery);
