<!DOCTYPE html>
<html>
<head>
	<title>Galerias de Objetos Multimídia</title>

	<link rel="stylesheet" type="text/css" href="<?= $this->public_url('css/main.css') ?>" media="screen"/>

	<script src="<?= $this->public_url('js/jquery/jquery.js') ?>"></script>
	<script src="<?= $this->public_url('js/objects_menuGallery.js') ?>"></script>
	<script src="<?= $this->public_url('js/jquery/contextMenu/contextMenuObjectsMenu.js') ?>"></script>
</head>
<body style="padding:0 0 30px;position:relative">

	<div class="colA popUp" style="width:auto">
		<ul class="atalhos">
			<li class="bt1"><a href="javascript:newFolderSel()" title="Criar nova pasta">Criar nova pasta</a></li>
			<li class="bt2"><a href="javascript:editFolderSel()" title="Renomear pasta">Editar pasta</a></li>
			<li class="bt3"><a href="javascript:delFolderSel()" title="Deletar pasta">Deletar pasta</a></li>
		</ul>
		
		<div id="menu" class="colA">
			<label id="menuContent">
				<ul id="navMnuObj">
					<li>
						<img src="<?= $this->public_url('img/none.gif') ?>" alt=""/>
						<span><a id="a_rec" href="javascript:openRecent()" class="openRec" style="font-weight:700">Recentes</a></span>
					</li>

					<?php foreach ($galleries as $gallery): ?>
						<li id="li_<?= $gallery->id ?>">
							<a href="javascript:colapse('ul_<?= $gallery->id ?>')"><img src="<?= $this->public_url('img/expandable.gif') ?>" alt=""/></a>
							<span><a id="a_<?= $gallery->id ?>" href="javascript:openGal(<?= $gallery->id ?>,'a_<?= $gallery->id ?>')" class="close"><?= $gallery->name ?></a>
							</span>
							<ul id="ul_<?= $gallery->id ?>" style="display:none"></ul>
						</li>
					<?php endforeach ?>
				</ul>
			</label>
		</div>
	</div>

	<!--Menus de Contexto-->
	<div class="contextMenu" id="folderMenu">
		<ul>
			<li id="cMnuNew"><span class="cMnuNewFolder">Nova</span></li>
			<li id="cMnuEdit"><span class="cMnuEditFolder">Editar</span></li>
			<li id="cMnuDel"><span class="cMnuDelFolder">Deletar</span></li>
		</ul>
	</div>
</body>
</html>