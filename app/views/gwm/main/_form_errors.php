<?php if (count($data) > 0): ?>
<div class="alert error">
	<a class="close" href="#">×</a>
	<p><strong>Atenção!</strong> Preencha corretamente os campos marcados.</p>
	<ul>
		<?php foreach ($data as $error): ?>
		<li><?= $error ?></li>
		<?php endforeach ?>
	</ul>
</div>
<?php endif ?>