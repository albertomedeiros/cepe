<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8 oldie" lang="pt-br"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="pt-br"><!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php ########################### START META_TAGS ########################### ?>
    <title itemprop='name'><?= $this->tags_meta_title ?></title>
    <link rel="canonical" href="<?= $this->current_url() ?>" itemprop="url">
    <meta name="author" content="<?= $this->tags_meta_author ?>">
    <meta name="description" content="<?= $this->tags_meta_description ?>">
    <!-- twitter card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:image"
          content="<?= $this->tags_tt_image ? $this->tags_tt_image : $this->og_image ?>">
    <meta name="twitter:title" content="<?= $this->tags_tt_title ?>">
    <meta name="twitter:description"
          content="<?= $this->tags_og_description ? $this->tags_og_description : $this->tags_meta_description ?>">
    <meta name="twitter:creator" content="<?= $this->tags_tt_creator ?>">
    <!-- open graph -->
    <meta property="og:locale" content="<?= $this->tags_og_locale ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $this->tags_og_title ?>">
    <meta property="og:description"
          content="<?= $this->tags_og_description ? $this->tags_og_description : $this->tags_meta_description ?>">
    <meta property="og:url" content="<?= $this->current_url() ?>">
    <meta property="og:image" content="<?= $this->tags_og_image ?>">
    <meta property="og:image:width" content="<?= $this->tags_og_image_width ?>">
    <meta property="og:image:height" content="<?= $this->tags_og_image_height ?>">
    <?php ########################### FINISH META_TAGS ########################### ?>
    <!-- add to homescreen for chrome on android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192"
          href="<?= $this->public_url('img/content/chrome-touch-icon-192x192.png') ?>">
    <!-- add to homescreen for safari on ios -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content=" ">
    <link rel="apple-touch-icon-precomposed"
          href="<?= $this->public_url('img/content/apple-touch-icon-precomposed.png') ?>">
    <!-- tile icon for win8 -->
    <meta name="msapplication-TileImage"
          content="<?= $this->public_url('img/content/ms-touch-icon-144x144-precomposed.png') ?>">
    <meta name="msapplication-TileColor" content="#81cfff">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= $this->public_url('img/content/favicon.ico') ?>">
    <link rel="icon" href="<?= $this->public_url('img/content/favicon.ico') ?>">
    <!-- style -->

    <!-- Bootstrap -->
    <link href="<?= $this->public_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= $this->public_url('css/bootstrap-theme.css') ?>" rel="stylesheet">

    <style type="text/css"><?= str_replace(array('img/', 'fonts/'), array($this->public_url('img/'), $this->public_url('fonts/')), file_get_contents(FISHY_PUBLIC_PATH . '/css/style.css')) ?></style>


    <link href="<?= $this->public_url('css/bootstrap-datepicker3.css') ?>" rel="stylesheet">
    <link href="<?= $this->public_url('css/custom.css') ?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/slick.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/slick-theme.css') ?>"/>
    <link href="<?= $this->public_url('css/2019custom.css') ?>" rel="stylesheet">

    <script>
        var __base_url = '<?= $this->site_url('') ?>';
    </script>
</head>
<body>
<nav class="screen-reader">
    <a href="#content" accesskey="c">Alt + Shift + C ir para o conteúdo</a>
    <a href="#nav" accesskey="m">Alt + Shift + M ir para o menu</a>
    <a href="#search" accesskey="b">Alt + Shift + B ir para a busca</a>
    <a href="#footer" accesskey="f">Alt + Shift + F ir para o rodapé</a>
