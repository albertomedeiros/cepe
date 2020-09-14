// Clear forms
(function ($) {

    $.fn.clearDefault = function () {
        return this.each(function () {
            var defaultValue = $(this).val();
            $(this).focus(function () {
                if ($(this).val() === defaultValue) {
                    $(this).val('');
                }
            });
            $(this).blur(function () {
                if ($(this).val() === '') {
                    $(this).val(defaultValue);
                }
            });
        });
    };
})(jQuery);

(function () {
    // sleep(2000);


    var configDatePicker = {
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    };

    // calendário diários
    var diarioDatePicker = $('#diario-date-picker');
    var textNumeroEdicao = $('#textNumeroEdicao');
    diarioDatePicker.datepicker(configDatePicker);

    if (!diarioDatePicker.val()) {
        diarioDatePicker.val(new Date().toLocaleDateString("pt-BR"));
    }

    //accordion
    $(".lista-faq .cabecalho").click(function () {

        $('.cabecalho').removeClass('aberto');
        $(this).addClass('aberto');

        if ($(this).next("div").is(":visible")) {
            $(this).next("div").slideUp(300);
            $(this).removeClass('aberto');
        } else {
            $(".lista-faq .conteudo-faq").slideUp(300);
            $(this).next("div").slideToggle(300);
        }
    });


    $('#diario').click(function () {
        var page = $(this).data('page');
        console.log(page);
        $('#pcd-submenu').find('#outros').removeClass('active');
        $("#pcd-submenu [data-page='" + page + "']").addClass('active');
        $('#cpd-page-produtos').not(page).slideUp(600);
        $(page).slideDown(800);
        return false;
    });
    $('#outros').click(function () {
        var page = $(this).data('page');
        console.log(page);
        $('#pcd-submenu').find('#diario').removeClass('active');
        $("#pcd-submenu [data-page='" + page + "']").addClass('active');
        $('#cpd-page-diario').not(page).slideUp(600);
        $(page).slideDown(800);
        return false;
    });

    diarioDatePicker.change(function () {
        getCadernos(diarioDatePicker.val(), true);
    });

    textNumeroEdicao.change(function () {
        diarioDatePicker.val(textNumeroEdicao.val());
        getCadernos(textNumeroEdicao.val(), true);
    });

    //busca avançada
    var botaoBuscaAvancada = $('#botaoBuscaAvancada');
    var botaoLimparBuscaAvancada = $('#botaoLimparBuscaAvancada');
    var buscaDataFinalDate = $('#buscaDataFinal');
    var buscaDataInicialDate = $('#buscaDataInicial');

    buscaDataFinalDate.datepicker(configDatePicker);
    buscaDataInicialDate.datepicker(configDatePicker);

    botaoBuscaAvancada.click(function () {
        var buscaDataFinal = $('#buscaDataFinal').val();
        var buscaDataInicial = $('#buscaDataInicial').val();
        var buscaPalavra = $('#buscaPalavra').val();
        buscaAvancada(buscaPalavra, buscaDataInicial, buscaDataFinal);
    });

    botaoLimparBuscaAvancada.click(function () {
        $('#buscaDataFinal').val('');
        $('#buscaDataInicial').val('');
        $('#buscaPalavra').val('');
    });

    //consultar autenticidade
    var botaoConsultarAutenticidade = $('#botaoConsultarAutenticidade');

    botaoConsultarAutenticidade.click(function () {
        verificarAutenticidade();
    });

    //consultar por numero da edicao

    $('#botaoNumeroEdicao').click(function () {
        buscarPorNumeroEdicao();
    });

    $('#phoneFale')

        .on('keypress', function (e) {
            var key = e.charCode || e.keyCode || 0;
            var phone = $(this);
            if (phone.val().length === 0) {
                phone.val(phone.val() + '(');
            }
            // Auto-format- do not expose the mask as the user begins to type
            if (key !== 8 && key !== 9) {
                if (phone.val().length === 3) {
                    phone.val(phone.val() + ') ');
                }
                if (phone.val().length === 10) {
                    phone.val(phone.val() + '-');
                }
                if (phone.val().length >= 15) {
                    phone.val(phone.val().slice(0, 15));
                }
            }

            // Allow numeric (and tab, backspace, delete) keys only
            return (key == 8 ||
                key == 9 ||
                key == 46 ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        })

        .on('focus', function () {
            phone = $(this);

            if (phone.val().length === 0) {
                phone.val('(');
            } else {
                var val = phone.val();
                phone.val('').val(val); // Ensure cursor remains at the end
            }
        })

        .on('blur', function () {
            $phone = $(this);

            if ($phone.val() === '(') {
                $phone.val('');
            }
        });

    $('.popup .close-popup').click(function () {
        $('.popup').removeClass('open');
    });

    $('.anexos .anexo').click(function (event) {

        var id = $(this).attr("id");
        $('.item-popup').removeClass('popup-active');
        $('.licitacoes .popup').addClass('open');
        $('.form-cpf').addClass('popup-active');

        $('.form-cpf').submit(function () {
            var form = $(this),
                error = false,
                cpf_cnpj = false,
                submitText = form.find('.form-submit').data('text');

            form.find('.form-field').removeClass('error');
            form.find('.msg').slideUp(300);

            form.find('.required').each(function (i, e) {
                var e = $(e);
                if (!e.val()) {
                    e.parent().addClass('error');
                    error = true;
                } else if (e.attr('id') == 'email' && !checkEmail(e.val())) {
                    e.parent().addClass('error');
                    error = true;
                } else if (e.attr('id') == 'cpf-cnpj' && !formata_cpf_cnpj(e.val())) {
                    e.parent().addClass('error');
                    error = true;
                    cpf_cnpj = e.val();
                }
            });

            if (error) {
                form.find('.msg-error').slideDown();
            } else {
                cpf_cnpj = $("#cpf-cnpj").val();
                $.ajax({
                    type: 'post',
                    url: $(form).attr('action'),
                    dataType: 'json',
                    data: {
                        'cpf-cnpj': cpf_cnpj,
                        'id_download': id
                    },
                    beforeSend: function () {
                        form.find('.form-submit').val('Enviando...');
                        form.find('.form-submit').prop('disabled', true);
                        form.find('.msg-error').slideUp();
                    },
                    complete: function () {
                        form.get(0).reset();
                        form.find('.form-text').text("");
                        form.find('.form-field').removeClass('form-focus');
                        form.find('.form-field').removeClass('error');
                        form.find('.form-submit').val(submitText);
                        form.find('.form-submit').prop('disabled', false);
                    },
                    success: function (resp) {
                        if (resp.redirect) {
                            $('.licitacoes .popup').removeClass('open');
                            location.reload();
                        } else if (resp.register) {
                            $('#popup-register').addClass('popup-active');
                            $('#popup-log').removeClass('popup-active');
                            $('.form-licitacao').submit(function (e) {
                                e.preventDefault();
                                var form = $(this),
                                    error = false,
                                    submitText = form.find('.form-submit').data('text');

                                form.find('.form-field').removeClass('error');
                                form.find('.msg').slideUp(300);

                                form.find('.required').each(function (i, e) {
                                    var e = $(e);
                                    if (!e.val()) {
                                        e.parent().addClass('error');
                                        error = true;
                                    } else if (e.attr('id') == 'email' && !checkEmail(e.val())) {
                                        e.parent().addClass('error');
                                        error = true;
                                    }
                                });

                                if (error) {
                                    form.find('.msg-error').slideDown();
                                } else {
                                    $.ajax({
                                        type: 'post',
                                        url: $(form).attr('action'),
                                        dataType: 'json',
                                        data: $(form).serialize(),
                                        beforeSend: function () {
                                            form.find('.form-submit').val('Enviando...');
                                            form.find('.form-submit').prop('disabled', true);
                                            form.find('.msg-error').slideUp();
                                        },
                                        complete: function () {
                                            form.get(0).reset();
                                            form.find('.form-text').text("");
                                            form.find('.form-field').removeClass('form-focus');
                                            form.find('.form-field').removeClass('error');
                                            form.find('.form-submit').val(submitText);
                                            form.find('.form-submit').prop('disabled', false);
                                        },
                                        success: function (resp) {
                                            if (resp.success) {
                                                $('#register-success').addClass('popup-active');
                                                $('#popup-register').removeClass('popup-active');
                                            } else {
                                                form.find('.msg-error').html(resp.message);
                                                form.find('.msg-error').slideDown();
                                            }
                                        }
                                    });
                                }
                                return false;
                            });
                        }

                    }
                });
            }
            return false;
        });
    });


    $(".mask-cpf-cnpj").focusout(function (e) {
        var element;
        element = $(this);
        element[0].value = cpfCnpj(element.val());
    });

    $("input.form-text")
        .on('focus', function () {
            $(this).parent().addClass('form-focus');
        })

        .on('blur', function () {
            if ($(this).val() == "") {
                $(this).parent().removeClass('form-focus');
            }
        });

    $('#textNumeroEdicao').datepicker(configDatePicker);

    $('#textNumeroEdicao').keyup(function () {
        $('#textNumeroEdicao').val(formatarData($('#textNumeroEdicao').val()));
    });

    $('#buscaDataFinal').keyup(function () {
        $('#buscaDataFinal').val(formatarData($('#buscaDataFinal').val()));
    });

    $('#buscaDataInicial').keyup(function () {
        $('#buscaDataInicial').val(formatarData($('#buscaDataInicial').val()));
    });

// btn mobile
    var menu = $(".header-mobile .menu");
    var submenu = $(".header-mobile .menu").find('.submenu');

    getCadernos(diarioDatePicker.val(), true);

    $('.btn-mobile').click(function () {
        $(this).toggleClass('open');
        menu.toggleClass('open');
        menu.slideToggle();
        menu.find('ul').removeClass('open');
        $('.scroll').jScrollPane();
    });

    menu.find('.submenu').click(function () {
        $(this).find('ul').toggleClass('open');
    });


// WOW
    var wow = new WOW({
        boxClass: 'wow', // default
        animateClass: 'animated', // default
        mobile: true, // default
        live: true // default
    });
    wow.init();

//custom select
    $(".custom-select").each(function () {
        var classes = $(this).attr("class"),
            id = $(this).attr("id"),
            name = $(this).attr("name");
        var template = '<div class="' + classes + '">';
        template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
        template += '<div class="custom-options">';
        $(this).find("option").each(function () {
            template += '<span class="custom-option ' + ($(this).is(":selected") ? 'selection' : '') + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
        });
        template += '</div></div>';

        $(this).wrap('<div class="custom-select-wrapper"></div>');
        $(this).hide();
        $(this).after(template);

        $('.custom-options').jScrollPane();

        if ($(this).find('option:selected')) {
            $(this).siblings().find(".custom-select-trigger").text($(this).find('option:selected').text());
        }
    });

    $(".custom-option:first-of-type").hover(function () {
        $(this).parents(".custom-options").addClass("option-hover");
    }, function () {
        $(this).parents(".custom-options").removeClass("option-hover");
    });

    $(".custom-select-trigger").on("click", function (event) {
        $('html').one('click', function () {
            $(".custom-select").removeClass("opened");
        });
        $(this).parents(".custom-select").toggleClass("opened");
        event.stopPropagation();
    });

    $(".custom-option").on("click", function () {
        $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
        $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
        $(this).addClass("selection");
        $(this).parents(".custom-select").removeClass("opened");
        $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
    });

//parallax
    function parallax() {
        $('.parallax').each(function () {
            var $pos;
            var $obj = $(this);
            if ($(window).width() > 900) {
                $(window).scroll(function () {
                    var yPos = -($(window).scrollTop() / $obj.data('parallax-speed'));
                    var bgpos = '50% ' + yPos + 'px';
                    $obj.css('background-position', bgpos);
                });
            } else {
                $obj.css('background-position', 0);
                $(window).scroll(function () {
                    $obj.css('background-position', 0);
                });
            }
        });
    }

    parallax();


//modal calendário
    function calendarioPopUp() {

        var popup = $(".calendario-popup");
        var calendario = $(".calendario");
        var buscaAvancada = $(".calendario-popup.busca");
        var resultado = $(".calendario-popup.resultado");

//visualizar calendário slider
        $(".acoes-calendario .botao-calendario").click(function (e) {
            e.preventDefault();

            var str = "" + day;
            var pad = "00";
            var new_day = pad.substring(0, pad.length - str.length) + str;

            var calendar_date = new_day + '/' + $('#mes').parent().find('.custom-option.selection').data('value') + '/' + $('#ano').parent().find('.custom-option.selection').data('value');
            get_registry_ofice(calendar_date);
        });

        $(".acervo a").click(function (e) {
            e.preventDefault();
            proceedDOWeb($("#diario-date-picker").val());
        });

        resultado.find('.acervo #pdf').click(function (e) {
            e.preventDefault();
            proceedDocpro($(this).data('date'));
        });

//visualizar calendário
        $(".acoes-calendario .visualizar-calendario").click(function (e) {
            e.preventDefault();
            calendario.fadeIn("fast");
        });

//busca Avançada
        $("#busca-avancada").click(function (e) {
            e.preventDefault();
            buscaAvancada.fadeIn("fast");
        });

        calendario.find('.visualizar').click(function (e) {
            e.preventDefault();
            get_registry_ofice($("#mydate").val());
        });

        buscaAvancada.find('#novosistema').click(function (e) {
            window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/busca-avancada?diario=MQ==', '_blank');
        });

        buscaAvancada.find('#bt-visualizar').click(function (e) {
            e.preventDefault();
            proceedDocproPesquisa();
        });

        //container popup
        popup.each(function () {
            $(this).find('.fechar').click(function () {
                $(this).parent().parent().parent().fadeOut("fast");
            });
        });

    }

    calendarioPopUp();

    $('.licitacoes-popup').click(function (e) {
        e.preventDefault();
        $('.popup').addClass('open');
    });

    $('.close-popup').click(function () {
        $('.popup').removeClass('open');
    });

// ocultando selects por radio buttom
    $('#campo-radio1').click(function () {
        $('#anos').show();
        $('#decadas').hide();
    });
    $('#campo-radio2').click(function () {
        $('#anos').hide();
        $('#decadas').show();
    });
    $('#campo-radio3').click(function () {
        $('#anos').hide();
        $('#decadas').hide();
    });

//mascara de telefone
    $("input[name='telefone'], input[name='celular']").focusout(function () {
        var e, t;
        t = $(this);
        t.unmask();
        e = t.val().replace(/\D/g, "");
        e.length > 10 ? t.mask("(99) 99999-9999", {
            autoclear: !1
        }) : t.mask("(99) 9999-99999", {
            autoclear: !1
        });
    }).trigger("focusout");

//formulário de contato
    $('#form-contato').validate({
        rules: {
            nome: {required: true},
            email: {required: true, email: true},
            telefone: {required: true}
        },
        messages: {
            nome: {required: 'Preencha o campo nome'},
            email: {required: 'Informe o seu email', email: 'Ops, informe um email válido'},
            telefone: {required: 'Preencha o campo telefone'}
        },
        errorPlacement: function (error, element) {
            $('.contato .msg.error').fadeIn('fast');
        },
        submitHandler: function (form) {

            var dados = $(form).serialize();

            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: dados,
                dataType: 'json',
                complete: function () {
                    $('#form-contato input[type="submit"]').removeAttr('disabled');
                },
                beforeSend: function () {
                    $('#form-contato input[type="submit"]').attr('disabled', 'disabled');
                    $('.contato .msg.error').fadeOut('fast');
                    $('.contato .msg.success').fadeOut('fast');
                },
                success: function (data) {
                    if (data.success) {
                        $("#form-contato")[0].reset();
                        $('.contato .msg.success').fadeIn('fast');
                        $('.contato .msg.success').html(data.message);
                    } else {
                        $('.contato .msg.error').fadeIn('fast');
                    }
                    grecaptcha.reset();
                }
            });

            return false;
        }
    });

// CPF
    $(".mask-cpf").mask("999.999.999-99", {placeholder: " "});

    function check_cpf(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000") return false;

        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10))) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11))) return false;
        return true;
    }

    function checkEmail(email) {
        var exclude = /[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
        var check = /@[\w\-]+\./;
        var checkend = /\.[a-zA-Z]{2,3}$/;
        if (((email.search(exclude) != -1) || (email.search(check)) == -1) || (email.search(checkend) == -1)) {
            return false;
        } else {
            return true;
        }
    }

// CERTIFICADO DIGITAL
// PAGES


    $('.js-agendar').click(function () {
        var page = $('.pcd-item.agendamento');
        page.find('.pcd-content').slideDown();
        page.addClass('item-active');
    });

    $('.pcd-form.form-login .form-text').focus(function () {
        $('.pcd-form.form-login .form-text').addClass('required');
        $('.pcd-form.form-cadastro .form-text').removeClass('required');
    });
    $('.pcd-form.form-cadastro .form-text').focus(function () {
        $('.pcd-form.form-cadastro .form-text').addClass('required');
        $('.pcd-form.form-login .form-text').removeClass('required');
    });

// STEPS
    function nextStep(id, order) {
        $('.pcd-item', $(id)).each(function (index) {
            if (order == index) {
                $(this).find('.pcd-content').slideDown();
                $(this).addClass('item-active');
                return false;
            }
        });
    }

// AGENDAMENTO
    $('.js-dados-emissao').click(function () {
        var elem = $('#cpf-agend'),
            number = elem.val();

        number = number.replace(".", "");
        number = number.replace(".", "");
        number = number.replace("-", "");

        elem.parent().removeClass('error');

        if (check_cpf(number)) {
            nextStep('#steps-agend', 1);
        } else {
            $('#cpf-agend').parent().addClass('error');
        }

        return false;
    });

    if ($('.pcd-agend-date .emissao-calendar #mydate')) {
        var und;
        $("#mydate").val(und);
    }

    $('.js-finalizar-emissao').click(function () {
        if ($('#mydate').val() && $('.pcd-agend-date .radios input[name=horario]:checked').val() && $('.pcd-agend-date .checkbox input[name="terms"]:checked').val()) {
            $(this).next().slideUp();
            $('.js-form-agend').submit();
        } else {
            $(this).next().slideDown();
        }
        return false;
    });

// COMPRA CERTIFICADO

    $('.js-botao-padrao').click(function () {
        var obj = $(this);
        var tipo = obj.parent();
        tipo.addClass('active');
        tipo.find('.js-botao-padrao').removeClass('checked');
        obj.addClass('checked');
        nextStep('#steps-compra', 1);
    });
    $('.js-checkbox').click(function () {
        var obj = $(this);
        var produto = obj.parent().parent().parent();
        produto.find('.pcd-produto').removeClass('active');
        produto.find('.checkbox').removeClass('checked');
        obj.addClass('checked');
        obj.parent().parent().addClass('active');
        produto.addClass('produtos-checked');
        if (obj.hasClass('js-checkbox-validade')) {
            nextStep('#steps-compra', 3);
        } else {
            nextStep('#steps-compra', 2);
        }
    });
    $('.desconto .js-next').click(function functionName() {
        nextStep('#steps-compra', 4);
    });

// INTERNA FILTRO
    $('.filtro-select .filtro-option').click(function (e) {
        e.preventDefault();
        var filtro = $(this).data("filter");

        $('.filtro-select .filtro-option').removeClass('active');
        $(this).addClass('active');
        $('.filtro-content .filtro-item').removeClass('open');
        $('#filtro-' + filtro).addClass('open');
    });

    $('.advanced-radio input[type=radio][name=advanced]').change(function () {
        var value = $(this).val(),
            select = $('#advanced-' + value);

        $('.form-advanced .form-field-select').removeClass('required');
        $('.form-advanced .form-field-select .form-select').removeClass('required');

        select.addClass('required');
        select.parent().addClass('required');

    });

    $(".acordeon-click", $(".acordeon")).click(function () {
        if (!$(this).hasClass("active")) {
            $(".acordeon-click").removeClass("active");
            $(".acordeon-inner").slideUp();
        }
        $(this).toggleClass("active");
        $(this).next(".acordeon-inner").slideToggle();
    });


})();

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

