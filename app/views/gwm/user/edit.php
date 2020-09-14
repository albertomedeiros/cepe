<?php $this->title_bar = '<li><a href="' . $this->site_url('user') . '">Usu&aacute;rios</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>

<h2>Inserir usu&aacute;rio</h2>

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
					<label for="email_field">E-mail <?= Fishy_FormHelper::text_field('email') ?></label>
				</div>
			</div>

			<div class="row">
				<div class="span4">
					<label for="login_field">Login <?= Fishy_FormHelper::text_field('login') ?></label>
				</div>
			</div>

			<?php if ($this->object->exists()): ?>
			<div class="row">
				<div class="span4">
					<label for="password_field">Senha <?= Fishy_FormHelper::password_field('password') ?></label>
				</div>
			</div>
			<?php else: ?>
			<div class="row">
				<div class="span4">
					<label for="password_field">Senha <?= Fishy_FormHelper::password_field('password') ?></label>
				</div>
			</div>

			<div class="row">
				<div class="span4">
					<label for="password_confirm_field">Confirmar Senha <?= Fishy_FormHelper::password_field('password_confirm') ?></label>
				</div>
			</div>
			<?php endif ?>

			<div class="row">
				<div class="span2">
					<label for="submenus_field">Permissões: </label>
					<div class="list-permits"><label><input type="checkbox" id="permits_admin" <?= $this->object->has_admin() ? 'checked="checked"' : '' ?>>Administrador</label></div>
					<?= Fishy_FormHelper::checkbox_tree('submenus[]', $this->submenus, array('selected' => $this->object->individual_submenus())) ?>
				</div>
			</div>
		</fieldset>
		
		<a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
		<a href="<?= $this->site_url('user') ?>" class="cancel-form">Cancelar</a>
	<?= Fishy_FormHelper::form_end() ?>
</section>
