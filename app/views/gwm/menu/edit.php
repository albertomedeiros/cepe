<?php $this->title_bar = '<li><a href="' . $this->site_url('menu') . '">Menu</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>

<h2><?= !$this->object->exists() ? 'Inserir' : 'Editar' ?> menu</h2>

<section id="main">
	<?php $this->render_partial('form_errors', $this->object->problems(), array('controller' => 'gwm_main')) ?>
	<?= Fishy_FormHelper::form_for($this->object, array(), array("class" => "form-stacked")) ?>
		<fieldset>
			<div class="row">
				<div class="span4">
					<label for="name_field">Nome <?= Fishy_FormHelper::text_field('name') ?></label>
				</div>
			</div>
		</fieldset>

		<a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
		<a href="<?= $this->site_url('menu') ?>" class="cancel-form">Cancelar</a>
	<?= Fishy_FormHelper::form_end() ?>
</section>
