//variavel que guarda o obj que abriu a ultima janela de obj multimidia
var __openedObjInstance = null;

//countObjects = 0;                       //Quantidade de objetos vinculados
//sepSizeObjects = 10;                    //Largura do separador da área de exibição    
//objectWidth = 90;                       //Largura do objeto
//objectHeight = 67;                      //Altura do objeto

//objGetFunc = "getObjects"               //String nome da função que a janela dos objetos deve chamar para pegar os objetos do conteúdo
//objCountFunc = "getObjectsCounter"      //String nome da função que a janela de objetos deve chamar para pegar a quantidade de objetos do conteúdo
//objMaxDrops = "100"                     //Quantidade máxima de objetos que o conteúdo aceita como retorno
//objCbFunc = "setSelectedObjects"        //String nome da função de callback que a janela dos objetos deve chamar para atualizar os objetos na janela do conteúdo editado

/************************************************************************************/
// Objeto ObjMultiLoader
/************************************************************************************/
/// <summary>
/// Cria um objeto com todas as funções necessárias para adicionar objetos multimídia
/// a uma determinada área da página
/// </summary>
/// <param name="objLauncher">Objeto que inicia a janela de objetos multimídia</param>
/// <param name="showArea">Área que mostra os objetos multimídia</param>
/// <param name="sepSizeObjects">Largura ou altura do separador da área de exibição</param>
/// <param name="objectWidth">Largura do objeto</param>
/// <param name="objectHeight">Altura do objeto</param>
/// <param name="objGetFunc">String nome da função que a janela dos objetos deve chamar para pegar os objetos do conteúdo</param>
/// <param name="objCountFunc">String nome da função que a janela de objetos deve chamar para pegar a quantidade de objetos do conteúdo</param>
/// <param name="objMaxDrops">Quantidade máxima de objetos que o conteúdo aceita como retorno</param>
/// <param name="objCbFunc">String nome da função de callback que a janela dos objetos deve chamar para atualizar os objetos na janela do conteúdo editado</param>
function ObjMultiLoader(showArea, sepSizeObjects, objectWidth, objectHeight, objGetFunc, objCountFunc, objCbFunc, objSetMainFunc, objMaxDrops, hidObjects){
	//Quantidade de objetos vinculados
	this.countObjects = 0;
	this.showArea = showArea;
	this.sepSizeObjects = sepSizeObjects;
	this.objectWidth = objectWidth;
	this.objectHeight = objectHeight;
	this.objGetFunc = objGetFunc;
	this.objCountFunc = objCountFunc;
	this.objSetMainFunc = objSetMainFunc;
	this.objMaxDrops = objMaxDrops;
	this.objCbFunc	 = objCbFunc;
	this.hidObjects = hidObjects;
	
	//Div que tem o iframe dos objetos multimídia
	this.multi = document.getElementById("multiContent");
	//iFrame que está dentro do Div (contém os objetos multimídia)
	this.frameMultimidia = document.getElementById("frameMultimidia");
	//Div do fundo escuro
	this.darkBack = document.getElementById("multimidia");
	
	//Array de objetos
	this.a_modObjects;
	
}

var len = 166;
var close = false;
var __boundFrames = true;




function ObjMultiLoader_openMultimidia() {

	this.ActivateMultimidia(this);
}
ObjMultiLoader.prototype.OpenMultimidia = ObjMultiLoader_openMultimidia;

function ObjMultiLoader_activateMultimidia(iAm) {
	iAm.darkBack.style.display = "block";
	iAm.darkBack.style.visibility = "visible";
	iAm.darkBack.style.zIndex = 999;
	
	(iAm.multi).style.display = "block";
	(iAm.multi).style.visibility = "visible";
	(iAm.multi).style.zIndex = 9999;
	
    if(iAm.halfFrame == '[object HTMLFrameElement]' || iAm.halfFrame == '[object]'){
	    (iAm.halfFrame).contentWindow.block = true;
	}
	
	//iFrame que está dentro do Div (contém os objetos multimídia)
	$(iAm.frameMultimidia).attr("src",__base_url + "main/objects?objGetFunc=" + iAm.objGetFunc + "&objCountFunc=" + iAm.objCountFunc + "&objMaxDrops=" + iAm.objMaxDrops + "&objCbFunc=" + iAm.objCbFunc);
	
	__openedObjInstance = iAm;
	adjustMultimidia(iAm.multi);		
	//alert(iAm);
}
ObjMultiLoader.prototype.ActivateMultimidia = ObjMultiLoader_activateMultimidia;