function proceedDocpro(date) {
    valor = date;
    mesDic2 = {
        "01": "Janeiro",
        "02": "Fevereiro",
        "03": "Março",
        "04": "Abril",
        "05": "Maio",
        "06": "Junho",
        "07": "Julho",
        "08": "Agosto",
        "09": "Setembro",
        "10": "Outubro",
        "11": "Novembro",
        "12": "Dezembro"
    };
    elemento = valor.split("/");
    intAno = parseInt(elemento[2]);
    intDia = parseInt(elemento[0]);
    ano = elemento[2];
    mes = elemento[1];
    mesNome = mesDic2[mes];
    dia = elemento[0];

    var data = new Date();
    var dataImplantacao = new Date();
    dataImplantacao.setUTCFullYear(2018, 11, 19);
    data.setUTCFullYear(intAno, mes, intDia);

    if (data >= dataImplantacao) {
        //visualizar pdf
        window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-jornal?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
    } else if (intAno >= 2014) {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + dia + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
    } else if (intAno < 2004) {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=DO_' + ano + mes + '&pasta=Dia%20' + dia, '_blank');
    } else {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
    }

    return false;
}

function proceedDOWeb(date) {
    var valor = date;
    var mesDic2 = {
        "01": "Janeiro",
        "02": "Fevereiro",
        "03": "Março",
        "04": "Abril",
        "05": "Maio",
        "06": "Junho",
        "07": "Julho",
        "08": "Agosto",
        "09": "Setembro",
        "10": "Outubro",
        "11": "Novembro",
        "12": "Dezembro"
    };
    var elemento = valor.split("/");
    var intAno = parseInt(elemento[2]);
    var intDia = parseInt(elemento[0]);
    var ano = elemento[2];
    var mes = elemento[1];
    var mesNome = mesDic2[mes];
    var dia = elemento[0];

    var data = new Date();
    var dataImplantacao = new Date();
    dataImplantacao.setUTCFullYear(2018, 11, 19);
    data.setUTCFullYear(intAno, mes, intDia);

    if (data >= dataImplantacao) {
        //visulizar html
        window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-diario?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
    } else if (intAno >= 2014) {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + dia + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
    } else if (intAno < 2004) {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=DO_' + ano + mes + '&pasta=Dia%20' + dia, '_blank');
    } else {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
    }

    return false;
}

