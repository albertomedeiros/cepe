<!DOCTYPE html>
<html>
<head>
	<title>GWM - Objetos</title>

	<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/main.css') ?>" media="screen"/>
	<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/facebox.css') ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/faceboxConfirm.css') ?>" media="screen" />

	<script>
		var __base_url = '<?= $this->site_url("") ?>';
	</script>

	<script src="<?= $this->public_url('js/jquery/Jquery_latest.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/jquery.dimensions.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.mouse.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.draggable.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.draggable.ext.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.droppable.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.droppable.ext.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/ui.sortable.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/contextMenu/contextMenuObjects.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/facebox/facebox.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/facebox/faceboxConfirm.js') ?>"></script>

	<!-- FROMULÁRIOS -->
	<script src="<?= $this->public_url('js/objects.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/charcount.js') ?>"></script>
	<script src="<?= $this->public_url('js/effects.js') ?>"></script>

	<!-- CARGA DA GALERIA PARA MOSTRAR-->
	<script>
		objectGalleryId = "<?= $this->objectGalleryId ?>";
		page = "<?= $this->page ?>";
		query = "<?= $this->query ?>";
		//Pega string do array de objetos e string da função de callback enviadas pela página solicitante
		objGetFunc = "<?= $this->objGetFunc ?>";
		objCountFunc = "<?= $this->objCountFunc ?>";
		frmObjMaxDrops = "<?= $this->objMaxDrops ?>";
		objCbFunc = "<?= $this->objCbFunc ?>";
	</script>
</head>
<body>
	<div id="mainDrag" class="colB popUp" style="padding:0">
		<div class="box obMultimidia">
			<div id="dragArea" class="dragArea"></div>
		</div>

		<div id="paging" class="pag obMultimidia">
			<ul>
				<li id="pagingFirst"></li>
				<li id="pagingNextLeft"></li>
				<li id="thisPage" class="paginas"></li>
				<li id="pagingNextRight"></li>
				<li id="pagingLast"></li>
				<li id="liPagingText" style="padding:0 10px;"></li>
				<li id="liPaging">
				</li>
			</ul>
		</div>

		<div id="moveFirst" class="moveFirst">
			<a href="javascript:scrollFirst()" class="bt1" title="Primeiras fotos">Primeiras fotos</a>
		</div>
		<div id="moveNextLeft" class="moveNextLeft">
			<a href="javascript:scrollLeft()" class="bt2" title="Fotos anteriores">Fotos anteriores</a>
		</div>
		<div id="moveNextRight" class="moveNextRight">
			<a href="javascript:scrollRight()" class="bt3" title="Próximas fotos">Próximas fotos</a>
		</div>
		<div id="moveLast" class="moveLast">
			<a href="javascript:scrollLast()" class="bt4" title="Últimas fotos">Últimas fotos</a>
		</div>
	
		<!--AREA DE DROP-->
		<div id="dropArea" class="dropArea">
			<div id="sep" class="objSep"><img src="<?= $this->public_url('img/sep.gif') ?>" /></div>
		</div>

		<ul id="functionButtons" class="btsPublicCont obMult">
			<li class="bts"><span><a href="javascript:removeAll()">Limpar Seleção</a></span></li>
			<li class="bts"><span><a href="javascript:copyMoveSelected(1)">Copiar Aqui</a></span></li>
			<li class="bts"><span><a href="javascript:copyMoveSelected(0)">Mover Aqui</a></span></li>
			<li class="bts"><span><a href="javascript:insertSelected()">Atualizar no Conteúdo</a></span></li>
		</ul>

		<!--Menus de Contexto-->
		<div class="contextMenu" id="dragMenu">
			<ul>
				<li id="cMnuView"><span class="cMnuView">Visualizar</span></li>
				<li id="cMnuEdit"><span class="cMnuEdit">Editar</span></li>
				<li id="cMnuDel"><span class="cMnuDel">Excluir</span></li>
			</ul>
		</div>

		<div class="contextMenuDrop" id="dropMenu">
			<ul>
				<li id="cMnuClear"><span class="cMnuClear">Remover da Seleção</span></li>
				<li id="cMnuCopy"><span class="cMnuCopy">Copiar Aqui</span></li>
				<li id="cMnuMove"><span class="cMnuMove">Mover Aqui</span></li>
				<li id="cMnuInsert"><span class="cMnuInsert">Atualizar no Conteúdo</span></li>
			</ul>
		</div>

		<div id="counter" class="counter"></div>
	</div>

	<div id="editArea" class="editArea">
		<iframe src="about:blank" width="100%" height="100%" frameborder="0" id="iEditArea" marginheight="0" marginwidth="0" scrolling="no"></iframe>
	</div>

	<!-- <div id="debug" class="debug">debug</div> -->
</body>
</html>