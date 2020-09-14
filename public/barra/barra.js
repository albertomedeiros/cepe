var d = document,
    b = d.getElementsByTagName("body")[0],
    s = d.createElement("script"),
    barra = d.createElement("DIV"),
    url = window.location.href,
    barrahtml = '',
    barrastyle = '';

    barrastyle += '<style>@import url("https://www.cepe.com.br/fonts/stylesheet.css");body{padding:0;margin:0}body a{text-decoration:none}.barra-global{position:relative;display:block;width:100%;height:auto;min-height:45px;overflow:hidden;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background:#861f1f}.barra-global .logo-global{display:block;width:70px;height:31px;text-indent:-999em;background:url("https://www.cepe.com.br/img/layout/logo-small.png") no-repeat;float:left;margin-top:7px;margin-left:15px;-webkit-background-size:100% 100% !important;background-size:100% !important}.barra-global .btn-plus{display:none;text-indent:-999em;top:14px;right:15px;position:absolute;width:16px;height:16px;cursor:pointer}.barra-global .btn-plus:before{content:"";display:block;width:100%;height:2px;background:#fff;position:absolute;top:7px}.barra-global .btn-plus:after{content:"";display:block;width:2px;height:100%;background:#fff;position:absolute;left:7px;top:0}.barra-global .menubar{display:block;float:right;overflow:hidden}.barra-global .menubar>ul{padding:0;margin:0}.barra-global .menubar>ul>li{float:left;display:block;border-right:1px solid #972929}.barra-global .menubar>ul>li>a{display:block;font-size:12px;font-family: "Kelson Sans";color:#fff;padding:15px 19px;text-transform:uppercase;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;transition:all .3s ease}.barra-global .menubar>ul>li>a:hover{background:#972929}@media(max-width:1024px){.barra-global .logo-global{float:none}.barra-global .btn-plus{display:block}.barra-global .menubar{display:none;float:none}.barra-global .menubar>ul{padding-top:10px}.barra-global .menubar>ul>li{float:none;width:100%;border-right:0}}</style>';
    barrahtml  += '\
    \
    <div class="barra-global">\
      <a href="#" class="logo-global"></a>\
      <div class="btn-plus"></div>\
      <div class="menubar">\
        <ul>\
          <li><a href="https://www.cepe.com.br/" target="_blank">DIÁRIO OFICIAL ESTADO DE PERNAMBUCO</a></li>\
            <li><a href="http://editora.cepe.com.br/" target="_blank">Cepe EDITORA</a></li>\
            <li><a href="http://www.revistacontinente.com.br/" target="_blank">REVISTA CONTINENTE</a></li>\
            <li><a href="http://www.suplementopernambuco.com.br/" target="_blank">JORNAL LITERÁRIO PERNAMBUCO</a></li>\
            <li><a href="http://www.acervocepe.com.br/" target="_blank">Acervo Cepe</a></li>\
            <li><a href="https://www.cepe.com.br/lojacepe/" target="_blank">LOJA CEPE</a></li>\
        </ul>\
      </div>\
    </div>';

    barra.id = 'barraglobal';
    barra.innerHTML = barrastyle + barrahtml;
    b.insertBefore(barra, b.childNodes[0]);
    s.setAttribute("src", "https://www.cepe.com.br/barra/barra-func.js");
    d.body.appendChild(s);
