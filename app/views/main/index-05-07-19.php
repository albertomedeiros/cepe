<div class="diario-oficial">
    <div class="container">
        <ul>
            <li>
                <img style="width: 85%"
                     src="<?= $this->public_url('img/layout/logo-diario-oficial.png') ?>"/>
            </li>
            <li>
                <p style="font-size: 1.5rem">De extrema importância para a democracia, o Diário
                    Oficial é uma publicação da
                    Companhia Editora de Pernambuco.</p>
            </li>
        </ul>
    </div>
</div>
<!-- diário oficial -->
<div class="row">
    <div style="border: 1px solid #ccc; padding: 0" class="col-md-4 col-lg-3 col-md-offset-1">
        <div class="panel panel-default">
            <!-- menu-float-->
            <div class="panel-body">
                <div class="panel panel-second">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="slider slider-single">

                                <!-- Inicio miniatura com fade -->
                                <div id="img-miniatura-jornal" class="diario-thumb-container">

                                </div>
                                <!-- Fim miniatura com fade -->
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding: 0">
                            <input id="diario-date-picker" name="data-diario" type="text"
                                   class="campo-texto"
                                   autocomplete="off"
                                   readonly
                                   style="caret-color: transparent; text-align: center; cursor: pointer; padding-right: 20px; background: #d22323; border: #ccc; color: white;"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <h3 class="busca-avancada-titulo">Buscar Edição</h3>
                <label>Digite a data da edição</label>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <input id="textNumeroEdicao" name="entidade" type="text" class="campo-texto"
                           autocomplete="off" maxlength="10"
                           required/>
                </div>
                <div class="col-md-2" style="padding: 0">
                    <a style="cursor: pointer" id="botaoNumeroEdicao" class="botao-padrao2">OK</a>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12" style="padding-right: 0">
                <div class="form-group">
                    <h3 class="busca-avancada-titulo">Buscar por Palavra</h3>
                    <label>A busca é feita pela palavra ou expressão digitada</label>
                    <div class="col-md-10" style="padding-left: 0">
                        <input id="buscaPalavra" name="entidade" type="text" class="campo-texto"
                               autocomplete="off"
                               required/>
                    </div>
                    <div class="col-md-2" style="padding: 0">
                        <fieldset>
                            <a style="cursor: pointer" id="botaoLimparBuscaAvancada"
                               class="botao-padrao2">LIMPAR</a>
                        </fieldset>
                    </div>
                </div><!-- /form-group -->
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-5">
                <label for="entidade">Data inicial</label>
            </div>
            <div class="col-md-5">
                <label for="entidade">Data final</label>
            </div>
            <div class="col-md-5">
                <!-- <div id="selectMenuAssunto"></div> -->
                <input id="buscaDataInicial" maxlength="10" style="font-size: small"
                       name="buscaDataInicial" type="text" class="campo-texto"
                       autocomplete="off"
                       required/>
            </div>
            <div class="col-md-5">
                <!-- <div id="selectMenuCategoria"></div> -->
                <input id="buscaDataFinal" maxlength="10" style="font-size: small" name="buscaDataFinal"
                       type="text" class="campo-texto"
                       autocomplete="off"
                       required/>
            </div>
            <div class="col-md-2" style="padding: 0">
                <fieldset>
                    <a style="cursor: pointer" id="botaoBuscaAvancada" class="botao-padrao2">OK</a>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div style="margin-top: 10px" class="col-md-12">
                <label>Para diários anteriores a 2019 <a id="busca-avancada" style="cursor: pointer"
                                                         style="color:#808080;"><u>clique
                            aqui</u></u></a>.</label>
            </div>
        </div>
        <br>
        <div class="row">
            <fieldset>
                <div class="col-md-12">
                    <h3 class="busca-avancada-titulo">Consultar Autenticidade</h3>
                </div>
                <div class="col-md-10">
                    <input id="consultarAutenticidade" name="entidade" type="text"
                           class="campo-texto"
                           autocomplete="off"
                           required/>
                </div>
                <div class="col-md-2" style="padding: 0">
                    <a style="cursor: pointer" id="botaoConsultarAutenticidade"
                       class="botao-padrao2">OK</a>
                </div>
            </fieldset>
        </div>

    </div><!-- /.col-md -->


    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="flex-container" style="background: #fff; padding: 15px;">
                <h3 style="font-size: 17pt; font-weight: 500" id="dataSelecionada"
                    class="text-center">

                </h3>
            </div>
            <div class="panel-body">
                <div class="panel panel-second">
                    <div id="cadernos-front" class="panel-body">

                    </div>
                </div>
                <div style="margin-top: 40px" class="flex-container">
                    <img src="<?= $this->public_url('img/diarios/cepe-logo-preto.png') ?>"></img>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="modalLoading" class="modal"
     style="display: none; overflow: hidden; position: fixed; z-index: 1000; top: 0; left: 0; height: 100%; width: 100%; background: rgba( 255, 255, 255, .8 ) url('https://i.stack.imgur.com/FhHRx.gif') 50% 50%  no-repeat;">

</div>

