<div class="fale-conosco">

  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1>Fale conosco</h1>
  </div>
  <!-- título da página -->

  <div class="conteudo">
    <div class="container">
      <article>

        <form action="<?= $this->site_url('send_contact') ?>" id="form-fale-conosco" class="form">
          <input type="hidden" name="type" id="type" value="conosco">

          <div class="form-col-1">
            <label class="form-field">
              <span class="form-label">Nome</span>
              <input type="text" name="name" id="name" class="form-text required">
            </label>
          </div>

          <div class="form-col-1">
            <label class="form-field">
              <span class="form-label">E-mail</span>
              <input type="text" name="email" id="email" class="form-text required">
            </label>
          </div>


          <div class="form-col-2">
            <label class="form-field">
              <span class="form-label">Telefone</span>
              <input type="text" name="phone" id="phoneFale" class="form-text required" maxlength="15" aria-placeholder="(__) _________">
            </label>
          </div>

          <div class="form-col-2">
            <div class="form-field form-field-select">
              <span class="form-label">Assunto</span>
              <span class="form-text"></span>
              <select name="subject" class="required">
                <option value="">Assunto</option>
                <option value="Diário Oficial">Diário Oficial</option>
                <option value="Cepe Digital">Cepe Digital</option>
                <option value="Cepe Doc">Cepe Doc</option>
                <option value="Cepe Editora">Cepe Editora</option>
                <option value="Continente">Continente</option>
                <option value="Pernambuco">Pernambuco</option>
                <option value="Cepe Gráfica">Cepe Gráfica</option>
                <option value="Acervo CEPE">Acervo CEPE</option>
                <option value="Loja CEPE">Loja CEPE</option>
                <option value="Críticas e Sugestões">Críticas e Sugestões</option>
              </select>
            </div>
          </div>

          <div class="form-col-1">
            <label class="form-field form-field-textarea">
              <span class="form-label">Mensagem</span>
              <textarea name="message" id="message" class="form-text required"></textarea>
            </label>
          </div>

          <div class="form-col-1">
            <div class="form-msg">
              <p class="msg-error">Preencha todos os campos corretamente.</p>
              <p class="msg-success">Mensagem enviada com sucesso!</p>
            </div>
            <input type="submit" value="Enviar" class="form-submit" data-text="Enviar">
          </div>

        </form>

      </article>
    </div>
  </div>
  <!-- conteúdo -->

</div>
