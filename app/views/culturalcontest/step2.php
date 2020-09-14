<div class="concursos">

    <?= $this->render_partial('cultural_contest_header') ?>

    <div class="conteudo">
        <div class="container">
            <?= $this->render_partial('page_title', array('title' => 'Inscrição')) ?>
            <ul class="buttons_step2">
                <li>
                    <a href="<?= $this->site_url('premio-cepe/inscricao/3') ?>" class="btn link-inscricao" >Sou maior de 18 anos</a>
                </li>
                <li>
                    <a href="<?= $this->site_url('premio-cepe/inscricao/2/menor') ?>" class="btn link-inscricao" >Sou menor de 18 anos</a>
                </li>
            </ul>
        </div>

    </div>
    <!-- conteúdo -->
</div>