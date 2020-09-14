
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
			<?php
				
				
			?>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/style.css') ?>">
		
		<!-- JS -->
		<script type="text/javascript" src="<?= $this->public_url('js/jquery.js') ?>"></script>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body id="login-page">
		<div id="login-wrap">
			<h1>GWM Lite</h1>
			<form class="login" action="<?= $this->site_url('login') ?>" rel="<?= $this->url_to($this->backurl) ?>" method="post" id="frm-login">
				<fieldset>
					<div class="left">
						<img src="<?= $this->public_url('img/content/client-logo.png') ?>" alt="Logo do cliente">
						<p>Produto licenciado.</p>
					</div>
					<div class="right">
						<label>
							Login
							<input id="login" name="login">
						</label>
						<label>
							Senha
							<input type="password" id="password" name="password">
						</label>
						<!-- <a href="#" title="Esqueceu a senha?">Esqueceu a senha?</a> -->
						<input type="submit" class="button" value="Logar">
						
						<p class="error hide">Preencha os campos corretamente.</p>
					</div>
				</fieldset>
			</form>
			<a href="http://www.fishy.com.br" title="Desenvolvido pela Fishy" rel="external" class="developer">By Fishy</a>
		</div><!-- #login-wrap -->
		
		<script type="text/javascript" src="<?= $this->public_url('js/functions.js') ?>"></script>
	</body>
</html>