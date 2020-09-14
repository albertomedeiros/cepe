<?php $this->title_bar = 'Permissões <span class="divider">/</span> ' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') ?>

<h2>Inserir permissão</h2>

<section id="main">
	<?php $this->render_partial('form_errors', $this->object->problems(), array('controller' => 'gwm_main')) ?>
	<?= Fishy_FormHelper::form_for($this->object, array(), array("class" => "form-stacked")) ?>
		<fieldset>
			<div class="row">
				<div class="span4">
					<label for="name_field">Nome <?= Fishy_FormHelper::text_field('name') ?></label>
				</div>
			</div>

			<div class="row">
				<div class="span2">
					<label for="parent_id_field">Permissão Pai <?= Fishy_FormHelper::select_for_model('parent_id', $this->roles, 'id', 'name', array('include_blank' => 'ROOT')) ?></label>
				</div>
			</div>
		</fieldset>

		<a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
		<a href="<?= $this->site_url('role') ?>" class="cancel-form">Cancelar</a>
	<?= Fishy_FormHelper::form_end() ?>
</section>
