<div class="licitacoes">
  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1>Estrutura Admistrativa</h1>
  </div>
  <!-- título da página -->
  
  <style>
    .botao-padrao.branco{ 
      background: none;
    }
    .botao-padrao.branco input{

      padding: 20px;
      background: #d22323;
      color: white;
      font-weight: bold;
      border-radius: 15px;

    }
    .botao-padrao select{
      padding: 10px;
      font-size: 15px;
    }
  </style>
  
  <div class="conteudo">
    <div class="container">

    <form class="pcd-container" action="#" method="post">

          <div class="pcd-list">
            <div class="pcd-item item-active">
              <div class="pcd-content">
                <div class="informacoes">
                  <div class="botao-padrao">
                    <select name="categoria">
                      <option>-- Selecione --</option>
                    <?php
                        foreach($this->categories as $arrCategoria){
                            echo "<option value='{$arrCategoria->id}'>{$arrCategoria->title}</option>";
                        }
                    ?>
                    </select>
                    
                  </div>
                  <div class="botao-padrao branco">
                    <input type="submit" name="submit" value="Filtrar">
                  </div>
                </div>
              </div>
            </div>

          </div>

        </form><br />

      <?php if ($this->data): ?>
        <?php foreach ($this->data as $item): ?>
          
        <article class="licitacao gover-corp acordeon">
          <div class="cabecalho acordeon-click">
            <h2><?= $item->title ?></h2>
         <!-- <p>Criado: <?= $item->date ?></p> -->
          </div>  
          <div class="acordeon-inner">
            <?= $item->text ?>
          </div>

          <?php if ($item->files): ?>
          <div class="anexos">
            <h3>anexos:</h3>
            <?php 
              $item->files = array_reverse($item->files);
              foreach ($item->files as $file): 
            ?>
            <a href="<?= $this->public_url($file->path) ?>" class="anexo " target="_blank"><!-- adicionar classe para abrir os popups -> class="licitacoes-popup" -->
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
        
      <?php elseif (!$this->result_text): ?>
        <p><strong>Nenhum registro encontrado.</strong></p>
      <?php endif ?>
    </div>
  </div>
  <!-- conteúdo -->  
  <div class="popup"> <!-- .open -->
    <div class="container-popup">
      <div class="header-popup">
        <h4>Download</h4>
        <span class="close-popup"></span>
      </div>
      <div class="content-popup">
        <section>

          <!-- VALIDAÇÃO -->
          <form action="#" method="POST" class="form item-popup popup-active" id="popup-log">
            <label class="form-field">
              <span class="form-label">Digite seu CPF/CNPJ.</span>
              <input type="text" name="cpf-cnpj" id="cpf-cnpj" class="form-text mask-cpf-cnpj required">
            </label>
            <input type="submit" value="Avançar" class="form-submit" data-text="Avançar">
          </form>

          <!-- CADASTRO -->
          <form action="#" method="POST" class="form item-popup" id="popup-register">
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
              <input type="text" name="razao-social" id="razao-social" class="form-text required">
            </label>
            <label class="form-field">
              <span class="form-label">CPF ou CNPJ</span>
              <input type="text" name="cpf-cnpj" id="cpf-cnpj" class="form-text mask-cpf-cnpj required">
            </label>
            <input type="submit" value="Avançar" class="form-submit" data-text="Avançar">
            <p class="msg-error"></p>
          </form>

          <!-- aguardando validação por e-mail -->
          <div class="item-popup" id="register-success">
            <br>
            <h5>Uma mensagem de confirmação de usuário foi enviada para o e-mail cadastrado. Clique no link do e-mail para validar o CPF/CNPJ.</h5>
          </div>

          <!-- após validação por e-mail -->
          <div class="item-popup">
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