function verificarAutenticidade() {
    var codigo = $('#consultarAutenticidade').val();
    if (codigo) {
        window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/checar-autenticidade?codigo=' + codigo, '_blank');
    } else {
        alertaError('O código de autenticidade deve estar preenchido');
    }
}

function proceedDocproPesquisa() {

    var valor = $('#palavrachave').val();
    if ($('input:checked').val() == 'ano') {
        var ano = $('#anos').val();
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + '&pesq=' + valor, '_blank');
    } else if ($('input:checked').val() == 'decada') {
        var dec = $('#decadas').val();
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=D' + dec + '&pesq=' + valor, '_blank');
    } else if ($('input:checked').val() == 'todos') {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=FULL&pesq=' + valor, '_blank');
    } else {
        window.open('http://200.238.101.22/docreader/docreader.aspx?bib=FULL&pesq=' + valor, '_blank');
    }

    return false;
}

function buscaAvancada(palavra, dataInicial, dataFinal) {
    if (podeBuscar(palavra, dataInicial, dataFinal)) {

        var elemento = dataInicial.split("/");
        var ano = elemento[2];
        var mes = elemento[1];
        var dia = elemento[0];
        var dataInicio = new Date(ano, mes - 1, dia);

        dataInicial = dataInicio.toLocaleDateString({
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        });
        elemento = dataInicial.split("/");
        ano = elemento[2];
        mes = elemento[1];
        dia = elemento[0];
        dataInicio = new Date(ano, mes - 1, dia);

        var elemento1 = dataFinal.split("/");
        var ano1 = elemento1[2];
        var mes1 = elemento1[1];
        var dia1 = elemento1[0];
        var dataFim = new Date(ano1, mes1 - 1, dia1);

        dataFinal = dataFim.toLocaleDateString({
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        });
        elemento1 = dataFinal.split("/");
        ano1 = elemento1[2];
        mes1 = elemento1[1];
        dia1 = elemento1[0];
        dataFim = new Date(ano1, mes1 - 1, dia1);

        if (dataInicio <= dataFim) {
            window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/busca-avancada?diario=MQ==&inicio=' + dataInicial + '&fim=' + dataFinal + '&palavra=' + palavra + '&consultar=true', '_blank');
        } else {
            alertaError("A data final não pode ser anterior à data inicial");
        }
    } else {
        alertaError("Os campos \"Palavra\", \"Data inicial\" e \"Data final\" devem estar preenchidos!");
    }
}

