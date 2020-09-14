<div class="noticias interna">
  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1><?= $this->news->title ?></h1>
  </div>
  <!-- título da página -->

  <div class="conteudo">
    <div class="container">
      <div class="lista-de-noticias">
        
        <article>
          <div class="cabecalho">
            <span>Criado: <?= $this->news->date ?></span>
            <h2><?= $this->news->subtitle ?></h2>
          </div>
          <div class="conteudo-do-post">
            <?php if ($this->news->image): ?>
            <img src="<?= $this->site_url('image/view/news/image/' . $this->news->id) ?>" alt="<?= $this->news->title ?>" class="img-news" />
            <?php endif ?>

            <?= $this->news->text ?>
          </div>
        </article>
        <!-- post -->

        <?php if ($this->news->files): ?>
        <article class="box-anexo">
          <div class="anexos">
            <h3>anexos:</h3>
            <?php foreach ($this->news->files as $file): ?>
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
      <!-- lista de notícias -->
    </div>
  </div>
  <!-- conteúdo -->
</div>