function ObjMultiLoader_loadModuleObjects(moduleObjId,moduleTypeId){
	if(moduleObjId != "" && moduleObjId != undefined){
		//Seta tamanho inicial da área de Show
		//$(this.showArea).css("height","80px");

		//Loader
			//Limpa área de drag
			$(this.showArea).html("");

			loaderImg = document.createElement("IMG");
			loaderImg.src = __base_url + "../public/gwm/img/loader.gif";
			$(loaderImg).css("position","absolute");

			//Inserer em dragArea
			$(this.showArea).append(loaderImg);

			//Pega tamanho do loader
			loaderWidth = parseInt($(loaderImg).css("width").replace("px",""));
			loaderHeight = parseInt($(loaderImg).css("height").replace("px",""));;

			//seta posição do loader
			loaderTop = 0;
			loaderLeft = 0;

			$(loaderImg).css("top",loaderTop.toString() + "px");
			$(loaderImg).css("left",loaderLeft.toString() + "px");
		//Fim loader

		//Reseta posicionamentos
		newTopObj = this.sepSizeObjects;
		newLeftObj = this.sepSizeObjects;

		//Define a query / página
		objectsSrc = __base_url + "main/getObjectsByModuleObjId/?moduleObjId=" + moduleObjId + "&moduleTypeId=" + moduleTypeId;

		iAm = this;
		//Lê xml dos objetos
		$.ajax({
			async:	true,
			cache:	false,
			dataType:	"xml",
			timeout:	25000,
			type:	"get",
			url:		objectsSrc,
			error:	function(){
						//Seta tamanho inicial da área de Show
						//r$(iAm.showArea).css("height","0px");
						$.facebox("erro ao carregar xml dos objetos");
					},
			success:	function(data, textStatus){
                   
						//Monta array de objetos
						iAm.a_modObjects = new Array($("object", data).length);

						//Limpa área de exibição
						$(iAm.showArea).html("");

						aStr = "";

						if($("object", data).length > 0){

							className = "objImgFrmFirst";

							$("object", data).each(function(){
								objectId = $(this).attr("id");
								objectType = $("type", this).text();
								objectDescription = $("description",this).text();
								objectAuthor = $("author",this).text();
								objectPostDate = $("postDate",this).text();
								objectSrcThumb = $("srcThumb",this).text();
								objectSrcView = $("srcView",this).text();

								//Imagem 
								oImg = document.createElement("IMG");
								oImg.src = objectSrcThumb;
								oImg.className = className;
								oImg.alt = objectDescription;
								oImg.id = (objectId).toString();
								$(iAm.showArea).append(oImg);

								//Dimensiona e posiciona Arrastável
								//$(oImg).css("z-index",11);
								$(oImg).css("width",iAm.objectWidth);
								$(oImg).css("height",iAm.objectHeight);
								$(oImg).css("left",newLeftObj.toString() + "px");
								$(oImg).css("top",newTopObj.toString() + "px");

                                //Define menu de contexto
								newContextMenu(oImg, "objSetMenu", iAm.objSetMainFunc);

								//Armazena referência no array
								(iAm.a_modObjects)[iAm.countObjects] = new objContDropped(objectId,oImg,newLeftObj,newTopObj,objectType,objectDescription,objectAuthor,objectPostDate,objectSrcThumb,objectSrcView);

								//Concatena objectIds para compor o input do form
								aStr += objectId.toString() + ",";

								//Inicializa click
								$(oImg).click(function(){
									objDrop = iAm.GetDropped(this);
									startFacebox(objDrop.objectSrcView,objDrop.objectDescription,objDrop.objectAuthor,objDrop.objectPostDate);
								})

								//Determina a posição do próximo objeto
								newLeftObj = newLeftObj + iAm.objectWidth + iAm.sepSizeObjects;

								(iAm.countObjects)++;

								className = "objImgFrm";
							});

							//Remove a última virgula
							aStr = aStr.substring(0,aStr.length -1);
							
							if(iAm.hidObjects != null){
								//Adiciona a string ao hidden
								$(iAm.hidObjects).val(aStr);
							}
						}else{
							//Seta tamanho inicial da área de Show
							//$(iAm.showArea).css("height","0px");
						}
					}
			//success (FIM)
		})
	}else{
	    this.a_modObjects = new Array(0);
	}
}
ObjMultiLoader.prototype.LoadModuleObjects = ObjMultiLoader_loadModuleObjects;