function podeBuscar(palavra, dataInicial, dataFinal) {
    return !naoPodeBuscar(palavra, dataInicial, dataFinal);
}

function naoPodeBuscar(palavra, dataInicial, dataFinal) {
    return !palavra || !dataInicial || !dataFinal;
}

function visualizeHTML() {
    var data = $("#diario-date-picker").val();
    var elemento = data.split("/");
    var intAno = parseInt(elemento[2]);
    var ano = elemento[2];
    var mes = elemento[1];
    var dia = elemento[0];
    var dataImplantacao = new Date(2018, 10, 18);
    var dataPesquisa = new Date(ano, mes - 1, dia);
    data = dataPesquisa.toLocaleDateString({
        year: "numeric",
        month: "2-digit",
        day: "2-digit"
    });
    elemento = data.split("/");
    intAno = parseInt(elemento[2]);
    ano = elemento[2];
    mes = elemento[1];
    dia = elemento[0];
    dataPesquisa = new Date(ano, mes - 1, dia);
    if (dataPesquisa > dataImplantacao) {
        window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-diario?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
    } else {
        var mesDic2 = {
            "01": "Janeiro",
            "02": "Fevereiro",
            "03": "Março",
            "04": "Abril",
            "05": "Maio",
            "06": "Junho",
            "07": "Julho",
            "08": "Agosto",
            "09": "Setembro",
            "10": "Outubro",
            "11": "Novembro",
            "12": "Dezembro"
        };

        var mesNome = mesDic2[mes];

        if (intAno < 2004) {
            window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + '&pasta=Dia%20' + dia, '_blank');
        } else if (intAno < 2014) {
            window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
        } else {
            window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + dia + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
        }
    }
}

