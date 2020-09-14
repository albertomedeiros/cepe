$(document).ready(function(){
    $.ajax({
        async:      true,
        cache:      false,
        dataType:   "xml",
        timeout:    1000,
        type:       "get",
        url:        __base_url + "main/getObjectTypes",
        error:      function(){
                objFrame = window.parent.frames["objects"];
                objFrame.$.facebox("Erro ao carregar os tipos de objeto.<br />Contacte o administrador do sistema.")
                },
        success:    function(data, textStatus){

            //Testa navegador
            ieBrowser = isIE()
            
            //Pega combo
		    oSelect = document.getElementById("cboObjectTypeId");            
        
            //Combo de tipos
            oOpt = document.createElement("option");
            oOpt.text = "-- IMG JPEG --";
            oOpt.value = "jpg";
            if(ieBrowser){
                oSelect.add(oOpt);
            }else{
                oSelect.add(oOpt,null);
            }
			
            oOpt = document.createElement("option");
            oOpt.text = "-- Todos --";
            oOpt.value = "#";
            if(ieBrowser){
                oSelect.add(oOpt);
            }else{
                oSelect.add(oOpt,null);
            }
            
            $("objectType", data).each(function(){

                objectTypeId = $(this).attr("id");
                objectType = $("type", this).text();
                
                //for (i = oSelect.length - 1; i>=0; i--) {oSelect.remove(i);}

                oOpt = document.createElement("option");
                oOpt.text = objectType;
                oOpt.value = objectTypeId;
                if(ieBrowser){
                    oSelect.add(oOpt);
                }else{
                    oSelect.add(oOpt,null);
                }
                
            })
        }
    })
})

function runQuery(){
    //Pega query
    query = $("#busca").attr("value");
    objectTypeId = $("#cboObjectTypeId").attr("value");
    
    if(query != null && query.length >= 2){
    
        //Pega o frame dos objetos
        objFrame = window.parent.frames["objects"];
        objFrame.setQuery(query,objectTypeId);
        
   }else{
        objFrame = window.parent.frames["objects"];
        objFrame.$.facebox("Especifique melhor sua busca com um mínimo de 2 caracteres.");
   }
}

function isIE() {
	var result = false;
	if (navigator.appName.indexOf("Microsoft")!=-1) {
		result = true;
	}	
	return result;
}

function newObject(){
   //Pega o frame dos objetos
    objFrame = window.parent.frames["objects"];
    if(objFrame.getGallery() != ""){
        objFrame.showEditArea("");
    }else{
        objFrame.$.facebox("Para inserir um objeto você deve antes selecionar uma pasta");
    }
}

function closeWindow(){
    objFrame = window.parent.parent.closeObjMultimidia();
}