function ObjMultiLoader_setSelectedObjects(aObj,count) {

	this.a_modObjects = new Array(count);

	this.countObjects = count;    
	newLeftObj = this.sepSizeObjects;
	newTopObj = this.sepSizeObjects;

	aStr = "";

	for(var i = 0;i<count;i++){
		aStr += aObj[i].objectId.toString() + ",";
	}
	
	//Remove a última virgula
	aStr = aStr.substring(0,aStr.length -1);

	//Adiciona a string ao hidden
	$(this.hidObjects).val(aStr);

	//Define a query / página
	objectsSrc = __base_url + "main/getObjectsByObjId/?aObj=" + aStr;

	//Seta tamanho inicial da área de Show

	iAm = this;
	//Lê xml dos objetos
	$.ajax({
		async:	true,
		cache:	false,
		dataType:	"xml",
		timeout:	25000,
		type:	"get",
		url:		objectsSrc,
		error:	
			function(){
				//Seta tamanho inicial da área de Show
				//$(iAm.showArea).css("height","0px");
				$.facebox("erro ao carregar xml dos objetos");
			},
		success:	
			function(data, textStatus){
				//Monta array de objetos
				iAm.a_modObjects = new Array($("object", data).length);

				//Limpa área de exibição
				$(iAm.showArea).html("");

				iAm.countObjects = 0;
				if($("object", data).length > 0){
					className = "objImgFrmFirst";
					
					$("object", data).each(function(){

						objectId = $(this).attr("id");
						objectType = $("type", this).text();
						objectDescription = $("description",this).text();
						objectAuthor = $("author",this).text();
						objectPostDate = $("postDate",this).text();
						objectSrcThumb = $("srcThumb",this).text();
						objectSrcView = $("srcView",this).text();

						//Imagem 
						oImg = document.createElement("IMG");
						oImg.src = objectSrcThumb;
						oImg.className = className;
						oImg.alt = objectDescription;
						oImg.id = (objectId).toString();
						$(iAm.showArea).append(oImg);

						//Dimensiona e posiciona Arrastável
						$(oImg).css("width",iAm.objectWidth);
						$(oImg).css("height",iAm.objectHeight);
						$(oImg).css("left",newLeftObj.toString() + "px");
						$(oImg).css("top",newTopObj.toString() + "px");
						
						//Define menu de contexto
						newContextMenu(oImg, "objSetMenu", iAm.objSetMainFunc);

						//Armazena referência no array
						(iAm.a_modObjects)[iAm.countObjects] = new objContDropped(objectId,oImg,newLeftObj,newTopObj,objectType,objectDescription,objectAuthor,objectPostDate,objectSrcThumb,objectSrcView);

						//Inicializa click
						$(oImg).click(function(){
							objDrop = iAm.GetDropped(this)
							startFacebox(objDrop.objectSrcView,objDrop.objectDescription,objDrop.objectAuthor,objDrop.objectPostDate);
						})

						//Determina a posição do próximo objeto
						newLeftObj = newLeftObj + iAm.objectWidth + iAm.sepSizeObjects;

						(iAm.countObjects)++;

						className = "objImgFrm";
					});
				}else{
					//Seta tamanho inicial da área de Show
					//$(iAm.showArea).css("height","0px");
				}
				if (iAm.isVch) {
					document.getElementById('txtMsg').value = document.getElementById('showArea').innerHTML;
					document.getElementById('showArea').innerHTML = "";
					document.getElementById('hidObjects').value = "";
					iAm.a_modObjects = new Array();
					iAm.countObjects = 0;
				}
			}
			//success (FIM)
	});
}
ObjMultiLoader.prototype.SetSelectedObjects = ObjMultiLoader_setSelectedObjects;

