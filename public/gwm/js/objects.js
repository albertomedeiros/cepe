var frame = window.parent.frames["objects"];
var __base_url = frame.__base_url;

$(document).ready(function(){

    //Carrega menu
    objFrame = window.parent.frames["menu"];
    objFrame.location = "menu";
    
    countDrop = 0;                              //Quantidade de objetos arrastados para o container
    sepSizeDrag = 15;                           //Largura do separador da área de drag
    sepSize = 10;                               //Largura do separador da área de drop    
    maxDrops = 100;                             //Quantidade máxima de elementos no container
    maxObjPage = 15;                            //Quantidade de elementos na lista de arrastáveis
    newInsert = 0;                              //Posição da nova inserção
    animateVel = 500;                           //Velocidade da animação
    animating = false;                          //indica se tem animação em andamento
    loading = false;                            //Indica se exite galeria carregando
    objectTypeId = "#";                         //Tipo do objeto para a busca

    //Configurações da área de drop
    dragAreaHeight = "330px"                    //Altura da área de drag

    dropAreaWidth = "490px";                    //Largura da área de drop
    dropAreaHeight = "68px";                   //Altura da área de drop
    dropAreaTop = "408px"                       //Posição Y da área de drop
    dropAreaLeft = "60px"                      //Posição X da área de drop
    dropAreaDefaultBg = "#ffffff"               //Cor de fundo padrão da área de drop
    dropAreaActiveBg = "#cadae6"                //Cor de fundo da área de drop quando ativa
    dropAreaOverBorder = "1px dotted #007e99"   //Bordas da área de drop quando um elemento drag interceptar
    dropAreaDefaultBorder = "1px solid #000000"

    htmlDOMtmp = ""                             //Variável temporária para armazenamento do DOM

    //Configurações da área do objeto
    objectWidth = 105;                          //Largura do div do objeto
    objectHeight = 85;                         //Altura do div do objeto

    //Configurações da legenda
    legendHeight = 16                           //Altura da área da legenda

    //Configurações do objeto drag
    dragObjWidth = 90;                          //Largura do elemento arrastável
    dragObjHeight = 67;                         //Altura do elemento arrastável
    dragObjDefaultBorder = "1px solid #1a1a1a"; //Bordas default do objeto drag
    dragObjPadding = 8                          //Distância do container ao objeto 

    //Define estilos

    $("#dropArea").css("border",dropAreaDefaultBorder);
    
    $("#draggable").css("width",dragObjWidth);
    $("#draggable").css("height",dragAreaHeight);

    //Posiciona separador
    $("#sep").css("width",sepSize);
    $("#sep").css("height",dragObjHeight);
    $("#sep").css("top",sepSize);

    //Monta objetos arrastados
    a_dropped = new Array(maxDrops+1);
    for(i=0;i<a_dropped.length;i++) a_dropped[i] = new objDropped(0,null,0,0);

    dragAreaTop = parseInt($("#dragArea").css("top").replace("px",""));
    dragAreaLeft = parseInt($("#dragArea").css("left").replace("px",""));
    dragAreaWidth = parseInt($("#dragArea").css("width").replace("px",""));
    dragAreaHeight = parseInt($("#dragArea").css("height").replace("px",""));

    containerTop = parseInt($("#dropArea").css("top").replace("px",""));
    containerLeft = parseInt($("#dropArea").css("left").replace("px",""));
    containerHeight = parseInt($("#dropArea").css("height").replace("px",""));
    containerWidth = parseInt($("#dropArea").css("width").replace("px",""));        
    containerMaxY = (containerTop + containerHeight) + (2* sepSize);

    //Posiciona setas
    $("#moveFirst").css("left",containerLeft-41);
    $("#moveFirst").css("top",containerTop);

    $("#moveNextLeft").css("left",containerLeft-21);
    $("#moveNextLeft").css("top",containerTop);

    $("#moveNextRight").css("left",containerLeft+containerWidth+22);
    $("#moveNextRight").css("top",containerTop);

    $("#moveLast").css("left",containerLeft+containerWidth+42);
    $("#moveLast").css("top",containerTop);

    //Inicializa menu de contexto da área de drop
    newContextMenu($("#dropArea"),'dropMenu');

    //Carrega objetos na área de drag
    loadObjects();

    try{
        //Verifica se o form enviou quantidade máxima de objetos
        if(frmObjMaxDrops != "" && !isNaN(frmObjMaxDrops)) maxDrops = parseInt(frmObjMaxDrops);
        //Carrega objetos vinculados na área de drop
        a_openerDropped = eval("window.parent.parent." + objGetFunc + "()");
        countDropOpener = eval("window.parent.parent." + objCountFunc + "()");

        fillDropArea(a_openerDropped,countDropOpener)

        //atualiza contador
        $("#counter").html(countDrop + "/" + maxDrops);

    }catch(e){
        $.facebox("Erro ao carregar os objetos relacionados ao conteúdo.");
    }
})

