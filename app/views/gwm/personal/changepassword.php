<?php $this->title_bar = 'Minha conta <span class="divider">/</span> Alterar senha' ?>

<h2>Editar perfil</h2>

<section id="main">
	<?php $this->render_partial('form_errors', $this->errors, array('controller' => 'gwm_main')) ?>
	<form action="" method="post" class="form-stacked">
		<fieldset>
			<div class="row">
				<div class="span4">
					<label for="current_field">Senha atual <input type="password" name="data[current]" id="current_field" /></label>
				</div>
			</div>

			<div class="row">
				<div class="span4">
					<label for="new_field">Nova Senha <input type="password" name="data[new]" id="new_field" /></label>
				</div>
			</div>

			<div class="row">
				<div class="span4">
					<label for="confirm_field">Confirmar Nova Senha <input type="password" name="data[confirm]" id="confirm_field" /></label>
				</div>
			</div>
		</fieldset>

		<a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
		<a href="<?= $this->site_url('') ?>" class="cancel-form">Cancelar</a>
	</form>
</section>