<!-- busca avançada -->
<div class="calendario-popup busca">
    <div class="container-popup">
        <div class="cabecalho">
            <h4>Busca avançada</h4>
            <span class="fechar"></span>
        </div>

        <div class="conteudo-popup">
            <section>
                <form method="post" action="" id="busca-avancada">
                    <div class="palavra-chave">
                        <p>Digite abaixo a palavra desejada. Se preferir, escolha a pesquisa
                            avançada para filtrar por ano ou década.</p>
                        <input type="text" name="palavrachave" id="palavrachave"
                               class="form-control" placeholder="Palavra-chave"/>
                    </div>
                    <div class="avancada">
                        <strong>busca avançada</strong>
                        <div class="radio">
                            <input type="radio" value="ano" name="campo-radio" id="campo-radio1"
                                   checked="checked"/>
                            <label for="campo-radio1">Ano</label>
                            <input type="radio" value="decada" name="campo-radio"
                                   id="campo-radio2"/>
                            <label for="campo-radio2">Década</label>
                        </div>

                        <select name="anos" id="anos">
                            <?php
                            for ($i = date("Y"); $i >= 1936; $i--) {
                                $i == date("Y") ? $valor = "selected" : $valor = "";
                                if ($i < 2004) {
                                    echo "<option value='$i' $valor>$i</option>";
                                }
                            }
                            ?>
                        </select>

                        <select name="anos" id="decadas">
                            <?php
                            $begin = new DateTime('1930-01-01');
                            $end = new DateTime('2018-12-01');
                            $interval = DateInterval::createFromDateString('10 year');
                            $period = new DatePeriod($begin, $interval, $end);

                            $decades = array();

                            foreach ($period as $dt) {
                                $decades[] = $dt->format('Y');
                            }

                            rsort($decades);

                            foreach ($decades as $decade) {
                                $decade == date("Y") ? $valor = "selected" : $valor = "";
                                echo "<option value='$decade' $valor>$decade</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <a style="cursor: pointer" id="bt-visualizar" class="botao-padrao2">BUSCAR</a>
                </form>
            </section>
        </div>
    </div>
</div>

<div class="calendario-popup resultado">
    <div class="container-popup">
        <div class="cabecalho">
            <h4></h4>
            <span class="fechar"></span>
        </div>
        <div class="conteudo-popup">
            <section>
                <div class="documentos">
                    <p><i></i>Baixar documentos em PDF</p>
                    <ul>
                    </ul>
                </div>
                <div class="acervo">
                    <p>Acesse o acervo diretamente</p>
                    <a style="cursor: pointer" id="html" name="html" style="bottom: 80px;"
                       data-date=""
                       class="botao-padrao visualizar">visualizar html</a>
                    <a style="cursor: pointer" id="pdf" name="pdf" data-date=""
                       class="botao-padrao visualizar">visualizar
                        online</a>
                </div>
            </section>
            <ul class="logos">
                <li><img src="<?= $this->public_url('img/layout/logo-ati.png') ?>" class="mockup"/>
                </li>
                <li><img src="<?= $this->public_url('img/layout/cepe-logo-preto.png') ?>"
                         class="mockup"/></li>
            </ul>
        </div>
    </div>
</div>
<!-- resultado da busca -->

<div class="certificado-digital parallax" data-parallax-speed="3">
    <div class="texto">
        <article>
            <h1><img src="<?= $this->public_url('img/layout/logo-cepe-digital.png') ?>"
                     alt="Cepe Digital"></h1>
            <p>
                A Cepe Digital, serviço de certificação digital da Cepe, emite o documento
                eletrônico que comprova autenticidade de dados sobre a pessoa e/ou empresa e permite
                transações digitais mais seguras, evitando fraudes e falsificações. Conheça!
                <br/>
                <a href="<?= $this->site_url('certificacao'); ?>" class="botao-padrao"
                   title="Saiba mais">saiba mais</a>
            </p>
        </article>
    </div>
</div>
<!-- certificado digital -->

<div class="container-mockup">
    <section>
        <div class="container">
            <article>
                <p>A Cepe tem compromisso em oferecer produtos e serviços de alta qualidade para
                    toda a sociedade. Conheça todas as nossas atividades e saiba como a Cepe pode
                    contribuir para o desenvolvimento democrático e cultural do país.</p>
            </article>
            <img src="<?= $this->public_url('img/layout/mockup-livros.png') ?>" class="mockup"/>
        </div>
    </section>
    <div class="container">
        <ul class="links">
            <li><a href="<?= $this->site_url('./') ?>" title="Diário Oficial">Diário Oficial</a>
            </li>
            <li><a href="<?= $this->site_url('certificacao') ?>" title="Cepe Digital">Cepe
                    Digital</a></li>
            <li><a href="<?= $this->site_url('cepe-doc') ?>" title="Cepe Doc">Cepe Doc</a></li>
            <li><a href="http://editora.cepe.com.br/" target="_blank" title="Cepe Editora">Cepe
                    Editora</a></li>
            <li><a href="http://www.revistacontinente.com.br/" target="_blank" title="Continente">Continente</a>
            </li>
            <li><a href="http://www.suplementopernambuco.com.br/" target="_blank"
                   title="Pernambuco">Pernambuco</a></li>
            <li><a href="<?= $this->site_url('cepe-grafica') ?>" title="Cepe Gráfica">Cepe
                    Gráfica</a></li>
            <li><a href="http://www.acervocepe.com.br/" target="_blank" title="Acervo Cepe">Acervo
                    Cepe</a></li>
            <li><a href="https://www.cepe.com.br/lojacepe/" target="_blank" title="Loja Cepe">Loja
                    Cepe</a></li>
        </ul>
    </div>
</div>
<!-- mockup livros -->