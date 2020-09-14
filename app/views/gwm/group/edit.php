<?php $this->title_bar = 'Grupos <span class="divider">/</span> ' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') ?>

<h2>Inserir grupo</h2>

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
					<label for="users_field">Usuários do grupo <?= Fishy_FormHelper::relational_field('users') ?></label>
				</div>
			</div>
		</fieldset>

		<a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
		<a href="<?= $this->site_url('group') ?>" class="cancel-form">Cancelar</a>
	<?= Fishy_FormHelper::form_end() ?>
</section>
