<div class="licitacoes">
  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1>licitações</h1>
  </div>
  <!-- título da página -->

  <div class="pesquisa-avancada">
    <div class="container">
      <form action="<?= $this->site_url('licitacoes/busca') ?>" method="get" class="formulario">
        <div class="form-control">
          <input type="text" name="search" placeholder="Pesquisa avançada" />
          <button>buscar</button>
        </div>
      </form>
    </div>
  </div>
  <!-- pesquisa avançada -->

  <div class="conteudo">
    <div class="container">
      <?php if ($this->result_text): ?>
      <div class="resultado-busca">
        <p><?= $this->result_text ?></p>
      </div>
      <?php endif ?>

      <?php if ($this->data): ?>
        <?php foreach ($this->data as $item): ?>

        <article class="licitacao lic-item">
          <div class="cabecalho">
            <h2><?= $item->title ?></h2>
            <p>Criado: <?= $item->date ?></p>
          </div>

          <?= $item->text ?>

          <?php if ($item->files): ?>
          <div class="anexos">
            <h3>anexos:</h3>
            <?php foreach ($item->files as $file): ?>
            <a href="<?=$this->public_url($file->path); ?>" class="anexo" id="<?=$file->id?>" ><!-- adicionar classe para abrir os popups -> class="licitacoes-popup" -->
              <i></i>
              <p><?= $file->title ?> <span>(<?= $this->size_units(FISHY_PUBLIC_PATH . '/' . $file->path) ?>)</span></p>
            </a>
            <!-- anexo -->
            <?php endforeach ?>
          </div>
          <?php endif ?>
        </article>
        <!-- licitação -->
        <?php endforeach ?>

      <div class="paginacao">
        <a href="<?= $this->prev ?>" class="botao-padrao anterior <?= $this->page == 1 ? 'disabled' : '' ?>">Anterior</a>
        <a href="<?= $this->next ?>" class="botao-padrao proxima <?= $this->page >= $this->total ? 'disabled' : '' ?>">Próximo</a>
      </div>
      <!-- paginação -->
      <?php elseif (!$this->result_text): ?>
        <p><strong>Nenhum registro encontrado.</strong></p>
      <?php endif ?>
    </div>
  </div>
  <!-- conteúdo -->
  <div class="popup <?=$this->check?'open':''?>"> <!-- .open -->
    <div class="container-popup">
      <div class="header-popup">
        <h4>Download</h4>
        <span class="close-popup"></span>
      </div>
      <div class="content-popup">
        <section>

          <!-- VALIDAÇÃO -->
          <form action="<?=$this->site_url('licitacoes/check-cpf-cnpj')?>" method="POST" class="form-popup item-popup <?=$this->check?'':'popup-active'?> form-cpf" id="popup-log">
            <label class="form-field">
              <span class="form-label">Digite seu CPF/CNPJ.</span>
              <input type="text" name="cpf-cnpj" id="cpf-cnpj" class="form-text mask-cpf-cnpj required">
            </label>
            <input type="submit" value="Avançar" class="form-submit" data-text="Avançar">
            <div class="form-msg">
              <p class="msg msg-error">CPF ou CNPJ inválido!</p>
            </div>
          </form>

          <!-- CADASTRO -->
          <form action="<?=$this->site_url('licitacoes/registrar')?>" method="POST" class="form-popup item-popup form-licitacao" id="popup-register">
            <h5>Seu CPF/CNPJ não está cadastrado. Por favor, cadastre-se nos campos abaixo para realizar o download:</h5>
            <label class="form-field">
              <span class="form-label">Nome e Sobrenome</span>
              <input type="text" name="nome" id="nome" class="form-text required">
            </label>
            <label class="form-field">
              <span class="form-label">E-mail</span>
              <input type="email" name="email" id="email" class="form-text required">
            </label>
            <label class="form-field">
              <span class="form-label">Razão Social</span>
              <input type="text" name="razao" id="razao-social" class="form-text required">
            </label>
            <label class="form-field">
              <span class="form-label">CPF ou CNPJ</span>
              <input type="text" name="cpf" id="cpf-cnpj" class="form-text mask-cpf-cnpj required">
            </label>
            <input type="submit" value="Avançar" class="form-submit" data-text="Avançar">
            <div class="form-msg">
              <p class="msg msg-error"></p>
            </div>
          </form>

          <!-- aguardando validação por e-mail -->
          <div class="item-popup" id="register-success">
            <br>
            <h5>Uma mensagem de confirmação de usuário foi enviada para o e-mail cadastrado. Clique no link do e-mail para validar o CPF/CNPJ.</h5>
          </div>

          <div class="item-popup" id="register-error">
            <br>
            <h5>CPF/CNPJ inválido.</h5>
          </div>

          <!-- após validação por e-mail -->
          <div class="item-popup <?=$this->check?'popup-active':''?>">
            <br>
            <h5>
              Seu cadastro foi validado com sucesso!<br>Clique no arquivo da lista para realizar o download.
            </h5>
          </div>

        </section>
      </div>
    </div>
  </div>
</div>