function visualizeJornal() {
    var data = $("#diario-date-picker").val();
    var elemento = data.split("/");
    var intAno = parseInt(elemento[2]);
    var ano = elemento[2];
    var mes = elemento[1];
    var dia = elemento[0];
    var dataImplantacao = new Date(2018, 10, 18);
    var dataPesquisa = new Date(ano, mes - 1, dia);
    data = dataPesquisa.toLocaleDateString({
        year: "numeric",
        month: "2-digit",
        day: "2-digit"
    });
    elemento = data.split("/");
    intAno = parseInt(elemento[2]);
    ano = elemento[2];
    mes = elemento[1];
    dia = elemento[0];
    dataPesquisa = new Date(ano, mes - 1, dia);
    if (dataPesquisa > dataImplantacao) {
        window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-jornal?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
    } else {
        var mesDic2 = {
            "01": "Janeiro",
            "02": "Fevereiro",
            "03": "Março",
            "04": "Abril",
            "05": "Maio",
            "06": "Junho",
            "07": "Julho",
            "08": "Agosto",
            "09": "Setembro",
            "10": "Outubro",
            "11": "Novembro",
            "12": "Dezembro"
        };

        var mesNome = mesDic2[mes];

        if (intAno < 2004) {
            window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + '&pasta=Dia%20' + dia, '_blank');
        } else if (intAno < 2014) {
            window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
        } else {
            window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + dia + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
        }
    }
}

