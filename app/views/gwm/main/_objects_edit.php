<!DOCTYPE html>
<html>
<head>
	<title>GWM</title>
	<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/main.css') ?>" media="screen"/>

	<script>
    	var __base_url = '<?= $this->site_url("") ?>';
    </script>
	<script src="<?= $this->public_url('js/jquery/Jquery_latest.js') ?>"></script>
	<script src="<?= $this->public_url('js/validator/GwmValidator.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/jquery.js') ?>"></script>
	<script src="<?= $this->public_url('js/objects_edt.js') ?>"></script>
	
	<script src="<?= $this->public_url('js/jquery/facebox/facebox.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/facebox/faceboxConfirm.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/contextMenu/contextMenu.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/jquery.dimensions.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.mouse.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.draggable.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.draggable.ext.js') ?>"></script>
</head>
<body class="colB">
	<div class="colB">
		<form method="post" action="<?= $this->site_url('main/object_save') ?>" id="aspnetForm" enctype="multipart/form-data" class="formCadastro">
			<input type="hidden" name="id" id="objectId" value="<?= $this->objectId ?>">
			<input type="hidden" name="gallery_id" id="objectGalleryId" value="<?= $this->objectGalleryId ?>">
			<input type="hidden" name="hidAction" id="hidAction" value="insert">
			<p class="descPagina">Cadastro de Objetos</p>

			<!-- INICIO DA AREA COMUM -->
			<div class="colLeft">
				<div id="divError" class="msg neg" style="display:none;">
					<h4>Erro!</h4>
					<p>Atenção os campos em destaque possuem entradas inválidas.</p>
				</div>
				<div class="linhas">
					<div id="divObjectTypeId" class="line alt">
						<label id="labelObjectTypeId" for="lstObjectTypeId" style="width:100px">Tipo de Objeto</label>
						<select id="lstObjectTypeId" name="type">
							<option value="#">-- Tipo --</option>
							<?php foreach ($this->types as $type): ?>
							<option value="<?= $type->ext ?>" <?= $type->ext == 'jpg' ? 'selected="selected"' : '' ?>><?= $type->name ?></option>
							<?php endforeach ?>
						</select>
						<span id="divZip"><input id="chkZip" type="checkbox" onchange="selZip(this)" /> Compactado (zip)</span>
					</div>

					<div id="divObjectDescription" class="line">
						<label id="labelObjectDescription" for="txtObjectDescription" class="label" style="width:100px;">Descrição</label>
						<input type="text" id="txtObjectDescription" name="description" style="width:355px;" />
						<select name="zip_description" id="lstZipType" style="display:none; width: 200px;">
							<option value="#">-- Utilização da descrição --</option>
							<option value="1">Utilizar o nome original da foto</option>
							<option value="2">Não utilizar o nome original da foto</option>
							<option value="3">Mesclar</option>
						</select>
					</div>

					<div id="divObjectAuthor" class="line alt">
						<label id="labelObjectAuthor" for="txtObjectAuthor" class="label" style="width:100px">Créditos</label>
						<input type="text" id="txtObjectAuthor" name="author" style="width:355px;" />
					</div>

					<div id="divObjectBlob" class="line">
						<label id="labelObjectBlob" for="txtObjectBlob" class="label" style="width:100px">Objeto</label>
						<input type="file" id="txtObjectBlob" name="blob" />
						<!-- <input type="text" id="txtObjectUrl" name="url" style="width:355px;display:none;" />
						<span id="divType"><input id="chkType" type="checkbox" onchange="selType(this)" /> Externo</span> -->
					</div>
				</div>
			</div>
			<ul class="btsPublicCont" style="padding:20px 0 0 0">
				<li class="bts left">
					<span><a href="javascript:restoreObjects()">Cancelar</a></span>
				</li>
				<li class="bts">
					<span><a id="lnkSave" title="Salvar" href="#" onclick="javascript: return validateADD();">Salvar</a></span>
				</li>
			</ul>
		</form>
	</div>
	<script type="text/javascript">
		function restoreObjects()
		{
			window.parent.hideEditArea();
			window.parent.loadObjects();
		}

		if (status == "cancel") {
			restoreObjects();
		}
	</script>
</body>
</html>