function loadObjects(){
    
    if(!loading){
        
        loading = true;
    
        //Loader
            //Limpa área de drag
            $("#dragArea").html("");
            
            loaderImg = document.createElement("IMG");
            loaderImg.src = __base_url + "../public/gwm/img/loader.gif";
            $(loaderImg).css("position","absolute");
            $(loaderImg).css("visibility","hidden");
            
            //Inserer em dragArea
            $("#dragArea").append(loaderImg);
            
            //Pega tamanho do loader
            loaderWidth = parseInt($(loaderImg).css("width").replace("px",""));
            loaderHeight = parseInt($(loaderImg).css("height").replace("px",""));;
            
            //seta posição do loader
            loaderTop = parseInt((dragAreaHeight - loaderHeight)/2);
            loaderLeft = parseInt((dragAreaWidth - loaderWidth)/2);
            
            $(loaderImg).css("top",loaderTop.toString() + "px");
            $(loaderImg).css("left",loaderLeft.toString() + "px");
            
            $(loaderImg).css("visibility","visible");
        //Fim loader

        //Reseta posicionamentos
        newTop = sepSize;
        newLeft = sepSize;

        //atualiza contador
        $("#counter").html(countDrop + "/" + maxDrops);
        
        //Monta array de objetos arrastaveis
        a_obj = new Array(maxObjPage)

        if(page=="") page = 1;    

        //Define a query / página
        objectsSrc = __base_url + "main/getObjectsByGallery/?objectGalleryId=" + objectGalleryId + "&page=" + page + "&itemsPage=" + maxObjPage + "&query=" + query + "&objectTypeId=" + objectTypeId;

        //Lê xml dos objetos
        $.ajax({
            async:      true,
            cache:      false,
            dataType:   "xml",
            timeout:    60000,
            type:       "get",
            url:        objectsSrc,
            error:      function(){
                            //Indica fim da carga
                            loading = false;

                            //Limpa loader
                            $("#dragArea").html("");
                            
                            $.facebox("Erro ao tentar carregar os objetos.");
                        },
            success:    function(data, textStatus){
                    //Barra de paginação
                    
                    prevPage = $("navBar", data).attr("prevPage");
                    nextPage = $("navBar", data).attr("nextPage");
                    lastPage = $("navBar", data).attr("lastPage");
    		        
		            aFirst = "<a href='javascript:changePage(1)'>Primeira</a>   |"
		            aPrev = "<a href='javascript:changePage(" + prevPage.toString() + ")'><strong>Anterior</strong></a>   |"
		            aNext = "<a href='javascript:changePage(" + nextPage.toString() + ")'><strong>Próxima</strong></a>   |"
		            aLast = "<a href='javascript:changePage(" + lastPage.toString() + ")'>Última</a>"

                    //Define paginação manual máxima
                    maxToPage = parseInt(lastPage);
    		        
                    //Limpa paginação
                    $("#liPagingText").text("");
                    $("#liPaging").html("");

		            //Carrega select com páginas se necessário
		            if(maxToPage > 1){
    		        
		                oSelect = document.createElement("SELECT");
		                oSelect.id = "goPage";
		                $(oSelect).bind("change",function(e){changePageManual(this.value)});
		                oSelect.style.width = "53px";

                        for (i = oSelect.length - 1; i>=0; i--) {oSelect.remove(i);}

	                    for(var i = 1; i <= maxToPage;i++){
	                        oOpt = document.createElement("option");
	                        oOpt.text = i.toString();
	                        oOpt.value = i.toString();
	                        ieBrowser = isIE()
	                        if(ieBrowser){
	                            oSelect.add(oOpt);
	                        }else{
	                            oSelect.add(oOpt,null);
	                        }
	                    }
	                    //Seta página atual
	                    oSelect.value = page;
    	                
	                    $("#liPagingText").text("Vá para");
	                    $("#liPaging").append(oSelect); 
	                }
    		        
		            if(page > 1){
		                 $("#pagingFirst").html(aFirst);
		            }else{
		                $("#pagingFirst").html("");
		            }
		            if(prevPage > 0) {
		                $("#pagingNextLeft").html(aPrev);
		            }else{
		                $("#pagingNextLeft").html("");
		            }
		            $("#thisPage").html("<strong>" + page.toString() + " / " + lastPage.toString() + "</strong>");
		            if(nextPage > 0) {
		                $("#pagingNextRight").html(aNext);
		            }else{
		                $("#pagingNextRight").html("");
		            }
		            if(lastPage > 1){
		                $("#pagingLast").html(aLast);
		            }else{
		                $("#pagingLast").html("");
		            }
            		
                    var i = 0;
                    
                    //Limpa área de drag
                    $("#dragArea").html("");
                    
                    $("object", data).each(function(){

                        objectId = $(this).attr("id");
                        objectType = $("type", this).text();
                        objectDescription = $("description",this).text();
                        objectAuthor = $("author",this).text();
                        objectPostDate = $("postDate",this).text();
                        objectSrcThumb = $("srcThumb",this).text();
                        objectSrcView = $("srcView",this).text();

                        //Div do container do objeto
                        oDivObj = document.createElement("DIV");
                        oDivObj.className = "object";
                        oDivObj.id = "divObj" + (objectId).toString();
                        
                        //Dimensiona Div Principal
                        $(oDivObj).css("width",objectWidth);
                        $(oDivObj).css("height",objectHeight + legendHeight);

                        //Div das imagens
                        oDiv = document.createElement("DIV");
                        oDiv.id = "divImgObj" + (objectId).toString();
                        oDiv.className = "imgDiv";
                        $(oDivObj).append(oDiv);

                        //Dimensiona div das imagens
                        $(oDiv).css("width",objectWidth);
                        $(oDiv).css("height",objectHeight);
                        
                        //Imagem clone
                        oImgC = document.createElement("IMG");
                        oImgC.id = "imgC" + (objectId).toString();
                        oImgC.className = "imgClone";
                        oImgC.src = objectSrcThumb;
                        oImgC.alt = objectDescription;
                        $(oDiv).append(oImgC);

                        //Dimensiona e posiciona Clone
                        $(oImgC).css("width",dragObjWidth);
                        $(oImgC).css("height",dragObjHeight);
                        $(oImgC).css("left",dragObjPadding.toString() + "px");
                        $(oImgC).css("top",dragObjPadding.toString() + "px");

                        //Legenda
                        oLeg = document.createElement("P");
                        oLeg.className = "legend img";
                        oLeg.id = "leg" + objectId.toString();
                        $(oLeg).text(objectDescription);
                        $(oDivObj).append(oLeg);

                        $(oLeg).click(function(){
                                id = this.id;
                                imgId = id.substring(3,id.length);
                                gwmObj = getElementByImageId(imgId)
                                startFacebox(gwmObj.srcView,gwmObj.objectDescription,gwmObj.objectAuthor,gwmObj.objectPostDate);
                                })

                        
                        //Dimensiona e posiciona Legenda
                        $(oLeg).css("width",objectWidth);
                        $(oLeg).css("height",legendHeight);
                        $(oLeg).css("top",(objectHeight + 2).toString() + "px");
                        
                        //Append do Div Principal
                        $("#dragArea").append(oDivObj);
                        $(oDivObj).css("left",newLeft.toString() + "px");
                        $(oDivObj).css("top",newTop.toString() + "px");
                        $(oDivObj).css("width",objectWidth);
                        $(oDivObj).css("height",objectHeight);

                        //Só inserir se não estiver em a_dropped
                        if(!checkDroppedById(objectId)){

                            //Imagem principal dragavel
                            oImg = document.createElement("IMG");
                            oImg.src = objectSrcThumb;
                            oImg.className = "imgDrag";
                            oImg.alt = objectDescription;
                            oImg.id = (objectId).toString();
                            $("#dragArea").append(oImg);

                            //Dimensiona e posiciona Arrastável
                            $(oImg).css("width",dragObjWidth);
                            $(oImg).css("height",dragObjHeight);
                            $(oImg).css("left",(newLeft + dragObjPadding).toString() + "px");
                            $(oImg).css("top",(newTop + dragObjPadding).toString() + "px");
                            
                            //Armazena referência no array
                            a_obj[i] = new GwmObj(objectId,objectDescription,objectAuthor,objectPostDate,oImg,oImgC,newLeft,newTop,objectSrcThumb,objectSrcView);

                            //Inicializa a função de drag
                            newDraggable($(oImg));

                            //Inicializa menu de contexto
                            newContextMenu($(oImg),'dragMenu');

                        }else{
                            //insere referência para o objeto anterior
                            objDropped = getDroppedById(objectId);

                            a_obj[i] = new GwmObj(objDropped.objectId,objectDescription,objectAuthor,objectPostDate,objDropped.obj,oImgC,newLeft,newTop,objectSrcThumb,objectSrcView);
                        }

                        //Determina a posição do próximo objeto
                        newLeft = newLeft + objectWidth + sepSizeDrag;
                        if((newLeft + objectWidth + (2*sepSizeDrag)) > (dragAreaWidth + 15)) {
                            newTop = newTop + objectHeight + legendHeight + sepSizeDrag;
                            newLeft = sepSizeDrag;
                        }
                        i++;
                    });
                    
                    //Verifica status da área de drag
                    if($("#dragArea").html() ==""){
                        $("#dragArea").text("> nenhum objeto encontrado");
                    }
                    
                    //Indica fim da carga
                    loading = false;
                    
                }
            }
           )
        
            
        //Inicializa área de drop
        $("#dropArea").droppable(
            {
	            accept : '.imgDrag', 
	            activeClass: 'dropzoneactive', 
	            hoverClass:	'dropzonehover',
	            tolerance: 'touch',
	            activate: function(e,ui){
    	        
	                $(this).css("background-color",dropAreaActiveBg)
	            },
	            deactivate: function(e,ui){
    	        
	                $(this).css("background-color",dropAreaDefaultBg)
	            },
	            over:   function(e,ui){
	                $(this).css("border",dropAreaOverBorder);
	            },
	            drop:	function (e,ui) 
			            {
				            if(countDrop < maxDrops){

                                //Pega objeto
                                gwmObj = getElement(ui.draggable.element);
                                
                                if(gwmObj == null){
                                    //Objeto não está na área de drag. Pega pelos dropped
                                    gwmDropped = getDropped(ui.draggable.element);
                                    objectId = gwmDropped.objectId;
                                }else{
                                    objectId = gwmObj.objectId;
                                }

				                if(!checkDropped(ui.draggable.element) && gwmObj != null){

                                    //Remove menu de contexto
                                    clearContextMenu($(ui.draggable.element));

                                    //Nova altura para os objetos arrastados
                                    newTop = sepSize;
                                    

                                    if(newInsert==0){

                                        //adicionado a esquerda da fila
                                        for(i=countDrop;i>0;i--){
                                            a_dropped[i].objectId = a_dropped[i-1].objectId;
                                            a_dropped[i].obj = a_dropped[i-1].obj;
                                            a_dropped[i].newLeft = a_dropped[i-1].newLeft;
                                        }
                                        a_dropped[0].objectId = objectId;
                                        a_dropped[0].obj = ui.draggable.element;
                                        a_dropped[0].newLeft = a_dropped[0].newLeft - (dragObjWidth + sepSize);

                                        a_dropped[0].newTop = newTop;
                                        $(a_dropped[0].obj).css("left",a_dropped[0].newLeft + "px");
                                        $(a_dropped[0].obj).css("top",a_dropped[0].newTop + "px");
                                        
                                    }else{
                                        //Adicionado no meio ou a direita
                                        newInsert--
                                        
                                        if(newInsert==0){
                                            
                                            if(countDrop>0){
                                           
                                                //Inserido sobre o primeiro
                                                a_dropped[countDrop].newLeft = a_dropped[countDrop-1].newLeft + dragObjWidth + sepSize;

                                                for(i=countDrop;i>0;i--){
                                                    a_dropped[i].objectId = a_dropped[i-1].objectId;
                                                    a_dropped[i].obj = a_dropped[i-1].obj;
                                                    $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px");
                                                    $(a_dropped[i].obj).css("border",dragObjDefaultBorder);
                                                }
                                                a_dropped[0].objectId = objectId;
                                                a_dropped[0].obj = ui.draggable.element;
                                                a_dropped[0].newLeft = a_dropped[0].newLeft;
                                                $(a_dropped[0].obj).css("left",a_dropped[0].newLeft + "px");
                                                $(a_dropped[0].obj).css("border",dragObjDefaultBorder);
                                                a_dropped[0].newTop = newTop;
                                                $(a_dropped[0].obj).css("top",a_dropped[0].newTop + "px");
                                            }else{

                                                //Primeiro item arrastado
                                                a_dropped[0].objectId = objectId;
                                                a_dropped[0].obj = ui.draggable.element;
                                                a_dropped[0].newLeft = sepSize;
                                                $(a_dropped[0].obj).css("left",a_dropped[0].newLeft + "px");
                                                a_dropped[0].newTop = newTop;
                                                $(a_dropped[0].obj).css("top",a_dropped[0].newTop + "px");
                                            }                                            
                                            
                                        }else{
                                            //Inserido no meio ou a direita
                                            if(newInsert == countDrop){
                                           
                                                //Inserido a direita
                                                a_dropped[countDrop].objectId = objectId;
                                                a_dropped[countDrop].obj = ui.draggable.element;
                                                a_dropped[countDrop].newLeft = a_dropped[countDrop-1].newLeft + dragObjWidth + sepSize ;
                                                $(a_dropped[countDrop].obj).css("left",a_dropped[countDrop].newLeft + "px");
                                                a_dropped[countDrop].newTop = newTop;
                                                $(a_dropped[countDrop].obj).css("top",a_dropped[countDrop].newTop + "px");
                                                

                                            }else{
                                             
                                                a_dropped[countDrop].newLeft = a_dropped[countDrop-1].newLeft + dragObjWidth + sepSize;

                                                for(i=countDrop;i>newInsert;i--){
                                                    a_dropped[i].objectId = a_dropped[i-1].objectId;
                                                    a_dropped[i].obj = a_dropped[i-1].obj;
                                                    $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px");
                                                }
                                                a_dropped[newInsert].objectId = objectId;
                                                a_dropped[newInsert].obj = ui.draggable.element;
                                                $(a_dropped[newInsert].obj).css("left",a_dropped[newInsert].newLeft + "px");
                                                a_dropped[newInsert].newTop = newTop;
                                                $(a_dropped[newInsert].obj).css("top",a_dropped[newInsert].newTop + "px");
                                                
                                            }
                                        }
                                    }
                                    
                                    $("#sep").css("visibility","hidden")

                                    //Insere elemento como filho de dropArea
                                    $("#dropArea").append(ui.draggable.element);

                                    countDrop += 1;
           
				                    //atualiza contador
				                    $("#counter").html(countDrop + "/" + maxDrops);
    				                
			                    }
			                }else{
			                    $.facebox("Fila de cópia cheia.");
			                }
            
		                    //Restaura borda do container
	                        $("#dropArea").css("border",dropAreaDefaultBorder);

                            // Ordenação de imagens
                            objects_order();
                            // Fim Ordenação

			            },
	            fit: true,
	            out: function (e,ui)
	                    {
	                    try
	                    {
                            $("#sep").css("visibility","hidden")				                

                            //Insere elemento como filho de dropArea

                            if(checkElement(ui.draggable.element)){

                                $("#dragArea").append(ui.draggable.element);

                                aElement = getElementById(ui.draggable.element);

                                $(ui.draggable.element).css("left",aElement.origLeft + dragObjPadding);
                                $(ui.draggable.element).css("top",aElement.origTop + dragObjPadding);
                                reorderArray(ui.draggable.element);

                                //Inicializa menu de contexto
                                newContextMenu($(ui.draggable.element),'dragMenu');

    	                    }else{
    	                        //Remove elemento do DOM
     	                    
    	                        reorderArray(ui.draggable.element);
    	                        $(ui.draggable.element).remove();
    	                    }
        	                
                            
		                    //atualiza contador
		                    $("#counter").html(countDrop + "/" + maxDrops);
    		                
                        }
                        catch(err) {
                           $.facebox(err);
                        }
	                    //Restaura borda do container
                        $("#dropArea").css("border",dropAreaDefaultBorder);
                        
                        }
            }
        )
        
    }
}

