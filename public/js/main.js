

$(document).ready(function() {
    var categoria = new Array('Categoria A', 'Categoria B', 'Categoria C');
    $("#selectMenuCategoria").bootmenu({
        items: categoria,
        defaultText: "Selecione",
        listName: "Categoria",
        color: "white",
        background: "#961919",
        hoverColor: "#000",
        listAnimation : "slideDown",
        animationDuration: 1000,

        callback: function() {

        }
    });

    var assunto = new Array('Assunto A', 'Assunto B', 'Assunto C');
    $("#selectMenuAssunto").bootmenu({
        items: assunto,
        defaultText: "Selecione",
        listName: "Assunto",
        color: "white",
        background: "#961919",
        hoverColor: "#000",
        listAnimation : "slideDown",
        animationDuration: 1000,

        callback: function() {

        }
    });

    $('.input-group.date').datepicker({//DATEPICKER http://bootstrap-datepicker.readthedocs.io/en/latest/options.html#container
        orientation: "bottom left",
        //maxViewMode: 2,
        language: "pt-BR",
        multidate: true,
        multidateSeparator: " | ",
      //  autoclose: true,
      todayHighlight: true,
        leftArrow: '<span class="glyphicon glyphicon-menu-left"></span>',
        rightArrow: '<span class="glyphicon glyphicon-menu-right"></span>'
    });



});



//MENU DROPDOWN HOVER
$('ul.nav li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(300);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(300);
});
