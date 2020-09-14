var frame = window.parent.frames["objects"];
var __base_url = frame.__base_url;

$(document).ready(function(){
    //Inicializa menu de contexto
    newContextMenu($("a.close"),'folderMenu');
    newContextMenu($("a.open"),'folderMenu');
    }
)

function newContextMenu(obj,mnuElement){

    $(obj).contextMenu(mnuElement, {

        itemStyle : {
          color : "#333333",
          fontFamily: "Verdana, Arial",
          fontSize: "12px",
          fontWeight: "700"
        },
      bindings: {
        'cMnuNew': function(t) {
            newFolder($(t));
        },
        'cMnuEdit': function(t) {
            editFolder($(t));
        },
        'cMnuDel': function(t) {
            jSon = $(t);
            delFolder(jSon);
        }
      }
    });    
}

function newFolderSel(){
    jSon = $("a.open")
    if($(jSon).attr("id")!="a_rec" && $(jSon).attr("id")!=undefined){
        newFolder(jSon);
    }
}

function editFolderSel(){
    jSon = $("a.open")
    if($(jSon).attr("id")!="a_rec" && $(jSon).attr("id")!=undefined){
        editFolder(jSon);
    }
}

function delFolderSel(){
    jSon = $("a.open")
    if($(jSon).attr("id")!="a_rec" && $(jSon).attr("id")!=undefined){
        delFolder(jSon);
    }
}

function newFolder(jSon){
    
    //Pega SPAN
    parentSpan = $(jSon).parent().get(0);

    //Pega LI pai
    parentLi = $(parentSpan).parent().get(0);
    parentId = $(parentLi).attr("id")
    parentDataId = parentId.substring(3,parentId.length);

    //Monta objeto para pegar nova pasta
    oLi = document.createElement("LI");
    oLi.id = "newFolder";

    //Monta UL dos filhos
    oUl = document.createElement("UL");
    oUl.id = "ul_newFolder";
    $(oUl).css("display","none");
    
    oA = document.createElement("A");
    oA.href = "#";
    
    oImg = document.createElement("IMG");    
    oImg.src = __base_url + "../public/gwm/img/none.gif";
    oImg.alt = "";
    
    oSpan = document.createElement("SPAN");
    oSpan.className = "newFolder";
    
    oINewFolder = document.createElement("INPUT");
    oINewFolder.id = "txtNewFolder";
    oINewFolder.className = "iNewFolder";
    oINewFolder.maxlength = 30;
    $(oINewFolder).bind("keydown",function(e){ 
            if(e.which == 13 || e.which == 27) {
                $(oINewFolder).blur();
            }
    })
    
    //Insere a hierarquia da nova pasta
    $(oA).append(oImg);    
    $(oSpan).append(oINewFolder);
    $(oLi).append(oA);
    $(oLi).append(oSpan);
    $(oLi).append(oUl);
	
    
    //Expande filhos da pasta selecionada
    ulParent = $(parentLi).children("ul");

    if($(ulParent).css("display") == "none"){
         colapse($(ulParent).attr("id"),oINewFolder)

    }else{
        //Seta foco
        oINewFolder.focus();
    }
    
    //Insere nova estrutura abaixo da pasta selelcionada
    $(ulParent).append(oLi);
    
    //Define evento de blur para salvar a nova pasta
    $(oINewFolder).blur(function (){
		checkWhatToDo(this,parentDataId);
    })
}

function editFolder(jSon){

    //Pega SPAN pai
    parentSpan = $(jSon).parent().get(0);
    
    //Define nova classe do SPAN pai
    $(parentSpan).attr("className","newFolder");

    //Armazena propriedades do link
    folderName = $(jSon).text();
    folderClass = $(jSon).attr("className");
    folderId = $(jSon).attr("id");
    folderHref = $(jSon).attr("href");
    fontWeight = $(jSon).css("font-weight");
       
    folderDataId = folderId.substring(2,folderId.length);

    oINewFolder = document.createElement("INPUT");
    oINewFolder.id = "txtNewFolder";
    oINewFolder.value = folderName;
    oINewFolder.className = "iNewFolder";
    oINewFolder.maxlength = 30;
    $(oINewFolder).bind("keydown",function(e){ 
            if((e.which == 13 || e.which == 27) && $("#txtNewFolder").val() != "") {
                $(oINewFolder).blur();
            }
    })
    
    //Limpa HTML do span
    $(parentSpan).html("");
    
    //Insere a hierarquia da nova pasta
    $(parentSpan).append(oINewFolder);
    
    //Foco no INPUT de edit
    oINewFolder.focus();
    
    //Define evento de blur para salvar a pasta
    $(oINewFolder).blur(function (){
        
        if($("#txtNewFolder").val() != ""){
            saveFolder(folderDataId,$(this).val(),parentSpan);
        }
        
    })

}