function reorderArray(element){

    var j = 0;

    for(var i=0;i<countDrop;i++){
        if(a_dropped[i].objectId == $(element).attr("id")){
           a_dropped[i].objectId = 0;
           a_dropped[i].obj = null;

            for(j=i;j<countDrop-1;j++){

                //Move posição dos objetos
                a_dropped[j].objectId = a_dropped[j+1].objectId;
                a_dropped[j].obj = a_dropped[j+1].obj;

                $(a_dropped[j].obj).css("left",a_dropped[j].newLeft + "px");
                
            }
            a_dropped[j].objectId = 0;
            a_dropped[j].obj = null;
            a_dropped[j].newLeft = 0;
            a_dropped[j].newTop = 0;

            countDrop--

            i = maxDrops;
        }
    }
    
    if(countDrop>0){
        if( a_dropped[countDrop-1].newLeft < sepSize){
            //Realinha elementos uma casa para a direita
            
           for(i=0;i<countDrop;i++){
                a_dropped[i].newLeft += dragObjWidth + sepSize;
                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px");
            }
     
        }
    }
}

function checkDroppedById(objectId){
    for(var i = 0; i<countDrop;i++){
        if(a_dropped[i].objectId == objectId){
             return true;
        }
    }
  
    return false;
}

function checkDropped(element){
    gwmObj = getElement(element)
    if(gwmObj != null){
        for(var i = 0; i<countDrop;i++){
            if(a_dropped[i].objectId == gwmObj.objectId){
                 return true;
            }
        }
    }  
    return false;
}

