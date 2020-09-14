// Clear forms
(function($){

  $.fn.clearDefault = function(){
    return this.each(function(){
      var defaultValue = $(this).val();
      $(this).focus(function(){
        if ($(this).val() === defaultValue) {
          $(this).val('');
        }
      });
      $(this).blur(function(){
        if ($(this).val() === '') {
          $(this).val(defaultValue);
        }
      });
    });
  };
})(jQuery);

(function () {

  if ($('.lb-cadastro').length > 0) {
    setTimeout(function () {
      $('.lb-cadastro').addClass('open');
      $('.lb-cadastro-bg').addClass('open');
      $('.lb-cadastro .lb-close, .lb-cadastro-bg').click(function () {
        $('.lb-cadastro').removeClass('open');
        $('.lb-cadastro-bg').removeClass('open');
      });
    }, 3000);
  }


// btn mobile
var menu = $( ".header-mobile .menu" );
var submenu = $( ".header-mobile .menu" ).find('.submenu');

$('.btn-mobile').click(function(){
  $(this).toggleClass('open');
  menu.toggleClass('open');
  menu.slideToggle();
  menu.find('ul').removeClass('open');
  $('.scroll').jScrollPane();
});

menu.find('.submenu').click(function(){
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
$(".custom-select").each(function() {
  var classes = $(this).attr("class"),
  id      = $(this).attr("id"),
  name    = $(this).attr("name");
  var template =  '<div class="' + classes + '">';
  template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
  template += '<div class="custom-options">';
  $(this).find("option").each(function() {
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
$(".custom-option:first-of-type").hover(function() {
  $(this).parents(".custom-options").addClass("option-hover");
}, function() {
  $(this).parents(".custom-options").removeClass("option-hover");
});
$(".custom-select-trigger").on("click", function() {
  $('html').one('click',function() {
    $(".custom-select").removeClass("opened");
  });
  $(this).parents(".custom-select").toggleClass("opened");
  event.stopPropagation();
});

$(".custom-option").on("click", function() {
  $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
  $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
  $(this).addClass("selection");
  $(this).parents(".custom-select").removeClass("opened");
  $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
});

//parallax
function parallax() {
  $('.parallax').each(function() {
    var $pos;
    var $obj = $(this);
    if ($(window).width() > 900) {
      $(window).scroll(function() {
        var yPos = -($(window).scrollTop() / $obj.data('parallax-speed'));
        var bgpos = '50% ' + yPos + 'px';
        $obj.css('background-position', bgpos);
      });
    } else {
      $obj.css('background-position', 0);
      $(window).scroll(function() {
        $obj.css('background-position', 0);
      });
    }
  });
}
parallax();

//carousel calendario
var $owl = $('.js-calendario.owl-carousel');

$owl.children().each( function( index ) {
  $(this).attr( 'data-position', index );
});

$owl.owlCarousel({
  center: true,
  items: 7,
  stagePadding: 0,
  margin: 0,
  autoHeight:true,
  responsive : {
    0 : {
      items: 3
    },
    480 : {
      items: 3
    },
    700 : {
      items: 3
    },
    701 : {
      items: 5
    },
    1049 : {
      items: 5
    },
    1050 : {
      items: 7
    }
  }
});

$(document).on('click', '.owl-item>div', function() {
  $owl.trigger('to.owl.carousel', $(this).data( 'position' ) );
});

$('.container-calendario .proxima').click(function() {
  $owl.trigger('next.owl.carousel');
  return false
});
$('.container-calendario .anterior').click(function() {
  $owl.trigger('prev.owl.carousel');
  return false
});

$owl.find(".owl-item a").click(function(event) {
  event.preventDefault();
});

//slider clientes
var $owlClientes = $('.js-clientes.owl-carousel');

$owlClientes.children().each( function( index ) {
  $(this).attr( 'data-position', index );
});

var d = new Date();
var month = d.getMonth()+1;
var day = d.getDate();
var output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();
$("#mydate").val(output);

$owlClientes.owlCarousel({
  loop: true,
  items: 4,
  stagePadding: 0,
  margin:0,
  responsive : {
    0 : {
      items:2,
    },
    768 : {
      items:3,
    },
    1024 : {
      items:4
    }
  }
});

$owl.trigger('to.owl.carousel', day-1);

$('.clientes .proxima').click(function() {
  $owlClientes.trigger('next.owl.carousel');
  return false
});
$('.clientes .anterior').click(function() {
  $owlClientes.trigger('prev.owl.carousel');
  return false
});

$owl.on('change.owl.carousel', function(event) {
  day = (typeof event.property.value === 'number') ? event.property.value + 1 : 1;
  day = day < 10 ? '0' + day : day;
});

//accordion
$(".lista-faq .cabecalho").click(function() {

  $('.cabecalho').removeClass('aberto');
  $(this).addClass('aberto');

  if($(this).next("div").is(":visible")){
    $(this).next("div").slideUp(300);
    $(this).removeClass('aberto');
  } else {
    $(".lista-faq .conteudo-faq").slideUp(300);
    $(this).next("div").slideToggle(300);
  }
});

//calendário popup
$("#calendario").ionCalendar({
  lang: "pt-br",
  years: "1936-2018",
  format: "L",
  onClick: function(date){
    $("#mydate").val(date);
  }
});

$($('#mes').parent().find('.custom-option').add($('#ano').parent().find('.custom-option'))).click(function(){
  $('.js-calendario').html('<div class="loading">Carrengando...</div>');
  $( ".acoes-calendario .botao-calendario" ).addClass('disabled');

  $.get($('#form-calendario').attr('action') + 'get_calendar', {'year':$('#ano').parent().find('.custom-option.selection').data('value'), 'month':$('#mes').parent().find('.custom-option.selection').data('value')}, function(html){
    $('.js-calendario').html(html);
    $( ".acoes-calendario .botao-calendario" ).removeClass('disabled');

    var $owl = $('.js-calendario.owl-carousel');

    $owl.trigger('destroy.owl.carousel');

    $owl.children().each( function( index ) {
      $(this).attr( 'data-position', index );
    });

    $owl.owlCarousel({
      center: true,
      items: 7,
      stagePadding: 0,
      margin: 0,
      autoHeight:true,
      responsive : {
        0 : {
          items: 3
        },
        480 : {
          items: 3
        },
        700 : {
          items: 3
        },
        701 : {
          items: 5
        },
        1049 : {
          items: 5
        },
        1050 : {
          items: 7
        }
      }
    });

    $(document).on('click', '.owl-item>div', function(e) {
      e.preventDefault();
      $owl.trigger('to.owl.carousel', $(this).data( 'position' ) );
    });
  });
});


//modal calendário
function calendarioPopUp(){

  var popup         = $(".calendario-popup");
  var calendario    = $(".calendario");
  var buscaAvancada = $(".calendario-popup.busca");
  var resultado     = $(".calendario-popup.resultado");

//visualizar calendário slider
$( ".acoes-calendario .botao-calendario" ).click(function(e) {
  e.preventDefault();

  var str = "" + day;
  var pad = "00";
  var new_day = pad.substring(0, pad.length - str.length) + str;

  var calendar_date =  new_day + '/' + $('#mes').parent().find('.custom-option.selection').data('value') + '/' + $('#ano').parent().find('.custom-option.selection').data('value');
  get_registry_ofice(calendar_date);
});

resultado.find('.acervo a').click(function(e){
  e.preventDefault();
  proceedDocpro($(this).data('date'));
});

//visualizar calendário
$( ".acoes-calendario .visualizar-calendario" ).click(function(e) {
  e.preventDefault();
  calendario.fadeIn("fast");
});

//busca Avançada
$( ".acoes-calendario .busca-avancada" ).click(function(e) {
  e.preventDefault();
  buscaAvancada.fadeIn("fast");
});

calendario.find('.visualizar').click(function(e) {
  e.preventDefault();
  get_registry_ofice($("#mydate").val());
});

buscaAvancada.find('.visualizar').click(function(e) {
  e.preventDefault();
  proceedDocproPesquisa();
});

//container popup
popup.each( function(){
  $(this).find('.fechar').click(function() {
    $(this).parent().parent().parent().fadeOut("fast");
  });
});

}

calendarioPopUp();



$('.licitacoes-popup').click(function(e){
  e.preventDefault();
  $('.popup').addClass('open');
});

$('.close-popup').click(function(){
  $('.popup').removeClass('open');
});

// ocultando selects por radio buttom
$('#campo-radio1').click(function() {
  $('#anos').show();
  $('#decadas').hide();
});
$('#campo-radio2').click(function() {
  $('#anos').hide();
  $('#decadas').show();
});
$('#campo-radio3').click(function() {
  $('#anos').hide();
  $('#decadas').hide();
});

//mascara de telefone
$("input[name='telefone'], input[name='celular']").focusout(function() {
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
    nome: { required: true },
    email: { required: true, email: true },
    telefone: { required: true }
  },
  messages: {
    nome: { required: 'Preencha o campo nome' },
    email: { required: 'Informe o seu email', email: 'Ops, informe um email válido' },
    telefone: { required: 'Preencha o campo telefone' }
  },
  errorPlacement: function(error, element) {
    $('.contato .msg.error').fadeIn('fast');
  },
  submitHandler: function( form ){

    var dados = $( form ).serialize();

    $.ajax({
      type: "POST",
      url: $( form ).attr('action'),
      data: dados,
      dataType: 'json',
      complete: function(){
        $('#form-contato input[type="submit"]').removeAttr('disabled');
      },
      beforeSend: function(){
        $('#form-contato input[type="submit"]').attr('disabled', 'disabled');
        $('.contato .msg.error').fadeOut('fast');
        $('.contato .msg.success').fadeOut('fast');
      },
      success: function( data ){
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
$(".mask-cpf").mask("999.999.999-99", {placeholder:" "});

function check_cpf(strCPF) {
  var Soma;
  var Resto;
  Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

  if ((Resto == 10) || (Resto == 11))  Resto = 0;
  if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
  for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

  if ((Resto == 10) || (Resto == 11))  Resto = 0;
  if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
  return true;
}

function checkEmail(email) {
  var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
  var check=/@[\w\-]+\./;
  var checkend=/\.[a-zA-Z]{2,3}$/;
    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
    else {return true;}
}

// CERTIFICADO DIGITAL
// PAGES
$('.js-page').click(function(){
  if(!$(this).is('.disabled')){
    var  page = $(this).data('page');
    $('.pcd-submenu').find('.js-page').removeClass('active');
    $(".pcd-submenu [data-page='"+page+"']").addClass('active');
    $('.cpd-page').not(page).slideUp(600);
    $(page).slideDown(800);
  }
  return false;
});

$('.js-agendar').click(function(){
  var page = $('.pcd-item.agendamento');
  page.find('.pcd-content').slideDown();
  page.addClass('item-active');
});

$('.pcd-form.form-login .form-text').focus(function() {
  $('.pcd-form.form-login .form-text').addClass('required');
  $('.pcd-form.form-cadastro .form-text').removeClass('required');
});
$('.pcd-form.form-cadastro .form-text').focus(function() {
  $('.pcd-form.form-cadastro .form-text').addClass('required');
  $('.pcd-form.form-login .form-text').removeClass('required');
});

// STEPS
function nextStep(id,order){
  $('.pcd-item', $(id)).each(function(index){
    if (order == index) {
      $(this).find('.pcd-content').slideDown();
      $(this).addClass('item-active');
      return false;
    }
  });
}

// AGENDAMENTO
$('.js-dados-emissao').click(function() {
  var elem   = $('#cpf-agend'),
  number = elem.val();

  number = number.replace(".", "");
  number = number.replace(".", "");
  number = number.replace("-", "");

  elem.parent().removeClass('error');

  if(check_cpf(number)){
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

$('.js-finalizar-emissao').click(function(){
  if ($('#mydate').val() && $('.pcd-agend-date .radios input[name=horario]:checked').val() && $('.pcd-agend-date .checkbox input[name="terms"]:checked').val()) {
    $(this).next().slideUp();
    $('.js-form-agend').submit();
  } else{
    $(this).next().slideDown();
  }
  return false;
});

// COMPRA CERTIFICADO

$('.js-botao-padrao').click(function() {
  var obj = $(this);
  var tipo = obj.parent();
  tipo.addClass('active');
  tipo.find('.js-botao-padrao').removeClass('checked');
  obj.addClass('checked');
  nextStep('#steps-compra', 1);
});
$('.js-checkbox').click(function() {
  var obj = $(this);
  var produto = obj.parent().parent().parent();
  produto.find('.pcd-produto').removeClass('active');
  produto.find('.checkbox').removeClass('checked');
  obj.addClass('checked');
  obj.parent().parent().addClass('active');
  produto.addClass('produtos-checked');
  if(obj.hasClass('js-checkbox-validade')){
    nextStep('#steps-compra', 3);
  }else{
    nextStep('#steps-compra', 2);
  }
});
$('.desconto .js-next').click(function functionName() {
  nextStep('#steps-compra', 4);
});

// INTERNA FILTRO
$('.filtro-select .filtro-option').click(function(e){
  e.preventDefault();
  var filtro = $(this).data("filter");

  $('.filtro-select .filtro-option').removeClass('active');
  $(this).addClass('active');
  $('.filtro-content .filtro-item').removeClass('open');
  $('#filtro-' + filtro).addClass('open');
});

$('.advanced-radio input[type=radio][name=advanced]').change(function(){
  var value  = $(this).val(),
  select = $('#advanced-' + value);

  $('.form-advanced .form-field-select').removeClass('required');
  $('.form-advanced .form-field-select .form-select').removeClass('required');

  select.addClass('required');
  select.parent().addClass('required');

});

$(".acordeon-click", $(".acordeon")).click(function(){
  if (!$(this).hasClass("active")){
    $(".acordeon-click").removeClass("active");
    $(".acordeon-inner").slideUp();
  }
  $(this).toggleClass("active");
  $(this).next(".acordeon-inner").slideToggle();
});

// ocultando selects por radio buttom

$('.anexos .anexo').click(function(event){

  var id = $(this).attr("id");
  $('.item-popup').removeClass('popup-active');
  $('.licitacoes .popup').addClass('open');
  $('.form-cpf').addClass('popup-active');

  $('.form-cpf').submit(function(){
    var form  = $(this),
        error = false,
        cpf_cnpj = false,
        submitText = form.find('.form-submit').data('text');

    form.find('.form-field').removeClass('error');
    form.find('.msg').slideUp(300);

    form.find('.required').each(function(i, e){
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
    } else{
      cpf_cnpj = $("#cpf-cnpj").val();
      $.ajax({
        type: 'post',
        url: $(form).attr('action'),
        dataType: 'json',
        data: {
          'cpf-cnpj': cpf_cnpj,
          'id_download': id
        }, beforeSend : function(){
          form.find('.form-submit').val('Enviando...');
          form.find('.form-submit').prop('disabled', true);
          form.find('.msg-error').slideUp();
        }, complete : function(){
          form.get(0).reset();
          form.find('.form-text').text("");
          form.find('.form-field').removeClass('form-focus');
          form.find('.form-field').removeClass('error');
          form.find('.form-submit').val(submitText);
          form.find('.form-submit').prop('disabled', false);
        }, success: function(resp){
          if(resp.redirect) {
            $('.licitacoes .popup').removeClass('open');
            location.reload();
          } else if(resp.register){
            $('#popup-register').addClass('popup-active');
            $('#popup-log').removeClass('popup-active');
            $('.form-licitacao').submit(function(e){
              e.preventDefault();
              var form  = $(this),
                  error = false,
                  submitText = form.find('.form-submit').data('text');

              form.find('.form-field').removeClass('error');
              form.find('.msg').slideUp(300);

              form.find('.required').each(function(i, e){
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
                  beforeSend : function(){
                  form.find('.form-submit').val('Enviando...');
                  form.find('.form-submit').prop('disabled', true);
                  form.find('.msg-error').slideUp(); },
                  complete : function(){
                  form.get(0).reset();
                  form.find('.form-text').text("");
                  form.find('.form-field').removeClass('form-focus');
                  form.find('.form-field').removeClass('error');
                  form.find('.form-submit').val(submitText);
                  form.find('.form-submit').prop('disabled', false); },
                  success: function(resp){
                    if(resp.success) {
                      $('#register-success').addClass('popup-active');
                      $('#popup-register').removeClass('popup-active');
                    } else{
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
})();


function proceedDocpro(date){
  valor = date;
  mesDic2 = {"01":"Janeiro", "02":"Fevereiro", "03":"Março", "04":"Abril", "05":"Maio", "06":"Junho", "07":"Julho", "08":"Agosto", "09":"Setembro", "10":"Outubro", "11":"Novembro", "12":"Dezembro"};
  elemento = valor.split("/");
  intAno = parseInt(elemento[2]);
  intDia = parseInt(elemento[0]);
  ano = elemento[2];
  mes = elemento[1];
  mesNome = mesDic2[mes];
  dia = elemento[0];

  if (intAno >= 2014) {
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib='+ano+mes+dia+'&pasta='+mesNome+'\\Dia%20'+dia,'_blank');
  } else if (intAno < 2004){
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=DO_'+ano+mes+'&pasta=Dia%20'+dia,'_blank');
  }else{
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib='+ano+'&pasta='+mesNome+'\\Dia%20'+dia,'_blank');
  }

  return false;
}

function proceedDocproPesquisa(){
  valor = $('#palavrachave').val();
  if ($('input:checked').val() == 'ano') {
    var ano = $('#anos').val();
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib='+ano+'&pesq='+valor,'_blank');
  } else if($('input:checked').val() == 'decada') {
    var dec = $('#decadas').val();
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=D'+dec+'&pesq='+valor,'_blank');
  }else if ($('input:checked').val() == 'todos'){
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=FULL&pesq='+valor,'_blank');
  }else{
    window.open('http://200.238.101.22/docreader/docreader.aspx?bib=FULL&pesq='+valor,'_blank');
  }

  return false;
}


function get_registry_ofice(date) {
  var resultado = $(".calendario-popup.resultado");
  var valor = date;
  mesDic2 = {"01":"Janeiro", "02":"Fevereiro", "03":"Março", "04":"Abril", "05":"Maio", "06":"Junho", "07":"Julho", "08":"Agosto", "09":"Setembro", "10":"Outubro", "11":"Novembro", "12":"Dezembro"};
  elemento = valor.split("/");
  intAno = parseInt(elemento[2]);
  intDia = parseInt(elemento[0]);
  ano = elemento[2];
  mes = elemento[1];
  mesNome = mesDic2[mes];
  dia = elemento[0];
  resultado.find('.cabecalho h4').text(dia+"/"+mes+"/"+ano);
  resultado.find('.acervo a').data("date", valor);
  resultado.find('.acervo').show();

  if (ano < 2004) {
    resultado.find('.documentos').hide();
    resultado.find('.acervo').addClass('full');
  } else {
    var urlData = "&dia=" + ano+mes+dia;
    /* Ajax */
    $.ajax({
      type: "GET",
      url: "https://ws.cepe.com.br/publicar/dows.php",
      data: urlData,
      success: function(data) {
        result = data.split("&");
        html = "";
        resultado.find('.documentos').show();
        resultado.find('.acervo').removeClass('full');

        if (result != "") {
          for (i = 0; i < result.length - 1 ; i++){
            caderno = result[i].split("-")[1];
            html += '<li><a id="a'+caderno+'" href="http://200.238.105.211/cadernos/'+ano+'/'+ano+mes+dia+'/'+result[i]+'/'+caderno+'('+ano+mes+dia+').pdf"'+' target="__blank">'+caderno+'<i></i></a></li>';
          }
        } else {
          html = "<p style=\"text-decoration: underline;\">Não há jornais para esta data.</p>";
          resultado.find('.acervo').hide();
          resultado.find('.documentos').show();
        }

        resultado.find('.documentos ul').html(html);
      }
    });
  }

  resultado.fadeIn("fast");
}