function runDelFolder(){
    //Verificar se a pasta stá vazia

    folderId = $(jSon).attr("id");
    
    folderDataId = folderId.substring(2,folderId.length);
    
    refsSrc = __base_url + "main/getGalleryDep/?refGalleryId=" + folderDataId;

    //Lê xml dos objetos
    $.ajax({
        async:      true,
        cache:      false,
        dataType:   "xml",
        timeout:    15000,
        type:       "get",
        url:        refsSrc,
        error:      function(){
                        //Indica fim da carga
                        loading = false;
                        objFrame = window.parent.frames["objects"];
                        objFrame.$.facebox("A pasta não pode ser deletada.<br />Erro ao tentar verificar conteúdo da pasta.");
                    },
        success:    function(data, textStatus){

            if($("canExclude", data).length > 0){
                //Deleta folder do banco
                 $.ajax({
                   type: "GET",
                   async: false,
                   url: "galleryDel",
                   data: "objectGalleryId=" + folderDataId,
                   dataType: "xml",
                   success: function(data){
                    if($("result", data).length > 0){ 
                     
                        //Pega SPAN
                        parentSpan = $(jSon).parent().get(0);

                        //Pega LI pai
                        parentLi = $(parentSpan).parent().get(0);

                        //Remove LI pai
                        $(parentLi).remove();
                    
                    }else{
                        objFrame = window.parent.frames["objects"];
                        objFrame.$.facebox("Ocorreu um erro ao tentar excluir a pasta.<br />Consulte o log de erros ou contacte o administrador do sistema.")
                    }                         
                   }
                 });
            
            }else{
                objFrame = window.parent.frames["objects"];
                objFrame.$.facebox("A pasta não pode ser excluída pois possui sub-pastas ou conteúdos dependentes.");
            }
        }
    })
        
}

function delFolder(jSon){

    folderName = $(jSon).text();
    
    objFrame = window.parent.frames["objects"];
    objFrame.$.faceboxConfirm("Confirma exclusão da pasta \"" + folderName + "\"?","",runDelFolder)

}

function checkWhatToDo(obj,parentDataId){

    //Pega LI parent 
    parentSpan = $(obj).parent().get(0);
    parentLi = $(parentSpan).parent().get(0);
    
    //Valida valor do INPUT
    if($("#txtNewFolder").val() != ""){
        //Se válida
    
        //Salva pasta no banco
        newId = saveNewFolder("",$("#txtNewFolder").val(),parentDataId);

    }else{
        //Se inválida
    
        //Remove nó INPUT
        $(parentLi).remove();
    }        
}

function saveFolder(folderDataId,txtValue,parentSpan){

     $.ajax({
       type: "POST",
       async: false,
       url: __base_url + "main/gallerySave",
       data: "folderName=" + txtValue + "&objectGalleryId=" + folderDataId,
       dataType: "xml",
       success: function(data){
         newId = $("id", data).attr("value"); 
       }
     });

    //Restaura estrutura da pasta
    oA = document.createElement("A");
    oA.id = folderId;
    oA.href = folderHref;
    oA.className = folderClass;
    $(oA).css("font-weight",fontWeight);
    $(oA).text($("#txtNewFolder").val());
    
    $(parentSpan).html("");
    $(parentSpan).append(oA);

    //Menu de contexto
    newContextMenu($(oA),'folderMenu');
    
    //Restaura classe do SPAN pai
    $(parentSpan).attr("className","");

}

function saveNewFolder(folderDataId,txtValue,parentDataId){
     $.ajax({
       type: "POST",
       async: false,
       url: __base_url + "main/gallerySave",
       data: "folderName=" + txtValue + "&fatherId=" + parentDataId,
       dataType: "xml",
       success: function(data){
        newId = $("newId", data).attr("value");
         
        //Substitui input pela estrutura normal de LI
        parentSpan = $("#txtNewFolder").parent();
        $(parentSpan).attr("className","");
        
        oA = document.createElement("A");
        oA.id = "a_" + newId.toString();
        oA.href = "javascript:openGal(" + newId.toString() + ",'" + oA.id + "')";
        oA.className = "close";
        $(oA).append($("#txtNewFolder").val());

        //Menu de contexto
        newContextMenu($(oA),'folderMenu');

        $(parentSpan).html("");
        $(parentSpan).append(oA);

        //Modifica icone do pai
        parentLi = $(parentSpan).parent();

        //Modifica id do LI parent
        $(parentLi).attr("id","li_" + newId.toString());

        //Modifica ID do UL dos novos filhos
        parentUl = $(parentLi).children("ul");
        $(parentUl).attr("id","ul_" + newId.toString());

        parentUl = $(parentLi).parent();
        parentLi = $(parentUl).parent();
        parentLink = $(parentLi).children("a");
        oImg = $(parentLink).children("img");
        
        $(parentLink).attr("href","javascript:colapse('" + $(parentUl).attr("id") + "')");
        $(oImg).attr("src",__base_url + "../public/gwm/img/collapsable.gif");
        
         //Chama galeria na janela de objetos
         openGal(newId, "a_" + newId);
         
       }
     });
    
    return newId;

}