function checkElementById(element){
    objDropped = getDropped(element);
    for(var i = 0; i<maxObjPage;i++){
        var gwmObj = a_obj[i];
        if(gwmObj.objectId == objDropped.objectId) {
            a_obj[i].obj = element;
            return true;
        }
    }
    return false;
}

function checkElement(element){
    objDropped = getDropped(element)
    for(var i = 0; i<maxObjPage;i++){
        var gwmObj = a_obj[i];
        if(gwmObj != null){
            if(gwmObj.objectId == objDropped.objectId) {
                a_obj[i].obj = element;
                return true;
            }
        }
    }
    return false;
}

function checkGwmObject(element){

    for(var i = 0; i<maxObjPage;i++){
        var gwmObj = a_obj[i];
        if(gwmObj != null){
            if(gwmObj.objectId == parseInt($(element).attr("id"))) {
                return true;
            }
        }
    }
    return false;
}

function getElement(element){

    for(var i = 0; i<maxObjPage;i++){
        var gwmObj = a_obj[i];
        if(gwmObj != null){
            if(gwmObj.objectId == parseInt($(element).attr("id"))) {
                return gwmObj;
            }
        }
    }
    return null;
}

function getElementById(element){
    objDropped = getDropped(element);
    for(var i = 0; i<maxObjPage;i++){
        if(a_obj[i].objectId == objDropped.objectId) {
            return a_obj[i];
        }
    }
}

