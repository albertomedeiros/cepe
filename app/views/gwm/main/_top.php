<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/main.css') ?>" media="screen">
    <link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/facebox.css') ?>" media="screen" >
    <link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/faceboxConfirm.css') ?>" media="screen">    

    <script>
    	var __base_url = '<?= $this->site_url("") ?>';
    </script>
    <script src="<?= $this->public_url('js/jquery/Jquery_latest.js') ?>"></script>
    <script src="<?= $this->public_url('js/objects_top.js') ?>"></script>
    <script src="<?= $this->public_url('js/jquery/facebox/facebox.js') ?>"></script>
    <script src="<?= $this->public_url('js/jquery/facebox/faceboxConfirm.js') ?>"></script>
</head>

<body>
	<div class="topo">
		<div class="hd">
			<div class="boxBusca">
				<h2><a href="#" title="Notícias">Objetos Multimídia</a></h2>
				<ul>
					<li class="btNovoOb"><a href="javascript:newObject()" title="Inserir novo objeto">Inserir novo objeto</a></li>
					<li>
						<fieldset>
							<legend>Formulário de Busca</legend>
							<ul>
								<li><label for="busca">Faça sua busca:</label></li>
								<li><input name="busca" id="busca" class="textbox" maxlength="250" type="text"/></li>
								<li>
									<select id="cboObjectTypeId" name="cboObjectTypeId">

									</select>
								</li>
								<li><input name="buscar" value="buscar" class="botaoBuscar" type="image" src="<?= $this->public_url('img/btBuscar.gif') ?>" alt="Buscar" onclick="javascript:runQuery()" /></li>
							</ul>

						</fieldset>
					</li>
					<li class="btFechar"><a href="javascript:closeWindow()" title="Fechar Janela">Fechar Janela</a></li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>