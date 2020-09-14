//Esconde txtObjectUrl

$(document).ready(function(){    
    $("#txtObjectUrl").hide();
    $("#lstZipType").hide();
    
    if (document.getElementById("hidAction").value == "edit") {
		$("#divObjectBlob").css("display","none;");
		$("#divObjectBlob").css("visiblity","hidden;");
    }
    
    $("#lstObjectTypeId").change(function(){
        if($(this).val() == "jpg"){
            $("#divZip").show();
        }else{
            $("#divZip").hide();
            $("#txtObjectDescription").width('355px');
            $("#lstZipType").hide();
        }
    });
    
    $("#lstZipType").change(function(){
        if($(this).val() == "1"){
            $("#txtObjectDescription").css("color","#999999");
            $("#txtObjectDescription").val("Este campo não será utilizado");
            $("#txtObjectDescription").attr("readonly","readonly");
        }else{
            $("#txtObjectDescription").removeAttr("readonly");
            if($("#txtObjectDescription").val() == "Este campo não será utilizado"){
                $("#txtObjectDescription").val("");
                $("#txtObjectDescription").css("color","#343434");
            }
        }
    });
    
})

function chargeObjectTypes(executor, eventArgs) {
	var browser = navigator.appName;	
	
	var xml = executor.get_xml();
	var data = xml.getElementsByTagName("objectType");
	var cbo = $get("cboObjectType");
	
	var opt = document.createElement('option');
	opt.value = "#";
	opt.text = "-- Tipo --";
	
	if (browser.indexOf("Microsoft") > -1) {
		cbo.add(opt);
	} else {
		cbo.add(opt,null);
	}	
	
	for (var i = 0; i < data.length; i++) {
		var objType = data[i];
		var opt = document.createElement('option');
		opt.value = objType.attributes[0].value;
		opt.text = objType.firstChild.nodeValue;
		
		if (browser.indexOf("Microsoft") > -1) {
			cbo.add(opt);
		} else {
			cbo.add(opt,null);
		}
	}
}

function selType(obj){
    if(obj.checked){
        $("#txtObjectBlob").hide();
        $("#txtObjectUrl").show();
    }else{
        $("#txtObjectUrl").hide();
        $("#txtObjectBlob").show();
    }
}
function selZip(obj){
    if(obj.checked){
        $("#txtObjectDescription").width('150px');
        $("#lstZipType").width('200px');
        $("#lstZipType").show();
        $("#divType").hide();
        $("#txtObjectBlob").show();
        $("#txtObjectUrl").hide();
        $("#chkType").attr('checked', false);
    }else{
        $("#txtObjectDescription").width('355px');
        $("#lstZipType").hide();
        $("#divType").show();
    }
}

function validateADD() {
    var result = false;
	var prefixo = "";
	var objTypeId = document.getElementById("lstObjectTypeId");
	var objHidAction = document.getElementById("hidAction");
    
	var objectTypeId = new GwmField("ObjectTypeId","lst",prefixo);
	var objectDescription = new GwmField("ObjectDescription","txt",prefixo);
	var objectAuthor = new GwmField("ObjectAuthor","txt",prefixo);
	
	//var oFrm = document.forms["aspnetForm"];
    //divParentId = oFrm.txtObjectBlob.parentNode.id.substring(3,13);
    //var objectURL = new GwmField("ObjectUrl","txt",prefixo,"divObjectBlob");
    var objectBlob = new GwmField("ObjectBlob","txt",prefixo,"divObjectBlob");

  	var fields = [];
  	if (objHidAction.value == "insert") {  	
  	// 	if (document.getElementById("chkType").checked) {
  	// 		document.getElementById("txtObjectBlob").value = "";
			// if (objTypeId.value == "jpg") {
			// 	fields = [objectTypeId,objectDescription,objectAuthor,objectURL];
			// } else {
			// 	fields = [objectTypeId,objectDescription,objectAuthor,objectURL];
			// }
  	// 	} else {
  			//document.getElementById("txtObjectUrl").value = "";
			if (objTypeId.value == "jpg") {
			    fields = [objectTypeId,objectDescription,objectAuthor,objectBlob];
			} else {
				fields = [objectTypeId,objectDescription,objectAuthor,objectBlob];
			}
  		//}
  	} else if (objHidAction.value == "edit") {
  		fields = [objectTypeId,objectDescription,objectAuthor];
  	}
  	
	var val = new GwmValidator(fields);
	result = val.validate();

	if (result) {
		if (objHidAction.value == "insert") {
			var fieldName = "";
			// if (document.getElementById("chkType").checked) {
			// 	fieldName = "txtObjectUrl";
			// } else {
				fieldName = "txtObjectBlob";
			//}
			if (!checkType("lstObjectTypeId",fieldName)) {
				//fb_OpenAlert("Formato de arquivo inválido.");
				alert("Formato de arquivo inválido.");
				result = false;
			}
		}
	}

	if (result) {
		document.getElementById('aspnetForm').submit();
	} else {
		return false;
	}
}

function checkType(combo,text) {
	var result = false;
	
	if (typeof(text) == "string") {
		text = document.getElementById(text);
	}
	
	if (typeof(combo) == "string") {
		combo = document.getElementById(combo);
	}
	
	var ext = getFileExtension(text);
	var currentOpt = combo.options[combo.selectedIndex].value;
	
	if(ext == "zip" || ext == currentOpt){
	    result = true;
	}	
	return result;
}

function getFileExtension(text) {
	var result = "";
	var texto = "";
	
	if (typeof(text) == "string") {
		text = document.getElementById(text);
	}
	
	texto = String(text.value);	
	var index = texto.indexOf(".",0);
	var currentIndex = -1;
	
	while(index > -1) {
		if (index > -1) {
			currentIndex = index;
		}		
		index = texto.indexOf(".",index + 1);
	}	
	
	result = texto.substring(currentIndex + 1,currentIndex + 4);
	return result.toLowerCase();
}