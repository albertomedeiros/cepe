<div class="concursos">
 
  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1>Pr&ecircmios</h1>
  </div>
  <!-- título da página -->

  <div class="conteudo">
    <div class="container">
      <div class="lista-de-concursos">
        <?php if ($this->data): ?>
          <?php foreach ($this->data as $item): ?>
            <article>
              <a href="<?= $this->site_url('concursos/' . $item->slug) ?>" title="<?= $item->title ?>">
                <h2><?= $item->title ?></h2>
              </a>
            </article>
            <!-- post -->
          <?php endforeach ?>

        <div class="paginacao">
          <a href="<?= $this->prev ?>" class="botao-padrao anterior <?= $this->page == 1 ? 'disabled' : '' ?>">Anterior</a>
          <a href="<?= $this->next ?>" class="botao-padrao proxima <?= $this->page >= $this->total ? 'disabled' : '' ?>">Próximo</a>
        </div>
        <!-- paginação -->
        <?php else: ?>
          <p><strong>Nenhum registro encontrado.</strong></p>
        <?php endif ?>
      </div>
      <!-- lista de concursos -->
    </div>
  </div>
  <!-- conteúdo -->  
</div>
