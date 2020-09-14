// $.validator.addMethod("cpf", function(value, element) {
//     value = $.trim(value);

//     value = value.replace('.','');
//     value = value.replace('.','');
//     cpf = value.replace('-','');
//     while(cpf.length < 11) cpf = "0"+ cpf;
//     var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
//     var a = [];
//     var b = new Number;
//     var c = 11;
//     for (i=0; i<11; i++){
//         a[i] = cpf.charAt(i);
//         if (i < 9) b += (a[i] * --c);
//     }
//     if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
//     b = 0;
//     c = 11;
//     for (y=0; y<10; y++) b += (a[y] * c--);
//     if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

//     var retorno = true;
//     if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

//     return this.optional(element) || retorno;

// }, "Informe um CPF válido");

 $.validator.addMethod("extension", function(a, b, c) {
     var c = "string" === typeof c ? c.replace(/,/g, "|") : "png|jpe?g|gif";
     return this.optional(b) || a.match(new RegExp("\\.(" + c + ")$", "i"));
 }, $.validator.format("Please enter a value with a valid extension."));

$(function () {
    "use strict";

    $("input[name=subscription\\[cpf\\]]").on("blur", function(e){
        var cpf = $(this).val();
        var genre = $("[name=subscription\\[genre\\]]").val();
        //if ( $("input[name=subscription\\[cpf\\]]").valid() ) {
            // checkCpf(cpf, genre, function() {

            // }, function() {
            //     $("#form-cadastro-cultural")[0].reset();
            // });
        //}
    });

    function checkCpf(cpf, genre, proceed, cancel){
        $.ajax({
            type: "post",
            url: __base_url+"premio-cepe/cpf",
            data: "cpf="+cpf+"&genre="+genre,
            dataType: "json",
            async: false,
            success: function(resp){
                if(!resp.success) {
                    var go_on = confirm("Já existe uma inscrição desse CPF para esse gênero. Submeter outra inscrição cancelará a anterior. Deseja continuar assim mesmo?");
                    if(go_on) {
                        proceed();
                    } else {
                        cancel();
                    }
                }
            }
        });
    }

    $("#step_prev").click(function () {
        $("#form-step2").hide();
        $("#form-step1").show();
    });

    //$("input[name='subscription[cpf]']").mask("999.999.999-99");
    // $("input[name='subscription[rg]']").mask("9.999.999");

    var validator = $('#form-cadastro-cultural').validate({
        rules: {
            "subscription[name]": { required: true },
            "subscription[pseudonym]": { required: true },
            "subscription[work_title]": { required: true },
            "subscription[cpf]": { /*cpf: true,*/ required: true },
            "subscription[rg]": { required: true },
            "subscription[civil_status]": { required: true },
            "subscription[profession]": { required: true },
            "subscription[address]": { required: true },
            "subscription[complement]": { required: true },
            "subscription[zipcode]": { required: true },
            "subscription[country]": { required: true },
            "subscription[nationality]": { required: true },
            "subscription[email]": { required: true },
            "subscription[category]": { required: true },
            "subscription[rg_file]": { required: true, extension: 'pdf' },
            "subscription[composition_file]": { required: true, extension: 'pdf' },
            "subscription[cpf_file]": { extension: 'pdf' },
            "subscription[proof_of_address_file]": { extension: 'pdf' },
        },
        messages: {
            "subscription[name]": { required: 'campo obrigatório' },
            "subscription[pseudonym]": { required: 'campo obrigatório' },
            "subscription[work_title]": { required: 'campo obrigatório' },
            "subscription[cpf]": { cpf: 'CPF Inválido', required: 'campo obrigatório' },
            "subscription[rg]": { required: 'campo obrigatório' },
            "subscription[civil_status]": { required: 'campo obrigatório' },
            "subscription[profession]": { required: 'campo obrigatório' },
            "subscription[address]": { required: true },
            "subscription[complement]": { required: true },
            "subscription[zipcode]": { required: 'campo obrigatório' },
            "subscription[country]": { required: 'campo obrigatório' },
            "subscription[nationality]": { required: 'campo obrigatório' },
            "subscription[email]": { required: 'campo obrigatório' },
            "subscription[category]": { required: 'campo obrigatório' },
            "subscription[rg_file]": { required: 'campo obrigatório' },
            "subscription[composition_file]": { required: 'campo obrigatório' },
            "subscription[cpf_file]": {  },
            "subscription[proof_of_address_file]": {  },
        },
        errorPlacement: function(error, element) {
          $('.contato .msg.error').fadeIn('fast');
        }
    });

    $("#step_next").click(function () {
        if(
            $('[name="subscription\[name\]"]').valid() &&
            $('[name="subscription\[pseudonym\]"]').valid() &&
            $('[name="subscription\[work_title\]"]').valid() &&
            $('[name="subscription\[cpf\]"]').valid() &&
            $('[name="subscription\[rg\]"]').valid() &&
            $('[name="subscription\[civil_status\]"]').valid() &&
            $('[name="subscription\[profession\]"]').valid() &&
            $('[name="subscription\[address\]"]').valid() &&
            $('[name="subscription\[complement\]"]').valid() &&
            $('[name="subscription\[zipcode\]"]').valid() &&
            $('[name="subscription\[country\]"]').valid() &&
            $('[name="subscription\[neighborhood\]"]').valid() &&
            $('[name="subscription\[city\]"]').valid() &&
            $('[name="subscription\[state\]"]').valid() &&
            $('[name="subscription\[nationality\]"]').valid() &&
            $('[name="subscription\[email\]"]').valid() &&
            $('[name="subscription\[category\]"]').valid()
        ) {
            $("#form-step1").hide();
            $("#form-step2").show();
        } else {
           // if (!$('[name="subscription\[cpf\]"]').valid()) {
           //     alert('CPF inválido.');
           // }  else {
                alert('Preencha os campos obrigatórios');
           // }
        }
    });

    $('#form-cadastro-cultural').unbind( "submit" ).on('submit', function(e){
        if (
            $("[name='subscription[rg_file]']").valid() &&
            $("[name='subscription[composition_file]']").valid() &&
            $("[name='subscription[cpf_file]']").valid() &&
            $("[name='subscription[proof_of_address_file]']").valid()
        ) {
            var cpf = $("input[name=subscription\\[cpf\\]]").val();
            var genre = $("[name=subscription\\[genre\\]]").val();
            return true;    
            // checkCpf(cpf, genre, function() {
            //     return true;
            // }, function() {
            //     e.preventDefault();
            //     $("#form-cadastro-cultural")[0].reset();
            //     $("#form-step2").hide();
            //     $("#form-step1").show();

            //     return false;
            // });
       } else {
           e.preventDefault();
           $('.inputfile').each(function(){
               if($(this).hasClass('error')) {
                   $(this).siblings('label').toggleClass("invalido");
                } 
            });
            alert('Anexe os arquivos obrigatórios');
        }

    });

    /* form inscricao 4job */
    //mudar nome e não deixar selecionar .pdf 
    $('#form-step2 input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        var ext = fileName.split('.');
        var element = $(this).closest( ".file" ).find('span').html(fileName);
        if (ext[1] != "pdf") {
            $(this).closest( ".file" ).find('.msg-file').addClass('error');
        }
    });

});