function buscarPorNumeroEdicao() {
    var numeroEdicao = $('#textNumeroEdicao').val();
    var hoje = new Date();
    var dataImplantacao = new Date(2018, 10, 19);
    var elemento = numeroEdicao.split("/");
    var intAno = parseInt(elemento[2]);
    var ano = elemento[2];
    var mes = elemento[1];
    var dia = elemento[0];
    var dataEdicao = new Date(ano, mes - 1, dia);
    numeroEdicao = dataEdicao.toLocaleDateString({
        year: "numeric",
        month: "2-digit",
        day: "2-digit"
    });
    elemento = numeroEdicao.split("/");
    intAno = parseInt(elemento[2]);
    ano = elemento[2];
    mes = elemento[1];
    dia = elemento[0];
    dataEdicao = new Date(ano, mes - 1, dia);
    if (numeroEdicao) {
        if (hoje >= dataEdicao) {
            if (dataEdicao >= dataImplantacao) {
                window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-diario?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
            } else {
                var mesDic2 = {
                    "01": "Janeiro",
                    "02": "Fevereiro",
                    "03": "Março",
                    "04": "Abril",
                    "05": "Maio",
                    "06": "Junho",
                    "07": "Julho",
                    "08": "Agosto",
                    "09": "Setembro",
                    "10": "Outubro",
                    "11": "Novembro",
                    "12": "Dezembro"
                };

                var mesNome = mesDic2[mes];

                if (intAno < 2004) {
                    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + '&pasta=Dia%20' + dia, '_blank');
                } else if (intAno < 2014) {
                    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
                } else {
                    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=' + ano + mes + dia + '&pasta=' + mesNome + '\\Dia%20' + dia, '_blank');
                }
            }
        } else {
            alertaError("A data não pode ser posterior ao dia de hoje!");
        }
    } else {
        alertaError("A data da edição deve estar preenchida.");
    }
}

function getCadernos(date, procurarCadernosHoje) {
    elemento = date.split("/");
    ano = elemento[2];
    mes = elemento[1];
    dia = elemento[0];

    var urlData = "&dia=" + ano + mes + dia;
    /* Ajax */
    $.ajax({
        type: "GET",
        url: "https://ws.cepe.com.br/publicar/dows.php",
        data: urlData,
        success: function (data) {
            result = data.split("&");
            html = '<div style="margin-top: 20px" class="row"><div class="col-md-5 col-lg-3"><img src="public/img/diarios/pdf-file-format-symbol.svg" class="pdf img-fluid"></div><div class="col-md-7 col-lg-9 text-left border"><h4 class="pdfs-titulo">Visualizar documentos em PDF</h4></div></div>';
            if (result != "") { // se mudar para !== não funciona
                changeMiniatura(elemento);
                for (i = 0; i < result.length - 1; i++) {
                    caderno = result[i].split("-")[1];
                    html += '<hr><div class="download-pdf-item"><p class="download-pdf">' + caderno + '</p><a id="a' + caderno + '" href="http://200.238.105.211/cadernos/' + ano + '/' + ano + mes + dia + '/' + result[i] + '/' + caderno + '(' + ano + mes + dia + ').pdf"' + ' target="_blank"><i style="font-size: 17pt" class="fas fa-external-link-alt font-icon-red"></i></a></div>';
                }
            } else {
                removeMiniatura();
                html = '<br><div class="row" align="center"><p style="text-decoration: underline;"><h4>Não há jornais para esta data.</h4></p></div><br><div class="row" align="center"><i style="font-size: 60px;" class="fas fa-exclamation-circle"></i></div>';
                if (procurarCadernosHoje) {
                    alertaError('Não foi publicado nenhum jornal na data ' + date);
                    getCadernos(new Date().toLocaleDateString("pt-BR"), false);
                } else {
                    getCadernos(new Date(ano, mes - 1, dia - 1).toLocaleDateString("pt-BR"), false);
                }
            }
            $('#cadernos-front').html(html);
            $('#dataSelecionada').html(date);
            $('#diario-date-picker').val(date);
        }
    });
}

function changeMiniatura(dateArray) {
    var data = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
    $('#img-miniatura-jornal').html('<img src="https://cepebr-prod.s3-sa-east-1.amazonaws.com/1/miniaturas/' + data + '.png" class="diario-thumb-image" style="max-width: 100%"/><div class="diario-thumb-middle"><div class="row"><div class="col-md-12"><span class="diario-thumb-texto-visualizao">Escolha o tipo de visualização:</span><br><br></div></div><div class="row"><div class="col-md-12"><a id="botaoVisualizacaoJornal" style="cursor: pointer" onclick="visualizeJornal()" class="diario-thumb-left-button botao-padrao2">Impressa</a></div></div><div class="row"><div class="col-md-12"><a style="cursor: pointer" id="botaoVisualizacaoHtml" onclick="visualizeHTML()" class="diario-thumb-left-button botao-padrao2">Eletrônica</a></div></div></div>');
}

