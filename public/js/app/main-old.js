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

    // calendário diários
    var diarioDatePicker = $('#diario-date-picker');
    var textNumeroEdicao = $('#textNumeroEdicao');
    diarioDatePicker.datepicker({dateFormat: 'dd/mm/yy'});

    if (!diarioDatePicker.val()) {
        diarioDatePicker.val(new Date().toLocaleDateString("pt-BR"));
    }

    diarioDatePicker.change(function () {
        getCadernos(diarioDatePicker.val());
    });

    textNumeroEdicao.change(function () {
        diarioDatePicker.val(textNumeroEdicao.val());
        getCadernos(textNumeroEdicao.val());
    });

    //busca avançada
    var botaoBuscaAvancada = $('#botaoBuscaAvancada');
    var botaoLimparBuscaAvancada = $('#botaoLimparBuscaAvancada');
    var buscaDataFinalDate = $('#buscaDataFinal');
    var buscaDataInicialDate = $('#buscaDataInicial');

    buscaDataFinalDate.datepicker({dateFormat: 'dd/mm/yy'});
    buscaDataInicialDate.datepicker({dateFormat: 'dd/mm/yy'});

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

    $('#textNumeroEdicao').datepicker({dateFormat: 'dd/mm/yy'});

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

    getCadernos(diarioDatePicker.val());

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

        resultado.find('.acervo #html').click(function (e) {
            e.preventDefault();
            proceedDOWeb($(this).data('date'));
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
            var str = "" + day;
            var pad = "00";
            var new_day = pad.substring(0, pad.length - str.length) + str;

            var calendar_date = new_day + '/' + $('#mes').parent().find('.custom-option.selection').data('value') + '/' + $('#ano').parent().find('.custom-option.selection').data('value');
            var busca = 0;

            busca = get_registry_ofice(calendar_date, busca);
            // get_registry_ofice($("#mydate").val(), busca);
            if (busca === 2) {
                proceedDocproPesquisa();
            }
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

// CERTIFICADO DIGITAL
// PAGES
    $('.js-page').click(function () {
        var page = $(this).data('page');
        $('.pcd-submenu').find('.js-page').removeClass('active');
        $(".pcd-submenu [data-page='" + page + "']").addClass('active');
        $('.cpd-page').not(page).slideUp(600);
        $(page).slideDown(800);
        return false;
    });

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
        var elemento1 = dataFinal.split("/");
        var ano1 = elemento1[2];
        var mes1 = elemento1[1];
        var dia1 = elemento1[0];
        var dataFim = new Date(ano1, mes1 - 1, dia1);

        if (dataInicio < dataFim) {
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
    var ano = elemento[2];
    var mes = elemento[1];
    var dia = elemento[0];
    window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-diario?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
}

function visualizeJornal() {
    var data = $("#diario-date-picker").val();
    var elemento = data.split("/");
    var ano = elemento[2];
    var mes = elemento[1];
    var dia = elemento[0];
    window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-jornal?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
}

function buscarPorNumeroEdicao() {
    var numeroEdicao = $('#textNumeroEdicao').val();
    var hoje = new Date();
    var dataImplantacao = new Date(2004, 0, 1);
    var elemento = numeroEdicao.split("/");
    var ano = elemento[2];
    var mes = elemento[1];
    var dia = elemento[0];
    var dataEdicao = new Date(ano, mes - 1, dia);
    if (numeroEdicao) {
        if (hoje >= dataEdicao) {
            if (dataEdicao >= dataImplantacao) {
                window.open('https://diariooficial.cepe.com.br/diariooficialweb/#/visualizar-diario?dataPublicacao=' + dia + '-' + mes + '-' + ano + '&diario=MQ==', '_blank');
            } else {
                alertaError("A data não pode ser anterior à 2004");
            }
        } else {
            alertaError("A data não pode ser posterior ao dia de hoje!");
        }
    } else {
        alertaError("A data da edição deve estar preenchida.");
    }
}

function getCadernos(date) {

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
            }
            $('#cadernos-front').html(html);
            $('#dataSelecionada').html(date);
        }
    });
}

function changeMiniatura(dateArray) {
    var data = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
    $('#img-miniatura-jornal').html('<img src="https://diariooficial.cepe.com.br/miniaturas/' + data + '.png" class="diario-thumb-image" style="max-width: 100%"/><div class="diario-thumb-middle"><div class="row"><div class="col-md-12"><span class="diario-thumb-texto-visualizao">Escolha o tipo de visualização:</span><br><br></div></div><div class="row"><div class="col-md-12"><a id="botaoVisualizacaoJornal" style="cursor: pointer" onclick="visualizeJornal()" class="diario-thumb-left-button botao-padrao2">Impressa</a></div></div><div class="row"><div class="col-md-12"><a style="cursor: pointer" id="botaoVisualizacaoHtml" onclick="visualizeHTML()" class="diario-thumb-left-button botao-padrao2">Eletrônica</a></div></div></div>');
}

function removeMiniatura() {
    $('#img-miniatura-jornal').html('<img src="https://diariooficial.cepe.com.br/miniaturas/imagemindisponivel.png" style="max-width: 100%"/><h3>Não houve publicação neste dia</h3>');
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