function getElementByImageId(imgId){
    for(var i = 0; i<maxObjPage;i++){
        if(a_obj[i].objectId == imgId) {
            return a_obj[i];
        }
    }
}


function getDropped(element){
    for(var i = 0; i<countDrop;i++){
        var objDropped = a_dropped[i];
        if(objDropped.objectId == parseInt($(element).attr("id"))) {
            return objDropped;
        }
    }
}

function getDroppedById(objectId){
    for(var i = 0; i<countDrop;i++){
        var objDropped = a_dropped[i];
        if(objDropped.objectId == objectId) {
            return objDropped;
        }
    }
}

function getDroppedPos(element){
    for(var i = 0; i<countDrop;i++){
        var objDropped = a_dropped[i];
        if(objDropped.objectId == $(element).attr("id")) {
            return i;
        }
    }
}

//Pega objeto na posição do mouse
function getObjPos(x){
    x = x - containerLeft;
    var pos = 0;
    if(countDrop>0){
        if((x >= a_dropped[0].newLeft - sepSize) && x <= a_dropped[countDrop-1].newLeft + dragObjWidth) {
            for(j = 0; j<countDrop;j++){
                var objDropped = a_dropped[j];
                if((x >= objDropped.newLeft) && x <= (objDropped.newLeft + dragObjWidth + sepSize)) {
                    pos = j;
                }
            }
        }else{
            if(x > a_dropped[countDrop-1].newLeft + dragObjWidth){
                pos = countDrop;
            }else{
                pos = -1;
            }
        }
    }
    return pos;
}

function newDraggable(obj){

    $(obj).draggable(	
        {		
            zIndex: 	999999999,		
            opacity: 	0.7,
            cursor:     'move',
            snap:       $('#dropArea'),
            snapTolerance: 20,
            containment: $('#mainDrag'),
            snapMode:   'inner',
            helper:     'clone',
            drag:       function(e,ui){

                    //Muda index dos objetos da frente
                    moveBack();
                    
                    pointerLeft = e.pageX;
                    pointerTop = e.pageY;

                    objOrder = getObjPos(pointerLeft);

                    objOrderCorrect = objOrder + 1;
                    
                    newInsert = objOrderCorrect;
                    
                    if(pointerTop >= containerTop && pointerTop <= containerTop + containerHeight && pointerLeft >= containerLeft && pointerLeft <= containerLeft + containerWidth){
                        if(countDrop > 0){
                            if(newInsert-1 == countDrop){
                                sepLeft = a_dropped[countDrop-1].newLeft + dragObjWidth;
                            }else{
                                sepLeft = a_dropped[newInsert-1].newLeft - sepSize;
                            }
                        }else{
                            sepLeft = 0;
                        }
                        
                        $("#sep").css("left",sepLeft)
                        $("#sep").css("visibility","visible")
                    }
                 },
            stop:       function(e,ui){
            
                $("#paging").css("zIndex",0);
                $("#moveFirst").css("zIndex",0);
                $("#moveLast").css("zIndex",0);
                $("#moveNextRight").css("zIndex",0);
                $("#moveNextLeft").css("zIndex",0);
                $("#dropArea").css("zIndex",0);
                $("#functionButtons").css("zIndex",0);

                pointerLeft = e.pageX;
                pointerTop = e.pageY;
                
                var j = 0;

                //Pegar o item selecionado
                objDropped = getDropped(ui.draggable.element);
                
                if(objDropped!=null){

                    //Armazena no array
                    a_dropped[maxDrops].objectId = objDropped.objectId;
                    a_dropped[maxDrops].obj = objDropped.obj;
                    a_dropped[maxDrops].newLeft = objDropped.newLeft;
                    
                    //Pega posição atual do objeto antes do drag
                    objDragStartPos = getDroppedPos(ui.draggable.element);

                    objOrder = getObjPos(pointerLeft)

                    if ( (objOrder>=0) && (objOrder<countDrop) ) {
                        objOrderCorrect = objOrder + 1;

                        if(objOrderCorrect > countDrop) objOrderCorrect = countDrop;

                        newLeft = dragAreaLeft + sepSize;

                        //Insere objetos antes do ponto de quebra
                        j = 0;
                        draggedFromBefore = false;
                        draggedLeft = -1;

                        var tmpLeft;

                        if(objOrderCorrect-1 > objDragStartPos){
                            //ESQ -> DIR
                            for(i=objDragStartPos;i<objOrderCorrect-1;i++){
                                //Mover para a esquerda
                                a_dropped[i].objectId = a_dropped[i+1].objectId;
                                a_dropped[i].obj = a_dropped[i+1].obj;
                                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px")
                            }
                            //Restaura o objeto na nova posição
                            a_dropped[i].objectId = a_dropped[maxDrops].objectId;
                            a_dropped[i].obj = a_dropped[maxDrops].obj;
                            $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px")
                            
                        } else {
                            //DIR -> ESQ
                            
                            for(i=objDragStartPos;i>objOrderCorrect-1;i--){
                                //Mover para a direita
                                a_dropped[i].objectId = a_dropped[i-1].objectId;
                                a_dropped[i].obj = a_dropped[i-1].obj;
                                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px")
                            }
                            a_dropped[i].objectId = a_dropped[maxDrops].objectId;
                            a_dropped[i].obj = a_dropped[maxDrops].obj;
                            $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px")
                        }
                    } else {
                        if(objOrder == -1) {
                            //se colocar à esquerda
                            for(i=objDragStartPos;i>0;i--){
                                //Mover para a esquerda
                                a_dropped[i].objectId = a_dropped[i-1].objectId;
                                a_dropped[i].obj = a_dropped[i-1].obj;
                                a_dropped[i].newLeft = a_dropped[i-1].newLeft;
                                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px");
                            }
                            a_dropped[0].objectId = a_dropped[maxDrops].objectId;
                            a_dropped[0].obj = a_dropped[maxDrops].obj;
                            a_dropped[0].newLeft = a_dropped[0].newLeft - (dragObjWidth+sepSize);
                            $(a_dropped[0].obj).css("left",a_dropped[0].newLeft + "px");
                            
                            if (objDragStartPos < (countDrop-1)) {
                                for(i=(objDragStartPos+1);i<countDrop;i++){
                                    //Mover para a esquerda
                                    a_dropped[i].newLeft = a_dropped[i].newLeft - (dragObjWidth+sepSize);
                                    $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px");
                                }
                            }
                            
                        } else {
                            //se colocar à direita
                            
                            for(i=objDragStartPos;i<(countDrop-1);i++){
                                //Mover para a esq
                                a_dropped[i].objectId = a_dropped[i+1].objectId;
                                a_dropped[i].obj = a_dropped[i+1].obj;
                                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px");
                            }
                            
                            a_dropped[countDrop-1].objectId = a_dropped[maxDrops].objectId;
                            a_dropped[countDrop-1].obj = a_dropped[maxDrops].obj;
                            $(a_dropped[countDrop-1].obj).css("left",a_dropped[countDrop-1].newLeft + "px");
                            
                        }
                    
                    }
                    
                }
                $("#sep").css("visibility","hidden")
            }
        }
    )
    
    setClick(obj);
}