function loadSons(ulPai) {
	var idPai = ulPai.substring(3);
	var refsSrc = __base_url + "main/getGalByFatherId/?fId=" + idPai;
    $.ajax({
        async:      false,
        cache:      false,
        dataType:   "xml",
        timeout:    15000,
        type:       "get",
        url:        refsSrc,
        error:      function(){
                    },
        success:    function(data, textStatus){
			//$("gallery", data).length;
			$("gallery", data).each(function() {
				var idFilho = $("id", this).text();
				var name = $("name", this).text();
				var objPai = document.getElementById(ulPai);
				var ulFilho = document.createElement("ul");
				ulFilho.id = "ul_" + idFilho;
				ulFilho.style.display = "none";
				var liFilho = document.createElement("li");
				liFilho.id = "li_" + idFilho;
				var href1 = document.createElement("a");
				href1.href = "javascript:colapse('ul_" + idFilho + "');";
				var img =  document.createElement("img");
				img.src = __base_url + "../public/gwm/img/expandable.gif";
				href1.appendChild(img);
				var spn = document.createElement("span");
				var href2 = document.createElement("a");
				href2.id = "a_"+idFilho;
				href2.href = "javascript:openGal(" + idFilho + ",'a_" + idFilho + "');";
				href2.className = "close";
				href2.innerHTML = name;
				spn.appendChild(href2);
				liFilho.appendChild(href1);
				liFilho.appendChild(spn);
				liFilho.appendChild(ulFilho);
				objPai.appendChild(liFilho);
			});
		}
    });
}

var arrNoChildren = new Array();

function colapse(id,objFocus) {
	//alert("id entrada: " + id);
	if(document.getElementById(id)){
		var auxUl = $.trim($("#"+id).html());
		if (auxUl == "") {	
			loadSons(id);
		}
		var realId = "#" + id;		
		
		if(objFocus!=undefined){
		    $(realId).slideToggle("normal",function(){objFocus.focus()});
		}else{
		    $(realId).slideToggle("normal");
		}
		var li = (document.getElementById(id)).parentNode   
		var ul = li.parentNode;
		
		for (var i = 0; i < ul.childNodes.length; i++) {
			if(ul.childNodes[i].nodeType == 1){
				var liSon = ul.childNodes[i];
				
				if (liSon.id == li.id) {
					continue;
				}		
			}
		}

        var liAChildren = li.getElementsByTagName("a");
        fstAImg = liAChildren[0].getElementsByTagName("img")[0];
        
        var startImgIndex = fstAImg.src.indexOf(__base_url + "../public/gwm/img/",0);
        var imgSrc = fstAImg.src.substr(startImgIndex, (fstAImg.src.length - startImgIndex));
        if(document.getElementById(id).childNodes.length > 0){
            if(imgSrc == __base_url + "../public/gwm/img/expandable.gif"){
			    fstAImg.src = __base_url + "../public/gwm/img/collapsable.gif";
		    } else {
			    fstAImg.src = __base_url + "../public/gwm/img/expandable.gif";
		    }   
		} else {
		    fstAImg.src = __base_url + "../public/gwm/img/none.gif";    
		}
	}
}

function openGal(gal,aId) {

    //Fecha todas as pastas
    closeAll(aId);

    //Pega o frame dos objetos
    objFrame = window.parent.frames["objects"];
    objFrame.setGallery(gal);
}

function openRecent(){

    //Fecha todas as pastas
    closeAll("a_rec");

    //Pega o frame dos objetos
    objFrame = window.parent.frames["objects"];
    objFrame.setRecent();
}

function closeAll(aId){
   //Fecha pastas dos irmãos
    $(".openRec").attr("className","close");
    $(".open").attr("className","close");
    $(".close").css("font-weight","400");
    
    var selA = document.getElementById(aId);
    selA.className = "open";
    $(".open").css("font-weight","700");
}

function closeFolders(){
    $(".openRec").attr("className","close");
    $(".open").attr("className","close");
    $(".close").css("font-weight","400");
}