function ObjMultiLoader_getDropped(element){
    for(var i = 0; i<(this.countObjects);i++){
        var objContDropped = (this.a_modObjects)[i];
        
        if(objContDropped.objectId == parseInt($(element).attr("id"))) {
            return objContDropped;
        }
    }
}
ObjMultiLoader.prototype.GetDropped = ObjMultiLoader_getDropped;

function ObjMultiLoader_setMain(newMain){
    
    iAm = this;
    
    oldMain = iAm.a_modObjects[0];
    oldLeft = iAm.a_modObjects[0].newLeft;
    newLeft = iAm.a_modObjects[newMain].newLeft;
    
    iAm.a_modObjects[0] = iAm.a_modObjects[newMain];
    iAm.a_modObjects[newMain] = oldMain;

    //Redefine posições    
    iAm.a_modObjects[newMain].newLeft = newLeft;
    iAm.a_modObjects[0].newLeft = oldLeft;

    //Define a classe diferenciada do primeiro
    className = "objImgFrmFirst";
    
    //Remove todos objetos e insere na nova ordem
    $(iAm.showArea).html("");

    aStr = "";

    for(var i = 0; i < iAm.a_modObjects.length ; i++){
		objectId = iAm.a_modObjects[i].objectId;
		objectType = iAm.a_modObjects[i].objectType;
		objectDescription = iAm.a_modObjects[i].objectDescription;
		objectAuthor = iAm.a_modObjects[i].objectAuthor;
		objectPostDate = iAm.a_modObjects[i].objectPostDate;
		objectSrcThumb = iAm.a_modObjects[i].objectSrcThumb;
		objectSrcView = iAm.a_modObjects[i].objectSrcView;

		//Imagem 
		oImg = document.createElement("IMG");
		oImg.src = objectSrcThumb;
		oImg.className = className;
		oImg.alt = objectDescription;
		oImg.id = (objectId).toString();
		$(iAm.showArea).append(oImg);

		//Dimensiona e posiciona Arrastável
		$(oImg).css("width",iAm.objectWidth);
		$(oImg).css("height",iAm.objectHeight);
		$(oImg).css("left",newLeftObj.toString() + "px");
		$(oImg).css("top",newTopObj.toString() + "px");
        
        //Define menu de contexto
		newContextMenu(oImg, "objSetMenu", iAm.objSetMainFunc);

		//Inicializa click
		$(oImg).click(function(){
			objDrop = iAm.GetDropped(this)
			startFacebox(objDrop.objectSrcView,objDrop.objectDescription,objDrop.objectAuthor,objDrop.objectPostDate);
		})

		//Determina a posição do próximo objeto
		newLeftObj = newLeftObj + iAm.objectWidth + iAm.sepSizeObjects;

		//Concatena objectIds para compor o input do form
		aStr += objectId.toString() + ",";

		className = "objImgFrm";
    }
    
	//Remove a última virgula
	aStr = aStr.substring(0,aStr.length -1);
	
	//Adiciona a string ao hidden
	$(iAm.hidObjects).val(aStr);
	
}

ObjMultiLoader.prototype.SetMain = ObjMultiLoader_setMain;

/************************************************************************************/
/************************************************************************************/

