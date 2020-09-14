<?php $this->title_bar = '<li><a href="' . $this->site_url('contest/attachment') . '">Concurso Cultural - Anexos</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>
<h2><?= !$this->object->exists() ? 'Inserir' : 'Editar' ?> Anexo</h2>

<section id="main">
    <?php $this->render_partial('form_errors', $this->object->problems(), array('controller' => 'gwm_main')) ?>
    <?= Fishy_FormHelper::form_for($this->object, array("multipart" => true), array("class" => "form-stacked")) ?>
    <fieldset>

        <div class="row">
            <div class="span4">
                <label for="title_field">Título <?= Fishy_FormHelper::text_field('title') ?></label>
            </div>
        </div>

        <br style="clear:both;" />
        <div class="row">
            <div class="span4">
                <label for="file_field">Anexo <?= Fishy_FormHelper::file_field('file') ?></label>
            </div>
        </div>

        <?php if ($this->object->file): ?>
        <div class="row">
            <div class="span4">
                <a href="<?= $this->public_url('../' . $this->object->file) ?>" class="block" target="_blank" title="Visualizar arquivo"><img src="<?= $this->public_url('img/obj/' . $this->object->ext_image . '.gif') ?>"><br/>Visualizar arquivo</a>
            </div>
        </div>
        <?php endif; ?>

    </fieldset>

    <a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
    <a href="<?= $this->site_url('news') ?>" class="cancel-form">Cancelar</a>
    <?= Fishy_FormHelper::form_end() ?>
</section>