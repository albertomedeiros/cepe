  $('.form-agendamento').submit(function(e){
    e.preventDefault();
    var form = $(this);
    var error = false;
    var submitText = form.find('.form-submit').data('text');

    form.find('.form-field').removeClass('error');
    
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
      form.find('.msg-error').slideDown(600);
    } else{
      var formData  = new FormData(this);

      $('input' , $('#form-agendar')).each(function(i){
        if($(this).is(':checked')){
          formData.append($(this).prop('name') , $(this).val());
        }
      });

      formData.append('json', true);

      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend : function(){
          form.find('.form-submit').val('Enviando...');
          form.find('.form-submit').prop('disabled', true);
          form.find('.msg-error').slideUp(800);
        },
        complete : function(){
          form.get(0).reset();
          form.find('.form-text').text("");
          form.find('.form-field').removeClass('form-focus');
          form.find('.form-field').removeClass('error');
          form.find('.form-submit').val(submitText);
          form.find('.form-submit').prop('disabled', false);
        },
        success: function(resp){

        if(resp.success){
          $(".pcd-submenu [data-page='.page-comprar']").addClass('disabled');
          $('.pcd-submenu').find('.js-page').removeClass('active');
          if(form.is('#login-agendar')){

            var email = $('input[type="email"]', form).val();
            $('#set-email-login').html(email);

            $('.cpd-page').not('.page-agendamento').slideUp(600);
            $('.page-agendamento').slideDown(800);

          } else if(form.is('#cadastro-agendar')){

            $('.cpd-page').not('.page-cadastro').slideUp(600);
            $('.page-cadastro').slideDown(800);

          } else if(form.is('#form-cadastro')){

            var email = $('input[type="email"]', form).val();
            $('#set-email-login').html(email);

            $('.cpd-page').not('.page-agendamento').slideUp(600);
            $('.page-agendamento').slideDown(800);
          }
        }
        else {
          form.find('.msg-error').html('Ocorreu um erro inesperado. Tente novamente mais tarde.').slideDown(600);
        }
        }
      });
    }
    return false;
  });


// FORM DE AGENDAMENTO

$('.js-form-agend').submit(function(){
  var form = $(this),
  submitText = $('.form-submit', form).data('text');
  
  $('input', form).parent().removeClass('error');

  if (!(
    $('input#mydate', form).val() && 
    $('input[name=horario]:checked', form).val() && 
    $('input[name="terms"]:checked', form).val() &&
    $('input#cpf-agend', form).val()) ) {
    
    $('.msg-error', form).slideDown();
  if (!($('input#cpf-agend', form).val())){
    $('input', form).parent().addClass('error');
  }
  
} else{

  $.ajax({
    type: "POST",
    url: $(form).attr('action'),
    data: $(form).serialize(),
    timeout: 3000,
    dataType: 'json',
    beforeSend: function() {
      $('.msg-alert', form).slideUp();
      $('input', form).parent().removeClass('error');
      $('.form-submit', form).val('Carregando...');
      $('.form-submit', form).prop('disabled', true);
    },
    complete: function(){
      $('.form-submit', form).val(submitText);
      $('.form-submit', form).prop('disabled', false);
    },
    success: function(resp) {
      if(resp.success){
        var produto = 'Certificado digital A3 e-CPF c/ token (36 meses) (ME, EPP, EI, MEI)';

        $(".conclusao-produto").html(produto);
        $("#emissao-data").html($('input#mydate', form).val());
        $("#emissao-horario").html($('input[name=horario]:checked', form).val());

        nextStep('#steps-agend', 2);

      } else{
        $('.msg-error', form).slideDown();
      }
    },
    error: function(){
      $('.msg-danger', form).slideDown();
    }
  });

}
return false;
});