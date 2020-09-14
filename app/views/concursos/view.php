<div class="concursos interna">
 
  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1><?= $this->tender->title ?></h1>
  </div>
  <!-- título da página -->

  <div class="conteudo">
    <div class="container">
      <div class="lista-de-concursos">
        <article>
          <?php if ($this->tender->subtitle || $this->tender->summary): ?>
          <div class="cabecalho">
            <?php if ($this->tender->subtitle): ?>
            <h2><?= $this->tender->subtitle ?></h2>
            <?php endif ?>

            <?php if ($this->tender->summary): ?>
            <p><?= $this->tender->summary ?></p>
            <?php endif ?>
          </div>
          <?php endif ?>

          <div class="conteudo-do-post">
            <?= $this->tender->text ?>
          </div>
        </article>
        <!-- post -->

        <?php if ($this->tender->files): ?>
        <article class="box-anexo">
          <div class="anexos">
            <h3>anexos:</h3>
            <?php foreach ($this->tender->files as $file): ?>
            <a href="<?= $this->public_url($file->path) ?>" class="anexo" target="_blank">
              <i></i>
              <p><?= $file->title ?> <span>(<?= $this->size_units(FISHY_PUBLIC_PATH . '/' . $file->path) ?>)</span></p>
            </a>
            <!-- anexo -->  
            <?php endforeach ?>
          </div>  
        </article>
        <!-- concursos -->
        <?php endif ?>
      </div>
      <!-- lista de concursos -->
    </div>
  </div>
  <!-- conteúdo -->  
</div>