function setClick(obj){
    $(obj).click(function () { 
        if(!animating){
            if(countDrop < maxDrops){
                if(checkGwmObject(this)){
                    if(!checkDropped(this)){

                        //Remove menu de contexto
                        clearContextMenu($(this));

                        //Insere a direita
                        if(countDrop==0) {
                            newLeft = sepSize;
                        } else {
                            if(a_dropped[countDrop-1].newLeft >= (containerWidth - dragObjWidth)){
                                //Faz shift para a esquerda
                                while(a_dropped[countDrop-1].newLeft > containerWidth - (dragObjWidth + sepSize)) scrollRight();
                            }
                            newLeft = a_dropped[countDrop-1].newLeft + dragObjWidth + sepSize;
                        }
                        
                        oldZindex = $(this).css("zIndex");
                        
                        $(this).css("zIndex","99999999");
                        
                        newTop = containerTop + sepSize;

                        animating = true;

                        moveBack();

                        //Anima
                        $(this).animate(
                            {
                            left: containerLeft + newLeft,
                            top: newTop
                            },
                            animateVel,
                            "swing",
                            function(){
                                
                                moveFront();
                                
                                //Insere elemento como filho de dropArea
                                animating = false;
                                
                                newTop = sepSize;
                                
                                $("#dropArea").append(this);
                                gwmObj = getElement(this);
                                a_dropped[countDrop].objectId = gwmObj.objectId;
                                a_dropped[countDrop].obj = this;
                                a_dropped[countDrop].newLeft = newLeft;
                                $(a_dropped[countDrop].obj).css("left",a_dropped[countDrop].newLeft + "px");
                                a_dropped[countDrop].newTop = newTop;
                                $(a_dropped[countDrop].obj).css("top",a_dropped[countDrop].newTop + "px");

                                //Esconde separador
                                $("#sep").css("visibility","hidden")

                                countDrop += 1;
                                
                                //atualiza contador
                                $("#counter").html(countDrop + "/" + maxDrops);
                                
                                //Restaura zIndex
                                $(this).css("zIndex",oldZindex);

                                //atualiza ordenador
                                objects_order();
                            }
                        );

                    } else {
                        //Remove o elemento

                        try
                        {
                            aElement = getElement(this);

                            newLeft = aElement.origLeft + dragObjPadding;
                            newTop = aElement.origTop + dragObjPadding;
                            
                            dropObj = getDropped(this);

                            $("#dragArea").append(dropObj.obj);
                            
                            $(this).css("top",containerTop+sepSize);
                            
                            $(this).css("left",containerLeft + dropObj.newLeft);
                            
                            animating = true;
                            
                            moveBack();
                            
                            //Anima
                            $(this).animate(
                                {
                                left: newLeft,
                                top: newTop
                                },
                                animateVel,
                                "swing",
                                function(){

                                    moveFront();
                                    
                                    //Insere elemento como filho de dropArea
                                    
                                    $("#sep").css("visibility","hidden")				                

                                    reorderArray(this);
                                    
                                    //atualiza contador
                                    $("#counter").html(countDrop + "/" + maxDrops);
        	                        
                                    animating = false;
                                }
                            )
                        }catch(err) {
                            $.facebox("Erro ao tentar remover o objeto.");
                        }
                        
                        //Restaura menu de contexto
                        newContextMenu($(this),'dragMenu');

                        //atualiza ordenador
                        objects_order();
                    }  
                }else{
                    //Remove elemento do DOM
                
                    reorderArray(this);
                    $(this).remove();
                    
                    //atualiza contador
                    $("#counter").html(countDrop + "/" + maxDrops);

                    moveFront();
                }      
            }
        }
    })        
}

function newContextMenu(obj,mnuElement){

    $(obj).contextMenu(mnuElement, {

        itemStyle : {
          color : "#333333",
          fontFamily: "Verdana, Arial",
          fontSize: "12px",
          fontWeight: "700"
        },
      bindings: {
        'cMnuView': function(t) {
            gwmObj = getElement(t)
            startFacebox(gwmObj.srcView,gwmObj.objectDescription,gwmObj.objectAuthor,gwmObj.objectPostDate)
        },
        'cMnuEdit': function(t) {

            $("#paging").css("visibility","hidden");
            $("#mainDrag").fadeOut(500,function(){
                showEditArea(t.id);
                })
        },
        'cMnuCopy': function(t) {
            copyMoveSelected(1);
        },
        'cMnuMove': function(t) {
            copyMoveSelected(0);
        },
        'cMnuDel': function(t) {
            gwmObj = getElement(t)
            delObject(gwmObj.objectId);
        },
        'cMnuClear': function(t) {
            removeAll();
        },
        'cMnuInsert': function(t) {
            insertSelected();
        }
      }
    });    
}

function clearContextMenu(obj){
    $(obj).contextMenu('',{});
}

// Fields