</nav><!-- .screen-reader -->
<div id="container">
    <?php if ($this->isMobile): ?>
        <div class="header-mobile">
            <div class="cabecalho">
                <a href="<?= $this->site_url('') ?>" class="logo"><img
                            src="<?= $this->public_url('img/layout/logo-50.png') ?>"></a>

                <div class="btn-mobile">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <!-- botão mobile -->
            </div>

            <nav class="menu">
                <ul class="principal">
                    <li class="submenu">
                        <a title="A cepe">A cepe</a>
                        <ul>
                            <div class="title">
                                <span class="voltar">voltar</span>
                                <p>A cepe</p>
                            </div>
                            <div class="scroll">
                                <li><a href="<?= $this->site_url('a-cepe') ?>" title="A cepe">A
                                        cepe</a></li>
                                <li><a href="<?= $this->site_url('sobre') ?>"
                                       title="A cepe">Sobre</a></li>
                                <li><a href="<?= $this->site_url('noticias') ?>" title="notícias">Notícias</a>
                                </li>
                                <li><a href="<?= $this->site_url('termos-e-condicoes') ?>"
                                       title="termos e condições">Termos e condições</a></li>
                                <li><a href="<?= $this->site_url('politica-de-privacidade') ?>"
                                       title="política de privacidade">Política de privacidade</a>
                                </li>
                                <li><a href="<?= $this->site_url('governanca-corporativa') ?>"
                                       title="Governança Corporativa">Governança Corporativa</a>
                                </li>
                                <li><a href="<?= $this->site_url('estrutura-administrativa') ?>"
                                       title="Estrutura Administrativa">Estrutura Administrativa</a>
                                </li>
                                <?php if (false): ?>
                                    <li><a href="<?= $this->site_url('identidade-visual') ?>"
                                           title="identidade visual">Identidade visual</a></li>
                                <?php endif; ?>
                            </div>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a title="Produtos e Serviços">Produtos e Serviços</a>

                        <ul>
                            <div class="title">
                                <span class="voltar">voltar</span>
                                <p>Produtos e Serviços</p>
                            </div>
                            <div class="scroll">
                                <li><a href="<?= $this->site_url('./') ?>" title="Diário Oficial">Diário
                                        Oficial</a></li>
                                <li><a href="<?= $this->site_url('certificacao') ?>"
                                       title="Cepe Digital">Cepe Digital</a></li>
                                <li><a href="<?= $this->site_url('cepe-doc') ?>" title="Cepe Doc">Cepe
                                        Doc</a></li>
                                <li><a href="http://editora.cepe.com.br/" target="_blank"
                                       title="Cepe Editora">Cepe Editora</a></li>
                                <li><a href="http://www.revistacontinente.com.br/" target="_blank"
                                       title="Continente">Continente</a></li>
                                <li><a href="http://www.suplementopernambuco.com.br/"
                                       target="_blank" title="Pernambuco">Pernambuco</a></li>
                                <li><a href="<?= $this->site_url('cepe-grafica') ?>"
                                       title="Cepe Gráfica">Cepe Gráfica</a></li>
                                <li><a href="http://www.acervocepe.com.br/" target="_blank"
                                       title="Acervo Cepe">Acervo Cepe</a></li>
                                <li><a href="https://www.cepe.com.br/lojacepe/" target="_blank"
                                       title="Loja Cepe">Loja Cepe</a></li>
                            </div>
                        </ul>
                    </li>
                    <li><a href="<?= $this->site_url('licitacoes') ?>"
                           title="Licitações">Licitações</a></li>
                    <li><a href="<?= $this->site_url('concursos') ?>"
                           title="Prêmio">Prêmio</a></li>
                </ul>
                <ul class="auxiliar">
                    <li class="submenu">
                        <a title="Contato">Contato</a>
                        <ul>
                            <div class="title">
                                <span class="voltar">voltar</span>
                                <p>Contato</p>
                            </div>
                            <div class="scroll">
                                <li><a href="<?= $this->site_url('formularios-lai') ?>"
                                       title="Formulários LAI">Formulários LAI</a></li>
                                <li><a href="<?= $this->site_url('fale-conosco') ?>"
                                       title="Fale conosco">Fale conosco</a></li>
                                <li><a href="<?= $this->site_url('ouvidoria') ?>" title="Ouvidoria">Ouvidoria</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li><a href="<?= $this->site_url('faq') ?>" title="Faq">Faq</a></li>
                </ul>
                <div class="social">
                    <a href="https://www.facebook.com/cepeoficial/" target="_blank"
                       class="icon-font facebook" title="Facebook"></a>
                    <a href="https://br.linkedin.com/company/cepe---companhia-editora-de-pernambuco"
                       target="_blank" class="icon-font linkedin" title="Linkedin"></a>
                    <a href="https://www.youtube.com/channel/UCI9qcytTbfViq_vr7igY6VQ"
                       target="_blank" class="icon-font youtube" title="Youtube"></a>
                </div>
                <?php if (false): ?>
                    <div class="login">
                        <a href="<?= $this->site_url('') ?>" title="Entrar">Entrar</a>
                    </div>
                <?php endif; ?>
            </nav>
            <div>
                <table width="100%" border="1" cellspacing="10">
                    <tr>
                        <td>
                            <div>
                                <a target="_blank"
                                   href="https://diariooficial.cepe.com.br/diariooficialweb/#/login?diario=MQ=="
                                   class="botao-padrao2">Enviar Publicação</a>
                            </div>
                        </td>
                        <td>
                            <div>
                                <a target="_blank"
                                   href="https://diariooficial.cepe.com.br/diariooficialweb/#/login?diario=MQ=="
                                   class="botao-padrao2">Enviar Clipping</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- menu mobile -->
    <?php else: ?>
        <header class="header">
            <div class="container">

                <div>
                    <div style="float: right; margin-top: 0px; width: 173px; font-weight: bold">
                        <a target="_blank"
                           href="https://diariooficial.cepe.com.br/diariooficialweb/#/login?diario=MQ=="
                           class="botao-padrao2">Enviar Publicação</a>
                        <a target="_blank"
                           href="https://diariooficial.cepe.com.br/diariooficialweb/#/login?diario=MQ=="
                           class="botao-padrao2" style="margin-top: 10px">Enviar Clipping</a>
                    </div>
                </div>

                <a href="<?= $this->site_url('') ?>" class="logo"><img
                            src="<?= $this->public_url('img/layout/logo-50.png') ?>"></a>

                <nav class="menu">
                    <ul class="auxiliar">
                        <li>
                            <div class="social">
                                <a href="https://www.facebook.com/cepeoficial/" target="_blank"
                                   class="icon-font facebook" title="Facebook"></a>
                                <a href="https://br.linkedin.com/company/cepe---companhia-editora-de-pernambuco"
                                   target="_blank" class="icon-font linkedin" title="Linkedin"></a>
                                <a href="https://www.youtube.com/channel/UCI9qcytTbfViq_vr7igY6VQ"
                                   target="_blank" class="icon-font youtube" title="Youtube"></a>
                            </div>
                        </li>
                        <li class="submenu">
                            <a title="Contato">Contato</a>
                            <ul>
                                <li><a href="<?= $this->site_url('formularios-lai') ?>"
                                       title="Formulários LAI">Formulários LAI</a></li>
                                <li><a href="<?= $this->site_url('fale-conosco') ?>"
                                       title="Fale conosco">Fale conosco</a></li>
                                <li><a href="<?= $this->site_url('ouvidoria') ?>" title="Ouvidoria">Ouvidoria</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="<?= $this->site_url('faq') ?>" title="Faq">Faq</a></li>
                    </ul>
                    <ul class="principal">
                        <li class="submenu">
                            <a href="<?= $this->site_url('a-cepe') ?>" title="A cepe">A cepe</a>
                            <ul>
                                <li><a href="<?= $this->site_url('sobre') ?>"
                                       title="Sobre">Sobre</a></li>
                                
                                <li><a href="<?= $this->site_url('concursos') ?>" title="Prêmio">Prêmio</a>
                        </li>
                                <li><a href="<?= $this->site_url('termos-e-condicoes') ?>"
                                       title="termos e condições">Termos e condições</a></li>
                                <li><a href="<?= $this->site_url('politica-de-privacidade') ?>"
                                       title="política de privacidade">Política de privacidade</a>
                                </li>
                                <li><a href="<?= $this->site_url('governanca-corporativa') ?>"
                                       title="Governança Corporativa">Governança Corporativa</a>
                                </li>
                                <li><a href="<?= $this->site_url('estrutura-administrativa') ?>"
                                       title="Estrutura Administrativa">Estrutura Administrativa</a>
                                </li>
                                <?php if (false): ?>
                                    <li><a href="<?= $this->site_url('identidade-visual') ?>"
                                           title="identidade visual">Identidade visual</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a title="Produtos e Serviços">Produtos e Serviços</a>
                            <ul>
                                <li><a href="<?= $this->site_url('./') ?>" title="Diário Oficial">Diário
                                        Oficial</a></li>
                                <li><a href="<?= $this->site_url('cepe-digital') ?>"
                                       title="Cepe Digital">Cepe Digital</a></li>
                                <li><a href="<?= $this->site_url('cepe-doc') ?>" title="Cepe Doc">Cepe
                                        Doc</a></li>
                                <li><a href="http://editora.cepe.com.br/" target="_blank"
                                       title="Cepe Editora">Cepe Editora</a></li>
                                <li><a href="http://www.revistacontinente.com.br/" target="_blank"
                                       title="Continente">Continente</a></li>
                                <li><a href="http://www.suplementopernambuco.com.br/"
                                       target="_blank" title="Pernambuco">Pernambuco</a></li>
                                <li><a href="<?= $this->site_url('cepe-grafica') ?>"
                                       title="Cepe Gráfica">Cepe Gráfica</a></li>
                                <li><a href="http://www.acervocepe.com.br/" target="_blank"
                                       title="Acervo Cepe">Acervo Cepe</a></li>
                                <li><a href="https://www.cepe.com.br/lojacepe/" target="_blank"
                                       title="Loja Cepe">Loja Cepe</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= $this->site_url('licitacoes') ?>" title="Licitações">Licitações</a>
                        </li>
                        <li  class="submenu"><a href="<?= $this->site_url('noticias') ?>" title="notícias">Notícias</a>
                            <ul>
                                <?php
                                foreach ($this->categories as $category): 
                                    $intAno = (int) $category->title;
                                    // Caso seja númerico
                                    if($intAno > 0) continue;
                                ?>
                                     <li><a href="<?= $this->site_url('categoria/' . $category->slug) ?>"
                                       title="<?= $category->title ?>"><?= $category->title ?></a></li>
                                <?php endforeach ?>
                               
                            </ul>
                                </li>
                    </ul>
                </nav>

                <?php if (false): ?>
                    <div class="login">
                        <a href="<?= $this->site_url('') ?>" title="Entrar">Entrar</a>
                    </div>
                <?php endif; ?>

            </div>
        </header>
        <!-- menu desktop -->
    <?php endif ?>


    <?= $content ?>

    <footer>
        <div class="container">
            <ul class="menu-rodape">
                <li>
                    <strong>a cepe</strong>
                    <a href="<?= $this->site_url('sobre') ?>" title="notícias">Sobre</a>
                    <a href="<?= $this->site_url('termos-e-condicoes') ?>"
                       title="termos e condições">Termos e condições</a>
                    <a href="<?= $this->site_url('politica-de-privacidade') ?>"
                       title="política de privacidade">Política de privacidade</a>
                    <a href="<?= $this->site_url('governanca-corporativa') ?>"
                       title="Governança Corporativa">Governança Corporativa</a>
                    <a href="<?= $this->site_url('estrutura-administrativa') ?>"
                        title="Estrutura Administrativa">Estrutura Administrativa</a>
                                
		    <a href="#"
                       title="Intranet Cepe">Intranet</a>
                </li>

                <li>
                    <strong>produtos e serviços</strong>
                    <a href="<?= $this->site_url('./') ?>" title="Diário Oficial">Diário Oficial</a>
                    <a href="<?= $this->site_url('cepe-digital') ?>" title="Cepe Digital">Cepe
                        Digital</a>
                    <a href="<?= $this->site_url('cepe-doc') ?>" title="Cepe Doc">Cepe Doc</a>
                    <a href="http://editora.cepe.com.br/" target="_blank" title="Cepe Editora">Cepe
                        Editora</a>
                    <a href="http://www.revistacontinente.com.br/" target="_blank"
                       title="Continente">Continente</a>
                    <a href="http://www.suplementopernambuco.com.br/" target="_blank"
                       title="Pernambuco">Pernambuco</a>
                    <a href="<?= $this->site_url('cepe-grafica') ?>" title="Cepe Gráfica">Cepe
                        Gráfica</a>
                    <a href="http://www.acervocepe.com.br/" target="_blank" title="Acervo Cepe">Acervo
                        Cepe</a>
                    <a href="https://www.cepe.com.br/lojacepe/" target="_blank" title="Loja Cepe">Loja
                        Cepe</a>
                </li>

                <li>
                    <strong>Premio</strong>
                    <?php foreach ($this->tenders as $tender): ?>
                        <a href="<?= $this->site_url('concursos/' . $tender->slug) ?>"
                           title="<?= $tender->title ?>"><?= $tender->title ?></a>
                    <?php endforeach ?>
                </li>

                <li>
                    <strong>licitações</strong>
                    <a href="<?= $this->site_url('licitacoes') ?>" title="licitações recentes">licitações
                        recentes</a>

                    <strong>faq</strong>
                    <a href="<?= $this->site_url('faq') ?>" title="perguntas frequentes">perguntas
                        frequentes</a>
                    <strong>Notícias</strong>
                    <a href="<?= $this->site_url('noticias') ?>" title="notícias">Todas as Notícias</a> 
                    <?php 
                        foreach ($this->categories as $category):
                    ?>
                                    <a href="<?= $this->site_url('categoria/' . $category->slug) ?>"
                                    title="<?= $category->title ?>"> - <?= $category->title ?></a>
                    <?php endforeach ?>   
                </li>

                <li>
                    <strong>contato</strong>
                    <a href="<?= $this->site_url('ouvidoria') ?>" title="ouvidoria">ouvidoria</a>
                    <a href="<?= $this->site_url('fale-conosco') ?>" title="Fale conosco">Fale
                        conosco</a>
                    <a href="<?= $this->site_url('formularios-lai') ?>" title="lai">lai</a>
                </li>
            </ul>
            <!-- menu rodapé -->

            <div class="social">
                <a href="https://www.facebook.com/cepeoficial/" target="_blank"
                   class="icon-font facebook" title="Facebook"></a>
                <a href="https://br.linkedin.com/company/cepe---companhia-editora-de-pernambuco"
                   target="_blank" class="icon-font linkedin" title="Linkedin"></a>
                <a href="https://www.youtube.com/channel/UCI9qcytTbfViq_vr7igY6VQ" target="_blank"
                   class="icon-font youtube" title="Youtube"></a>
            </div>
            <!-- redes sociais -->
        </div>

        <div class="copyright">
            <div class="container">
                <p>Rua Coelho Leite, 530, Santo Amaro - Recife - PE<br/> CEP: 50100-140 | Fones:
                    (81) 3183.2700 / 0800.0811201</p>
                <div class="logos">
                    <img src="<?= $this->public_url('img/layout/logo-rodape.png') ?>"
                         class="logo-rodape"/>
                    <img src="<?= $this->public_url('img/layout/logo-acesso.png') ?>"
                         class="logo-acesso"/>
                </div>
                <p><span>COPYRIGHT 2018. Companhia Editora de Pernambuco - CEPE.</span></p>
            </div>
        </div>
    </footer>