function adjustMultimidia(multi) {
	//Pega o tamanho da janela
	var windowSize = getWindowSize();
	var width = parseInt($(multi).css("width").replace("px",""));
	var height = parseInt($(multi).css("height").replace("px",""));
	
	var halfX = Math.round(windowSize[0] / 2) - Math.round(width / 2);
	var halfY = Math.round(windowSize[1] / 2) - Math.round(height / 2);
	
	(multi).style.left = halfX + "px";
	(multi).style.top = halfY + "px";
	(multi).style.visibility = "visible";
}

/*Função que serve pra todos*/
function startFacebox(url,caption,author,postDate) {
    var oDivAll = document.createElement("DIV");
    var oDivObj = document.createElement("DIV");
    var oIframe = document.createElement("IFRAME");
    var oDivText = document.createElement("DIV");
    var footerStr = caption + " | " + author + " | " + postDate;
    
    //Iframe
    $(oIframe).attr("src",url);
    $(oIframe).attr("width","100%");
    $(oIframe).attr("height","100%");
    $(oIframe).attr("frameborder","0")
    $(oIframe).attr("marginwidth","0")
    $(oIframe).attr("marginheight","0")
    $(oIframe).attr("scrolling","no")
    
    //Div do Iframe
    $(oDivObj).css("width","400px");
    $(oDivObj).css("height","300px");

    $(oDivObj).append(oIframe);
    $(oDivText).text(footerStr);
    $(oDivAll).append(oDivObj);
    $(oDivAll).append(oDivText);
    
    $.facebox(oDivAll);

}
function closeObjMultimidia() {

	try{
	    (__openedObjInstance.halfFrame).contentWindow.block = false;
    }catch(e){}	    
    __openedObjInstance.darkBack.style.display = "none";
    __openedObjInstance.darkBack.onclick = null;
    (__openedObjInstance.multi).style.visibility = "hidden";
    (__openedObjInstance.multi).style.display = "none";
    $(__openedObjInstance.frameMultimidia).attr("src","");		
    
}


/*Função que serve pra todos*/
//Objetos arrastado
function objContDropped(objectId,obj,newLeftObj,newTopObj,objectType,objectDescription,objectAuthor,objectPostDate,objectSrcThumb,objectSrcView){
    this.objectId = objectId;
    this.obj = obj;
    this.newLeft = newLeftObj;
    this.newTop = newTopObj;
    this.objectType = objectType;
    this.objectDescription = objectDescription;
    this.objectAuthor = objectAuthor;
    this.objectPostDate = objectPostDate;
    this.objectSrcThumb = objectSrcThumb;
    this.objectSrcView = objectSrcView;
}

function newContextMenu(obj,mnuElement,fSetMain){

    $(obj).contextMenu(mnuElement, {

        itemStyle: {
            color: "#333333",
            fontFamily: "Verdana, Arial",
            fontSize: "12px",
            fontWeight: "700"
        },
        bindings: {
            'cMnuSetDefault': function (t) {
                eval(fSetMain + "(getObjPos(t))");
            }
        }
    });    
}

function getObjPos(element){
    for(var i = 0; i<iAm.a_modObjects.length;i++){
        var obj = iAm.a_modObjects[i];
        if(obj.objectId == $(element).attr("id")) {
            return i;
        }
    }
}


/*
COPIE AS FUNÇÕES ABAIXO NA SUA PÁGINA OU ARQUIVO JS RENOMEANDO AS MESMAS
ESTAS FUNÇÕES SERÃO PASSADAS COMO PARÂMETRO PARA O CONSTRUTOR DO OBJETO "ObjMultiLoader"

//Cada objeto loadMultimidia tem a sua
function getObjects(){
    return objLoader.a_modObjects;
}

//Cada objeto loadMultimidia tem a sua
function getObjectsCounter(){
    return objLoader.countObjects;
}

//Cada objeto loadMultimidia tem a sua
function setSelectedObjects(aObj,count) {
	objLoader.SetSelectedObjects(aObj,count);
}
*/

