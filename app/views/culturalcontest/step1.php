<div class="concursos">

    <?= $this->render_partial('cultural_contest_header') ?>

    <div class="conteudo">
        
        <div class="container">
            <?php
            $data1 = strtotime(date("Y-m-d"));
            $data2 = strtotime('2019-07-22');
            $data3 = strtotime('2019-09-21');
            ?>
            <?php if ($data1 > $data2 && $data1 < $data3): ?>
            <a class="btn link-inscricao" href="<?= $this->site_url('premio-cepe/inscricao/2') ?>">Inscrição</a>
            <?php endif; ?>

            <div class="anexos">
                <h3>arquivos:</h3>

                <?php foreach ($this->attachments as $attachment): ?>
                    <a href="<?= $this->public_url($attachment->file) ?>" download class="anexo" id="<?= $attachment->id ?>">
                        <!-- adicionar classe para abrir os popups -> class="licitacoes-popup" -->
                        <i></i>
                        <p><?= $attachment->title ?> (<?= $attachment->get_file_size() ?>)</p>
                    </a>
                <?php endforeach ?>
            </div>
        
        </div>

        <?= $this->render_partial('sidebar') ?>

    </div>
    <!-- conteúdo -->
</div>