</div><!-- #container -->

<!-- scripts lib -->
<script src="<?= $this->public_url('js/lib/modernizr.js') ?>"></script>

<!-- load jQuery 3.2.1 -->
<script src="<?= $this->public_url('js/lib/jquery-3.2.1.min.js') ?>"></script>

<script src="<?= $this->public_url('js/lib/wow.min.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/jquery.validate.min.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/maskedinput.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/owl.carousel.min.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/moment-with-locales.min.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/ion.calendar.min.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/jquery.jscrollpane.min.js') ?>"></script>
<script src="<?= $this->public_url('js/lib/jquery.mousewheel.js') ?>"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>

<!-- load jQuery 1.8.2 -->
<!--<script src="https://code.jquery.com/jquery-1.8.2.js"></script>-->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- scripts app -->
<script src="<?= $this->public_url('js/app/form.js') ?>"></script>
<script src="<?= $this->public_url('js/app/main.js') ?>?v=1.0"></script>
<script src="https://www.cepe.com.br/barra/barra.js"></script>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="<?= $this->public_url('js/jquery-1.12.4.min.js') ?>"></script>-->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?= $this->public_url('js/bootstrap.min.js') ?>"></script>
<script src="<?= $this->public_url('js/bootmenu.js') ?>"></script>
<script src="<?= $this->public_url('js/bootstrap-datepicker.js') ?>"></script>
<script src="<?= $this->public_url('js/locales/bootstrap-datepicker.pt-BR.js') ?>"></script>
<script type="text/javascript"
        src="<?= $this->public_url('js/bootstrap-filestyle.min.js') ?>"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous">


