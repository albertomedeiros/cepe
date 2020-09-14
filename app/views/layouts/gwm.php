<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>GWM Lite — Desenvolvido pela Fishy</title>
		
		<meta http-equiv="content-type" content="text/html;charset=UTF-8">
		<meta name="author" content="Fishy — http://fishy.com.br">
		<meta name="Description" content="">
		<meta name="Keywords" content="">

		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" type="image/x-icon" href="favicon.png">

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/style.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/main.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/facebox.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/faceboxConfirm.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/jquery-ui.min.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('js/ui/jquery.ui.timepicker.addon.css') ?>">

		<!-- JS -->
		<script>
			var __base_url = '<?= $this->site_url("") ?>';
		</script>

		<script src="<?= $this->public_url('js/jquery.js') ?>"></script>
		<script src="<?= $this->public_url('js/Global.js') ?>"></script>
		<script src="<?= $this->public_url('js/effects.js') ?>"></script>
		<script src="<?= $this->public_url('js/jquery/facebox/facebox.js') ?>"></script>
		<script src="<?= $this->public_url('js/jquery/facebox/faceboxConfirm.js') ?>"></script>
		<script src="<?= $this->public_url('js/jquery/contextMenu/contextMenu.js') ?>"></script>
		<script src="<?= $this->public_url('js/jquery/jquery.dimensions.js') ?>"></script>
		<script src="<?= $this->public_url('js/objects_objMultiLoader.js') ?>"></script>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div id="wrap">
			<header>
				<div class="wrapper">
					<h1><a href="<?= $this->site_url('') ?>" title="GWM Lite — Voltar para a página inicial">GWM Lite</a></h1>
					
					<div class="client-area">
						<a href="#" title="Abrir opções" class="open-options">Olá <span><em><?= $this->user->name ?></em></span></a>
						<ul>
							<li><a href="<?= $this->gwm_change_password_url() ?>" title="Editar Perfil">Editar Perfil</a></li>
							
							<?php if ($this->user->allow_user()): ?>
							<li><a href="<?= $this->site_url('user') ?>" title="Editar Usuários">Editar Usuários</a></li>
							<?php endif ?>
							
							<li class="logout"><a href="<?= $this->site_url('logout') ?>" title="Sair">Sair</a></li>
						</ul>
					</div>
				</div><!-- .wrapper -->
			</header>
			<section id="container">
				<?php if ($this->flash_msg): ?>
					<?= $this->flash_msg ?>
				<?php endif ?>

				<?php if ($this->logged()): ?>
					<?php $this->render_partial('menu', null, array('controller' => 'gwm_main')) ?>
				<?php endif ?>

				<section id="content">
					<?php if ($this->title_bar): ?>
					<ul class="breadcrumbs">
						<li><a href="<?= $this->site_url('') ?>" title="GWMcms">GWMcms</a>/</li>
						<li><span><?= $this->title_bar ?></span></li>
					</ul><!-- .breadcrumbs -->
					<?php endif ?>

					<?= $content ?>
				</section>
			
			</section><!-- #container -->
			<footer>
				<p>Copyright Fishy <?= date('Y') ?>. Todos os direitos reservados.</p>
			</footer>
		</div><!-- #wrap -->

		<script src="<?= $this->public_url('js/tinymce/tinymce.js') ?>"></script>
		<script src="<?= $this->public_url('js/tablesorter.js') ?>"></script>
		<script src="<?= $this->public_url('js/jquery.maskedinput.min.js') ?>"></script>
		<script src="<?= $this->public_url('js/functions.js') ?>"></script>
		<script src="<?= $this->public_url('js/fishy_util.js') ?>"></script>
		<script src="<?= $this->public_url('js/jquery/jquery.dimensions.js') ?>"></script>
		<script src="<?= $this->public_url('js/ui/jquery-ui.min.js') ?>"></script>
		<script src="<?= $this->public_url('js/ui/jquery.ui.core.min.js') ?>"></script>
		<script src="<?= $this->public_url('js/ui/jquery.ui.datepicker.min.js') ?>"></script>
		<script src="<?= $this->public_url('js/ui/jquery.ui.slider.min.js') ?>"></script>
		<script src="<?= $this->public_url('js/ui/jquery.ui.timepicker.addon.js') ?>"></script>
	</body>
</html>