function removeMiniatura() {
    $('#img-miniatura-jornal').html('<img src="https://cepebr-prod.s3-sa-east-1.amazonaws.com/1/miniaturas/imagemindisponivel.png" style="max-width: 100%"/><h3>Não houve publicação neste dia</h3>');
}

function formatarData(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/(\d{2})(\d)/, "$1/$2");
    v = v.replace(/(\d{2})(\d)/, "$1/$2");
    return v;
}

function alertaSucesso(mensagem) {
    swal({
        title: "Sucesso",
        text: mensagem,
        icon: "success",
        buttons: {
            cancel: "Fechar"
        }
    });

}

function alertaError(mensagem) {
    swal({
        title: "Aviso",
        text: mensagem,
        icon: "error",
        buttons: {
            cancel: "Fechar"
        }
    });
}

/*
 verifica_cpf_cnpj

 Verifica se é CPF ou CNPJ

 @see http://www.todoespacoonline.com/w/
*/
function verifica_cpf_cnpj(valor) {

    // Garante que o valor é uma string
    valor = valor.toString();

    // Remove caracteres inválidos do valor
    valor = valor.replace(/[^0-9]/g, '');

    // Verifica CPF
    if (valor.length === 11) {
        return 'CPF';
    }

    // Verifica CNPJ
    else if (valor.length === 14) {
        return 'CNPJ';
    }

    // Não retorna nada
    else {
        return false;
    }

} // verifica_cpf_cnpj

/*
 calc_digitos_posicoes

 Multiplica dígitos vezes posições

 @param string digitos Os digitos desejados
 @param string posicoes A posição que vai iniciar a regressão
 @param string soma_digitos A soma das multiplicações entre posições e dígitos
 @return string Os dígitos enviados concatenados com o último dígito
*/
function calc_digitos_posicoes(digitos, posicoes = 10, soma_digitos = 0) {

    // Garante que o valor é uma string
    digitos = digitos.toString();

    // Faz a soma dos dígitos com a posição
    // Ex. para 10 posições:
    //   0    2    5    4    6    2    8    8   4
    // x10   x9   x8   x7   x6   x5   x4   x3  x2
    //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
    for (var i = 0; i < digitos.length; i++) {
        // Preenche a soma com o dígito vezes a posição
        soma_digitos = soma_digitos + (digitos[i] * posicoes);

        // Subtrai 1 da posição
        posicoes--;

        // Parte específica para CNPJ
        // Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
        if (posicoes < 2) {
            // Retorno a posição para 9
            posicoes = 9;
        }
    }

    // Captura o resto da divisão entre soma_digitos dividido por 11
    // Ex.: 196 % 11 = 9
    soma_digitos = soma_digitos % 11;

    // Verifica se soma_digitos é menor que 2
    if (soma_digitos < 2) {
        // soma_digitos agora será zero
        soma_digitos = 0;
    } else {
        // Se for maior que 2, o resultado é 11 menos soma_digitos
        // Ex.: 11 - 9 = 2
        // Nosso dígito procurado é 2
        soma_digitos = 11 - soma_digitos;
    }

    // Concatena mais um dígito aos primeiro nove dígitos
    // Ex.: 025462884 + 2 = 0254628842
    var cpf = digitos + soma_digitos;

    // Retorna
    return cpf;

} // calc_digitos_posicoes

/*
 Valida CPF

 Valida se for CPF

 @param  string cpf O CPF com ou sem pontos e traço
 @return bool True para CPF correto - False para CPF incorreto
*/
function valida_cpf(valor) {

    // Garante que o valor é uma string
    valor = valor.toString();

    // Remove caracteres inválidos do valor
    valor = valor.replace(/[^0-9]/g, '');


    // Captura os 9 primeiros dígitos do CPF
    // Ex.: 02546288423 = 025462884
    var digitos = valor.substr(0, 9);

    // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
    var novo_cpf = calc_digitos_posicoes(digitos);

    // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
    var novo_cpf = calc_digitos_posicoes(novo_cpf, 11);

    // Verifica se o novo CPF gerado é idêntico ao CPF enviado
    if (novo_cpf === valor) {
        // CPF válido
        return true;
    } else {
        // CPF inválido
        return false;
    }

} // valida_cpf

/*
 valida_cnpj

 Valida se for um CNPJ

 @param string cnpj
 @return bool true para CNPJ correto
*/
function valida_cnpj(valor) {

    // Garante que o valor é uma string
    valor = valor.toString();

    // Remove caracteres inválidos do valor
    valor = valor.replace(/[^0-9]/g, '');


    // O valor original
    var cnpj_original = valor;

    // Captura os primeiros 12 números do CNPJ
    var primeiros_numeros_cnpj = valor.substr(0, 12);

    // Faz o primeiro cálculo
    var primeiro_calculo = calc_digitos_posicoes(primeiros_numeros_cnpj, 5);

    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    var segundo_calculo = calc_digitos_posicoes(primeiro_calculo, 6);

    // Concatena o segundo dígito ao CNPJ
    var cnpj = segundo_calculo;

    // Verifica se o CNPJ gerado é idêntico ao enviado
    if (cnpj === cnpj_original) {
        return true;
    }

    // Retorna falso por padrão
    return false;

} // valida_cnpj