<script src="<?= $this->public_url('js/main.js') ?>"></script>
<script type="text/javascript" src="<?= $this->public_url('js/slick.min.js') ?>"></script>

<?php if($this->scripts): ?>
    <?php foreach($this->scripts as $script): ?>
        <script src="<?= $this->public_url($script) ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-15865670-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-15865670-1');
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.slider-single').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            adaptiveHeight: true,
            infinite: false,
            useTransform: true,
            speed: 400,
        });

        $('.slider-nav')
            .on('init', function (event, slick) {
                $('.slider-nav .slick-slide.slick-current').addClass('is-active');
            })
            .slick({
                slidesToShow: 7,
                slidesToScroll: 7,
                dots: false,
                focusOnSelect: true,
                infinite: false,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                    }
                }, {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    }
                }, {
                    breakpoint: 420,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                }]
            });

        $('.slider-single').on('afterChange', function (event, slick, currentSlide) {
            $('.slider-nav').slick('slickGoTo', currentSlide);
            var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
            $('.slider-nav .slick-slide.is-active').removeClass('is-active');
            $(currrentNavSlideElem).addClass('is-active');
        });

        $('.slider-nav').on('click', '.slick-slide', function (event) {
            event.preventDefault();
            var goToSingleSlide = $(this).data('slick-index');

            $('.slider-single').slick('slickGoTo', goToSingleSlide);
        });
    });

</script>

</body>
</html>