//Objetos na janela
function GwmObj(objectId,objectDescription,objectAuthor,objectPostDate,obj,clone,origLeft,origTop,srcThumb,srcView){
    this.objectId = objectId;
    this.obj = obj;
    this.clone = clone;
    this.origLeft = origLeft;
    this.origTop = origTop;
    this.srcThumb = srcThumb;
    this.srcView = srcView;
    this.objectDescription = objectDescription;
    this.objectAuthor = objectAuthor;
    this.objectPostDate = objectPostDate;
}

//Objetos arrastado
function objDropped(objectId,obj,newLeft,newTop){
    this.objectId = objectId;
    this.obj = obj;
    this.newLeft = newLeft;
    this.newTop = newTop;
}

//Tipos de objeto
function ojbType(thumbSrc,viewSrc){
    this.thumbSrc = thumbSrc;
    this.viewSrc = viewSrc;
}

//Funções de Scrool
function scrollLeft(){
   if(countDrop>0){
       if(a_dropped[0].newLeft < sepSize){ 
            for(i=0;i<countDrop;i++){
                a_dropped[i].newLeft = a_dropped[i].newLeft + (dragObjWidth+sepSize);
                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px")
            }
        }
    }
}

function scrollRight(){
   if(countDrop>0){
       if(a_dropped[countDrop-1].newLeft > (containerWidth - (dragObjWidth + sepSize))){ 
            for(i=0;i<countDrop;i++){
                a_dropped[i].newLeft = a_dropped[i].newLeft - (dragObjWidth+sepSize);
                $(a_dropped[i].obj).css("left",a_dropped[i].newLeft + "px")
            }
        }
    }
}

function scrollFirst(){
   if(countDrop>0){
       while(a_dropped[0].newLeft < sepSize){ 
            scrollLeft();
        }
    }
}

function scrollLast(){
   if(countDrop>0){
       while(a_dropped[countDrop-1].newLeft > (containerWidth)){ 
            scrollRight();
        }
    }
}


function removeAll(){

    if(countDrop > 0){
        moveBack();
        
        if(countDrop >0){
            //Move toda a lista para a esquerda até o último elemento ficar visível na área de drop
            while(a_dropped[countDrop-1].newLeft > containerWidth - sepSize) scrollRight();
        
            for(i=countDrop-1;i>=0;i--){
                if(checkElement(a_dropped[i].obj)){
                    aElement = getElement(a_dropped[i].obj);

                    if(a_dropped[i].newLeft < sepSize){
                        //Faz shift para a direita
                        scrollLeft();
                    }

                    origLeft = aElement.origLeft + dragObjPadding;
                    origTop = aElement.origTop + dragObjPadding;

                    $("#dragArea").append(a_dropped[i].obj);
                    $(a_dropped[i].obj).css("top",containerTop+sepSize);
                    $(a_dropped[i].obj).css("left",containerLeft + a_dropped[i].newLeft);

                    removeAllFlag = i;

                    $(a_dropped[i].obj).animate(
                        {
                        left: origLeft,
                        top: origTop
                        },
                        animateVel,
                        "swing",
                        function(){
                            //Restarura menu de contexto
                            newContextMenu($(this),'dragMenu');
                            if(removeAllFlag==0)moveFront();
                        }
                    )
                }else{
                    $(a_dropped[i].obj).remove();
                    moveFront();
                }
            }
            countDrop = 0;
            //atualiza contador
            $("#counter").html(countDrop + "/" + maxDrops);
        }
    }
}

function changePage(newPage){
    page = newPage;
    
    loadObjects();
}

function changePageManual(pageVal){
    
    //userRequestPage = $("#goPage").attr("value");
    if(pageVal >= 1 && pageVal <= maxToPage) {
        page = pageVal;
    
        $("#dragArea").html("");

        loadObjects();
        
    }else{
        $.facebox("Página inexistente.")
    }

}

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
    $(oIframe).attr("scrolling","auto")
    
    //Div do Iframe
    $(oDivObj).css("width","400px");
    $(oDivObj).css("height","300px");

    $(oDivObj).append(oIframe);
    $(oDivText).text(footerStr);
    $(oDivAll).append(oDivObj);
    $(oDivAll).append(oDivText);
    
    $.facebox(oDivAll,"",false);

}

function showEditArea(objectId){
    $("#mainDrag").hide();
	if(objectId != ""){
		$("#iEditArea").attr("src",__base_url + "main/objects_edt_img/?objectId=" + objectId + "&objectGalleryId=" + objectGalleryId);
    }else{
		$("#iEditArea").attr("src",__base_url + "main/objects_edt/?objectId=" + objectId + "&objectGalleryId=" + objectGalleryId);
	}
	$("#editArea").css("display","block");
    $("#editArea").css("visibility","visible");
    $("#editArea").fadeIn(500);
}

function hideEditArea(){
    $("#editArea").fadeOut(500,function(){
        $("#editArea").css("visibility","hidden");
        $("#editArea").css("display","none");
        $("#mainDrag").fadeIn(500);
        $("#mainDrag").css("visibility","visible");
        $("#paging").css("visibility","visible");
        $("#iEditArea").attr("src","about:blank");
        //loadObjects();
       })
}
function isIE() {
	var result = false;
	if (navigator.appName.indexOf("Microsoft")!=-1) {
		result = true;
	}	
	return result;
}
function moveBack(){
    $("#paging").css("zIndex",-1);
    $("#moveFirst").css("zIndex",-1);
    $("#moveLast").css("zIndex",-1);
    $("#moveNextRight").css("zIndex",-1);
    $("#moveNextLeft").css("zIndex",-1);
    $("#dropArea").css("zIndex",-1);
    $("#functionButtons").css("zIndex",-1);
}
function moveFront(){
    $("#paging").css("zIndex",0);
    $("#moveFirst").css("zIndex",0);
    $("#moveLast").css("zIndex",0);
    $("#moveNextRight").css("zIndex",0);
    $("#moveNextLeft").css("zIndex",0);
    $("#dropArea").css("zIndex",0);
    $("#functionButtons").css("zIndex",0);
}

function setQuery(q,objTypeId){

    //Reseta menu
    objFrame = window.parent.frames["menu"];
    objFrame.closeFolders();

    query = q;
    objectGalleryId = "";
    objectTypeId = objTypeId;
    page = 1;
    hideEditArea();
    loadObjects();
}