/*
 valida_cpf_cnpj

 Valida o CPF ou CNPJ

 @access public
 @return bool true para válido, false para inválido
*/
function valida_cpf_cnpj(valor) {

    // Verifica se é CPF ou CNPJ
    var valida = verifica_cpf_cnpj(valor);

    // Garante que o valor é uma string
    valor = valor.toString();

    // Remove caracteres inválidos do valor
    valor = valor.replace(/[^0-9]/g, '');


    // Valida CPF
    if (valida === 'CPF') {
        // Retorna true para cpf válido
        return valida_cpf(valor);
    }

    // Valida CNPJ
    else if (valida === 'CNPJ') {
        // Retorna true para CNPJ válido
        return valida_cnpj(valor);
    }

    // Não retorna nada
    else {
        return false;
    }

} // valida_cpf_cnpj

/*
 formata_cpf_cnpj

 Formata um CPF ou CNPJ

 @access public
 @return string CPF ou CNPJ formatado
*/
function formata_cpf_cnpj(valor) {

    // O valor formatado
    var formatado = false;

    // Verifica se é CPF ou CNPJ
    var valida = verifica_cpf_cnpj(valor);

    // Garante que o valor é uma string
    valor = valor.toString();

    // Remove caracteres inválidos do valor
    valor = valor.replace(/[^0-9]/g, '');


    // Valida CPF
    if (valida === 'CPF') {

        // Verifica se o CPF é válido
        if (valida_cpf(valor)) {

            // Formata o CPF ###.###.###-##
            formatado = valor.substr(0, 3) + '.';
            formatado += valor.substr(3, 3) + '.';
            formatado += valor.substr(6, 3) + '-';
            formatado += valor.substr(9, 2) + '';

        }

    }

    // Valida CNPJ
    else if (valida === 'CNPJ') {

        // Verifica se o CNPJ é válido
        if (valida_cnpj(valor)) {

            // Formata o CNPJ ##.###.###/####-##
            formatado = valor.substr(0, 2) + '.';
            formatado += valor.substr(2, 3) + '.';
            formatado += valor.substr(5, 3) + '/';
            formatado += valor.substr(8, 4) + '-';
            formatado += valor.substr(12, 14) + '';

        }

    }

    // Retorna o valor
    return formatado;

} // formata_cpf_cnpj

function cpfCnpj(v) {

    //Remove tudo o que não é dígito
    v = v.replace(/\D/g, "");

    if (v.length <= 11) { //CPF

        //Coloca um ponto entre o terceiro e o quarto dígitos
        v = v.replace(/(\d{3})(\d)/, "$1.$2");

        //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
        v = v.replace(/(\d{3})(\d)/, "$1.$2");

        //Coloca um hífen entre o terceiro e o quarto dígitos
        v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    } else { //CNPJ

        //Coloca ponto entre o segundo e o terceiro dígitos
        v = v.replace(/^(\d{2})(\d)/, "$1.$2");

        //Coloca ponto entre o quinto e o sexto dígitos
        v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");

        //Coloca uma barra entre o oitavo e o nono dígitos
        v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");

        //Coloca um hífen depois do bloco de quatro dígitos
        v = v.replace(/(\d{4})(\d)/, "$1-$2");

    }

    return v;

}


function get_registry_ofice(date, busca) {

    var resultado = $(".calendario-popup.resultado");
    var valor = date;
    mesDic2 = {
        "01": "Janeiro",
        "02": "Fevereiro",
        "03": "Março",
        "04": "Abril",
        "05": "Maio",
        "06": "Junho",
        "07": "Julho",
        "08": "Agosto",
        "09": "Setembro",
        "10": "Outubro",
        "11": "Novembro",
        "12": "Dezembro"
    };
    elemento = valor.split("/");
    intAno = parseInt(elemento[2]);
    intDia = parseInt(elemento[0]);
    ano = elemento[2];
    mes = elemento[1];
    mesNome = mesDic2[mes];
    dia = elemento[0];
    resultado.find('.cabecalho h4').text(dia + "/" + mes + "/" + ano);
    resultado.find('.acervo a').data("date", valor);
    resultado.find('.acervo').show();

    var data = new Date();
    var dataImplantacao = new Date();
    dataImplantacao.setUTCFullYear(2018, 11, 19);
    data.setUTCFullYear(intAno, mes, intDia);

    if (ano < 2004 && (busca === null || busca === undefined)) {
        resultado.find('.documentos').hide();
        resultado.find('.acervo').addClass('full');
        resultado.fadeIn("fast");
    } else if (busca === null || busca === undefined) {
        var urlData = "&dia=" + ano + mes + dia;
        /* Ajax */
        $.ajax({
            type: "GET",
            url: "https://ws.cepe.com.br/publicar/dows.php",
            data: urlData,
            success: function (data) {
                result = data.split("&");
                html = "";
                resultado.find('.documentos').show();
                resultado.find('.acervo').removeClass('full');

                if (result != "") {
                    for (i = 0; i < result.length - 1; i++) {
                        caderno = result[i].split("-")[1];
                        html += '<li><a id="a' + caderno + '" href="http://200.238.105.211/cadernos/' + ano + '/' + ano + mes + dia + '/' + result[i] + '/' + caderno + '(' + ano + mes + dia + ').pdf"' + ' target="__blank">' + caderno + '<i></i></a></li>';
                    }
                } else {
                    html = "<p style=\"text-decoration: underline;\">Não há jornais para esta data.</p>";
                    resultado.find('.acervo').hide();
                    resultado.find('.documentos').show();
                }

                resultado.find('.documentos ul').html(html);
            }
        });
        resultado.fadeIn("fast");
    }
    if (busca !== 1) {
        return 2;
    }

}
