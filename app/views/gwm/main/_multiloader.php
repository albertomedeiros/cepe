<h4>Objetos multimídia <a href="#" title="Inserir" class="button" id="insertObject1">Inserir</a></h4>

<div id="multimidia" class="fundoEscuro">&nbsp;</div>
<div id="multiContent" class="content">
	<iframe frameborder="0" width="100%" height="100%" marginheight="0" marginwidth="0" scrolling="no" id="frameMultimidia"></iframe>
</div>
<!-- FIM AREA COMUM --> 

<!-- OBJETO MULTIMIDIA 1-->
<div class="box obMultimidia">
	<div id="showArea1" class="md"></div>
</div>
<input type="hidden" id="hidObjects1" name="data[objects]" value="" />
<input type="hidden" id="hidModuleObjectId1" value="<?= $this->id ?>" />

<div class="contextMenu" id="objSetMenu">
	<ul>
		<li id="cMnuSetDefault"><span class="cMnuSetDefault">definir como principal</span></li>
	</ul>
</div>
<script type="text/javascript">
	if (typeof (Sys) !== "undefined") Sys.Application.notifyScriptLoaded();
	
	$(document).ready(function () {
		var __active = false;
		var __div = null;
		var __moduleTypeId = '<?= $module ?>';
		var multimidia = $("#multimidia");

		//Chama objetos multimídia 1
		var maxSelectedObjects1 = 3;
		var insertObj1 = $("#insertObject1");
		var hidObjects1 = $("#hidObjects1");
		var showArea1 = $("#showArea1");
		__objModMulti1 = initObjects(multimidia, hidObjects1, showArea1, "getObjects1", "getObjectsCounter1", "setSelectedObjects1", "setMain1", maxSelectedObjects1);
		__objModMulti1.LoadModuleObjects($("#hidModuleObjectId1").val(), __moduleTypeId);
		
		$(insertObj1).click(function () {
			__objModMulti1.OpenMultimidia();

			return false;
		});
	});

	//Funções do loader 1 
	function getObjectActual1() {
		return __objModMulti1;
	}
	function getObjects1() {
		return __objModMulti1.a_modObjects;
	}
	function setMain1(newObjMain) {
		return __objModMulti1.SetMain(newObjMain);
	}
	function getObjectsCounter1() {
		return __objModMulti1.countObjects;
	}
	function setSelectedObjects1(aObj, count) {
		__objModMulti1.SetSelectedObjects(aObj, count);
	}
</script>