function setGallery(gal){
    query = "";
    page = 1;
    hideEditArea();
    objectGalleryId = gal;
    loadObjects();
}

function getGallery(){
    return objectGalleryId;    
}

function setRecent(){
    objectGalleryId = "";
    loadObjects();
}

function fillDropArea(a_openerDropped,countDropOpener){

    //Limpa área de drop

    countDrop = countDropOpener;

    for(var i=0; i<countDrop;i++){

        obj = a_openerDropped[i].obj;
        
        newObj = document.createElement("IMG");

        $(newObj).attr("src",obj.src);
        $(newObj).attr("id",a_openerDropped[i].objectId);
        $(newObj).attr("className","imgDrag");
		$(newObj).css("left",a_openerDropped[i].newLeft);
        
        $(newObj).css("top",a_openerDropped[i].newTop);
        $(newObj).css("width",$(obj).css("width"));
        $(newObj).css("height",$(obj).css("height"));

        a_dropped[i] = new objDropped(a_openerDropped[i].objectId,newObj,a_openerDropped[i].newLeft,a_openerDropped[i].newTop)
 
        $("#dropArea").append(newObj);

        //Limpa menu de contexto
        clearContextMenu($(newObj));

         //Inicializa a função de drag
        newDraggable($(newObj));

        //atualiza contador
        $("#counter").html(countDrop + "/" + maxDrops);

        //atualiza ordenador
        objects_order();

    }
}

function getSelObjects(){

    aStr = ""
    for(var i = 0;i<countDrop;i++){
        aStr += a_dropped[i].objectId.toString() + ",";
    }
    
    //Remove a última virgula
    aStr = aStr.substring(0,aStr.length -1);
    
    return aStr;
}

function runCopyMove(){
   aObjects = getSelObjects();
    
    opSrc = __base_url + "main/copyMoveSelected/?op=" + copyMoveOp.toString() + "&objectGalleryId=" + objectGalleryId + "&aObjects=" + aObjects;

    //Ajax para cópia
    
    loading = true;
    $.ajax({
        async:      false,
        dataType:   "xml",
        type:       "get",
        url:        opSrc,
        error:      function(){
                        //Indica fim da carga
                        loading = false;
                        $.facebox("Erro ao tentar copiar/mover os objetos selecionados.");
                    },
        success:    function(data, textStatus){
            loading = false;
            loadObjects();
       }
     })
}


function copyMoveSelected(copy){
    //copy = 0 - move; copy = 1 - copia
    msg = checkStatus();
    if(msg == ""){

        copyMoveOp = copy;
        
        if(copy==1){
            msg = "Confirma COPIAR os objetos selecionados para a pasta atual?";
        }else{
            msg = "Confirma MOVER os objetos selecionados para a pasta atual?"
        }
        $.faceboxConfirm(msg,"",runCopyMove)

    }else{
        $.facebox(msg);
    }
}

function delObject(objectId){
    checkSrc = __base_url + "main/getObjectDep/?objectId=" + objectId;
    
    delObjectId = objectId;
    
    loading = true;
    $.ajax({
        async:      false,
        dataType:   "xml",
        type:       "get",
        url:        checkSrc,
        error:      function(){
                        //Indica fim da carga
                        loading = false;
                        $.facebox("Erro ao tentar verificar as dependências do objeto.");
                    },
        success:    function(data, textStatus){
            loading = false;
            if($("canExclude", data).length == 0){
             
                $.faceboxConfirm("O objeto está relacionado a um ou mais conteúdos. Ao ser excluído será automaticamente desvinculado desses conteúdos.<br />Deseja realmente prosseguir?","",runDel);
                    
            }else{
               
                $.faceboxConfirm("Confirma EXCLUIR o objeto permanentemente do sistema?","",runDel);
            
            }
       }
     })
}

function runDel(){
    opSrc = __base_url + "main/objectDel/?objectId=" + delObjectId;

    //Ajax para exclusão
    
    loading = true;
    $.ajax({
        async:      false,
        dataType:   "xml",
        type:       "get",
        url:        opSrc,
        error:      function(){
                        //Indica fim da carga
                        loading = false;
                        $.facebox("Erro ao tentar excluir o objeto.<br />Contacte o administrador do sistema.");
                    },
        success:    function(data, textStatus){
            if($("result", data).length > 0){ 
                loading = false;
                loadObjects();

            }else{
                $.facebox("Erro ao tentar excluir o objeto.<br />Contacte o administrador do sistema.");
            }
       }
     })
}

function insertSelected(){
    if(objCbFunc != "" && objCbFunc != undefined){

        try{
            wFrame = window.top.frames["workFrame"];
            if(wFrame != '[object HTMLFrameElement]' || wFrame != '[object]'){
                wFrame = window.parent.parent;
            }
            eval("wFrame." + objCbFunc + "(a_dropped,countDrop)");
            objFrame = wFrame.closeObjMultimidia();
        }catch(e){

            $.facebox("Erro ao tentar atualizar os objetos relacionados na janela do conteúdo editado.<br />Contacte o administrador do sistema.");
        }
    }
}

function checkStatus(){
    msg = "";
    
    if(countDrop > 0){
        if(objectGalleryId != "" && objectGalleryId != undefined){
            msg = "";
        }else{
            msg = "Você está na pasta de objetos recentes ou resultado de busca.\nSelecione uma pasta de destino válida.";
        }
    }else{
        msg = "Caixa de seleção vazia.";        
    }
    return msg;
}

function objects_order(){
    var order = new Array();
    var ids = new Array();
    $('#dropArea img.imgDrag').each(function(index, value){
        if (ids.indexOf($(value).attr('id')) < 0) {
            ids.push($(value).attr('id'));
            order.push({
                'id': $(value).attr('id'),
                'display_order': parseInt($(value).css('left'),10)
            });
        }
    });

    $.ajax({
        type: "POST",
        url: __base_url+'application/objects_order',
        data: "order=" + JSON.stringify(order),
        success: function(msg){
            console.log(msg);
        }
    });
}