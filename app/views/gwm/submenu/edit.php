<?php $this->title_bar = '<li><a href="' . $this->site_url('submenu') . '">Submenus</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>

<h2><?= !$this->object->exists() ? 'Inserir' : 'Editar' ?> submenu</h2>

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
				<div class="span4">
					<label for="controller_field">Controller <?= Fishy_FormHelper::text_field('controller') ?></label>
				</div>
			</div>

			<div class="row">
				<div class="span4">
					<label for="action_field">Action <?= Fishy_FormHelper::text_field('action') ?></label>
				</div>
			</div>

			<div class="row">
				<div class="span2">
					<label for="menu_id_field">Menu <?= Fishy_FormHelper::select_for_model('menu_id', $this->menus, 'name', 'id', array('include_blank' => '-- Escolha --')) ?></label>
				</div>
			</div>
		</fieldset>

		<a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
		<a href="<?= $this->site_url('submenu') ?>" class="cancel-form">Cancelar</a>
	<?= Fishy_FormHelper::form_end() ?>
</section>
