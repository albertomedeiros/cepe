<div class="diario-oficial">
  <div class="container">
    <ul>
      <li>
        <img src="<?= $this->public_url('img/layout/logo-diario-oficial.png') ?>" />
      </li>
      <li>
        <p>De extrema importância para a democracia, o Diário Oficial é uma publicação da Companhia Editora de Pernambuco.</p>
      </li>
    </ul>
  </div>
</div>
<!-- diário oficial -->

<div class="busca-por-data">
  <div class="container">
    <div class="filtro">
      <p>Selecione o período para acessar o acervo:</p>
      <form method="post" action="<?= $this->site_url() ?>" id="form-calendario" class="formulario">
        <div class="form-control">
          <select name="mes" id="mes" class="custom-select">
            <?php foreach ($this->months as $k => $month): ?>
            <option value="<?= $k ?>" <?= (int)$k == date('m') ? 'selected' : '' ?>><?= $month ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-control">
          <select name="anos" id="ano" class="custom-select">
            <?php
              for($i = date("Y"); $i >= 1936; $i--) {
                $i==date("Y") ? $valor = "selected" : $valor = "";
                echo "<option value='$i' $valor>$i</option>";
              }
            ?>
          </select>
        </div>
      </form>
    </div>
  </div>

  <div class="container-calendario">

    <div class="anterior">anterior</div>
      <div class="calendario js-calendario owl-carousel">
        <?php $this->render_partial('calendar', array('year' => date('Y'), 'month' => date('m'))); ?>
      </div>
    <div class="proxima">proxima</div>

  </div>
  <!-- calendário slider -->

  <div class="acoes-calendario">
    <section>
      <a href="#" class="botao-calendario" title="Vizualizar diário oficial"><i></i>visualizar diário oficial</a>
      <a href="#" class="visualizar-calendario" title="Vizualizar calendario">visualizar calendário</a>
      <a href="#" class="busca-avancada" title="Busca avançada">busca avançada</a>
    </section>
  </div>
  <!-- ações do calendário -->
</div>
<!-- busca por data  -->

<div class="calendario-popup calendario">
  <div class="container-popup">
    <div class="cabecalho">
      <h4>Busca por calendário</h4>
      <span class="fechar"></span>
    </div>

    <div class="conteudo-popup">
      <section>
        <div id="calendario"></div>

        <a href="#" class="botao-padrao visualizar">visualizar</a>
      </section>
    </div>
  </div>
</div>
<input type="hidden" id="mydate" value="">
<!-- calendário -->

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
            <p>Digite abaixo a palavra desejada. Se preferir, escolha a pesquisa avançada para filtrar por ano ou década.</p>
            <input type="text" name="palavrachave" id="palavrachave" class="form-control" placeholder="Palavra-chave" />
          </div>
          <div class="avancada">
            <strong>busca avançada</strong>
            <div class="radio">
              <input type="radio" value="ano" name="campo-radio" id="campo-radio1" checked="checked" />
              <label for="campo-radio1">Ano</label>
              <input type="radio" value="decada" name="campo-radio" id="campo-radio2" />
              <label for="campo-radio2">Década</label>
              <input type="radio" value="todos" name="campo-radio" id="campo-radio3" />
              <label for="campo-radio3">1936 até dias atuais</label>
            </div>

            <select name="anos" id="anos">
              <?php
                for($i = date("Y"); $i >= 1936; $i--) {
                  $i==date("Y") ? $valor = "selected" : $valor = "";
                  echo "<option value='$i' $valor>$i</option>";
                }
              ?>
            </select>

            <select name="anos" id="decadas">
              <?php
                $begin = new DateTime( '1930-01-01' );
                $end = new DateTime( date('Y-m-d') );
                $interval = DateInterval::createFromDateString('10 year');
                $period = new DatePeriod($begin, $interval, $end);

                $decades = array();

                foreach ( $period as $dt ){
                  $decades[] = $dt->format('Y');
                }

                rsort($decades);

                foreach ($decades as $decade) {
                  $decade==date("Y") ? $valor = "selected" : $valor = "";
                  echo "<option value='$decade' $valor>$decade</option>";
                }
              ?>
            </select>
          </div>
          <button class="botao-padrao visualizar">visualizar</button>
        </form>
      </section>
    </div>
  </div>
</div>
<!-- busca avançada -->

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
          <img src="<?= $this->public_url('img/layout/doc-reader.png') ?>" class="mockup" />
          <a href="#" data-date="" class="botao-padrao visualizar">visualizar online</a>
        </div>
      </section>
      <ul class="logos">
        <li><img src="<?= $this->public_url('img/layout/logo-ati.png') ?>" class="mockup" /></li>
        <li><img src="<?= $this->public_url('img/layout/cepe-logo-preto.png') ?>" class="mockup" /></li>
      </ul>
    </div>
  </div>
</div>
<!-- resultado da busca -->

<div class="df-cta">
  <div class="container">
    <div class="df-cta-btns">
        <a href="<?= $this->public_url('pdf/faq_sdoe.pdf') ?>" target="_blank" class="df-cta-links">Perguntas Frequentes</a>
        <a href="<?= $this->public_url('pdf/manuais_de_usuarios_sdoe.pdf') ?>" target="_blank" class="df-cta-links">Manual do usuário</a>
    </div>
    <a href="https://diariooficial.cepe.com.br/diariooficialweb/#/login?diario=MQ==" target="_blank" class="df-cta-btn">Acesse o Sistema do Diário Oficial</a>
  </div>
</div><!-- .df-cta -->
