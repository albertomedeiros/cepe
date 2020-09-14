/*
	GwmField
	 - refer 
	 - type (Tipo do Campo [txt,lst,eml,dte,chk,rdb,int,num])
		 - txt : texto
		 - lst : ComboBox (VAZIO == "#")
		 - eml : E-mail
		 - dte : Data
		 - chk : Checkbox
		 - rdb : Radio Button
		 - int : Inteiro
		 - num : Float
		 - url : URL
	 - prefixo (Caso a DIV tenha prefixo)
	 - father (Caso a div pai do campo seja outra)
*/

var __isDefault = false;

function GwmField(refer,type,prefix,fatherDiv) {
	this.divId = "div" + refer;
	this.labelId = "label" + refer;
	this.warningId = "warning" + refer;
	this.fatherDefaultClass = "";
	
	if (typeof(prefix) == "string" && prefix != "") {
		this.inputId = prefix + type + refer;
		this.prefix = prefix;
	} else {
		this.inputId = type + refer;
		this.prefix = "";
	}
	
	this.type = type;
	this.father = null;
	
	if (fatherDiv != undefined) {
		this.father = fatherDiv;
	}
	
	this.linkedFields = [];
}

function GwmFieldLink(vGwmField){
	this.linkedFields.push(vGwmField);
}
GwmField.prototype.Link = GwmFieldLink;

/*function GetValue() {
	this.linkedFields.push(vGwmField);
}

GwmField.prototype.Link = GwmFieldLink;*/

/*
-------------------------------------------------------------------------
*/

/*
	GwmValidator
	 - fields (Array de GwmFields com os campos a serem validados)	 
*/
function GwmValidator(fields) {
	this.fields = fields;
	this.errorList = [];
	
	if (!__isDefault) {
		this.backToDefault();
	}
}

function insertFields(field) {
	this.fields.push(field);
}

function validate() {
	var divErro = document.getElementById("divError");
	divErro.style.display = "none";
	
	for (var i = 0; i < this.fields.length; i++) {
		var field = this.fields[i];	
		switch(field.type.toUpperCase()) {
			case "FIL" : this.validateFile(field);
						 break;
			case "STD" : this.validateSiteId(field);
						 break;
			case "TXT" : this.validateText(field);
						 break;
			case "LST" : this.validateCombo(field);
						 break;
			case "EML" : this.validateEmail(field);
						 break;
			case "DTE" : this.validateDate(field);
						 break;
			case "URL" : this.validateUrl(field);
						break;
			case "PWD" : this.validatePassword(field);
		}
	}
	
	if (this.errorList.length > 0) {
		this.callErrors();
		return false;
	} else {		
		divErro.style.display = "none";
		return true;
	}
}

function callError() {
	scroll(0,0);
	var divErro = document.getElementById("divError");	
	divErro.style.display = "block";
}

function validateSiteId(field) {
	var input = document.getElementById(field.inputId);
	if (input != undefined) {
		if (this.trim(input.value) == "") {
			this.addErrorList(field);
		} else {
			//a-z e 0-9, sem maiusculos
			var reg = /^[a-z0-9]+$/;
			if (reg.test(input.value) == false) {
				this.addErrorList(field);
			}
		}
		
		/*
		if (input.value.indexOf(" ", 0) > -1) {
			this.addErrorList(field);
		} else {
			if (this.trim(input.value) == "") {
				this.addErrorList(field);
			}
		}
		*/
	} else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateSiteId");
		return;
	}
}

function validateText(field) {
	var input = document.getElementById(field.inputId);
	if (input != undefined) {
		if (this.trim(input.value) == "") {
			this.addErrorList(field);
		}
	} else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateText");
		return;
	}
}

function validateFile(field) {
	var input = document.getElementById(field.inputId);
	if (input != undefined) {
		if (this.trim(input.value) == "") {
			this.addErrorList(field);
		}
	} else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateText");
		return;
	}
}

function validateCombo(field) {
	var input = document.getElementById(field.inputId);
	
	if (input != undefined) {	
		if (input.value == "#") {
			this.addErrorList(field);
		}
	} else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateCombo");
		return;
	}
}

function validateEmail(field) {
	var input = document.getElementById(field.inputId);
	
	if (input != undefined) {
		var RegExPattern = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{ 1,3}){3}\])$/; 
	    
		if ((input.value.match(RegExPattern)) && (trim(input.value!=''))) {
			return;
		} else {
			this.addErrorList(field);
		}
    } else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateEmail");
		return;
    }

/*
	var input = document.getElementById(field.inputId);		
	var eIndex = input.value.indexOf('@', 1);
	var eIndex2 = input.value.indexOf('.',eIndex);
	
	if (this.trim(input.value) == "") {
		this.addErrorList(field);
		return;
	}
	
	if (eIndex < 1 || eIndex2 < 1) {
		this.addErrorList(field);
		return;
	}
	
	*/
}

function validateUrl(field) {
	var input = document.getElementById(field.inputId);
	var urlRegxp = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([\w]+)(.[\w]+){1,2}$/;
	
	if (input != undefined) {		
		if ((input.value.match(urlRegxp)) && (trim(input.value!=''))) {
			return;
		} else {
			this.addErrorList(field);
		}
    } else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateUrl");
		return;
    }
}

function validateDate(field) {
	var input = document.getElementById(field.inputId);
    var RegExPattern = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/; 
    
    //var errorMessage = 'Please enter valid date as month, day, and four digit year.\nYou may use a slash, hyphen or period to separate the values.\nThe date must be a real date. 30/2/2000 would not be accepted.\nFormay dd/mm/yyyy.';
    
    if (input != undefined) {    
		if ((input.value.match(RegExPattern)) && (trim(input.value!=''))) {
			return;
		} else {
			this.addErrorList(field);
		}
	} else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validateDate");
		return;
	}
}

function validatePassword(field) {
	var input = document.getElementById(field.inputId);
	var inputConfirm = document.getElementById(field.inputId + "Confirm");
	
	if (input != undefined) {
		if(inputConfirm != undefined){
			sPassword = input.value;
			sPasswordConfirm = inputConfirm.value;
			
			document.getElementById(field.warningId).innerHTML = "";
			
			if(sPassword.length < 8 || sPassword.length > 16){
				document.getElementById(field.warningId).innerHTML = "A senha deve ter entre 8 e 16 caracteres.";
				this.addErrorList(field);
			} else {
				if(sPassword != sPasswordConfirm){
					document.getElementById(field.warningId).innerHTML = "Os campos de senha e confirmação de senha estão diferentes.";
					this.addErrorList(field);
				}
			}
			
			return;
		} else {
			alert("Erro.\nProblema com ID do input de confirmação\nId informado: "+field.inputId+"Confirm\nFunção: validatePassword");
			return;
		}
    } else {
		alert("Erro.\nProblema com ID do input\nId informado: "+field.inputId+"\nFunção: validatePassword");
		return;
    }
}

function addErrorList(field) {
	this.errorList.push(field);
	
	for(var i = 0; i < field.linkedFields.length; i++){
		this.errorList.push(field.linkedFields[i]);
	}
}

function callErrors() {
	var divErro = document.getElementById("divError");
	
	for (var i = 0; i < this.errorList.length; i++) {
		
		var field = this.errorList[i];
		var div = document.getElementById(field.divId);
		var label = document.getElementById(field.labelId);
		var input = document.getElementById(field.inputId);

		if (field.father != null) {
			div = document.getElementById(field.father);
		}
		
		if (div != undefined) div.className = "line indic";
		if (label != undefined) label.className = "erro";
		//if (input != undefined) input.className = "erro";
	}
	
	scroll(0,0);
	divErro.style.display = "block";
	this.errorList = [];
}

function trim(str){
	if (typeof(str) == "string") {
		return str.replace(/^\s+|\s+$/g,"");
	} else {
		return str;
	}	
}

function backToDefault() {
	
	for (var i = 0; i < this.fields.length; i++) {
		var field = this.fields[i];
		this.insertBackStyle(field);
		
		//Insere a função de Back nos ítens associados
		for(var j = 0;j < field.linkedFields.length;j++){
			var linkedField = field.linkedFields[j];
			insertBackStyle(linkedField);
		}
	}	
	__isDefault = true;
}

function backAllToDefault() {
	var divErro = document.getElementById("divError");
	divErro.style.display = "none";
	for (var i = 0; i < this.fields.length; i++) {
		var input = document.getElementById(this.fields[i].inputId);	
		
		if (input != null) {			
			input.onfocus();
		}
		
	}
}

function insertBackStyle(field) {
	var input = document.getElementById(field.inputId);
	var div = document.getElementById(field.divId);
	
	if (field.father != null) {
		input.father = true;
		var fatherAux = document.getElementById(field.father);
		field.fatherDefaultClass = fatherAux.className;		
	}
	
	if (div != undefined) div.defaultClass = div.className;
	if (input != undefined) {
		input.objField = field;
		input.onfocus = backDefaultFocus;
	}
}

function backDefaultFocus() {
	/*var refer = "";
	
	alert(this.objField.inputId);
	
	this.divId = "div" + refer;
	this.labelId = "label" + refer;
	
	if (typeof(this.prefix) == "string" && this.prefix != "") {
		refer = this.id.substring((this.prefix.length + 3),this.id.length);
	} else {
		refer = this.id.substring(3,this.id.length);
	}*/
	
	
	var field = this.objField;
	backStyle(field);
	
	
	for(var i = 0; i < field.linkedFields.length; i++){
		backStyle(field.linkedFields[i]);
	}
}

function backStyle(field){
	var input = document.getElementById(field.inputId);
	var div = document.getElementById(field.divId);
	var label = document.getElementById(field.labelId);
	var warning = document.getElementById(field.warningId);
	var father = document.getElementById(field.father);
	
	if (input.father) {
		father.className = field.fatherDefaultClass;
		
		if (label != null) {
			label.className = "";
		}		
		return;
	}
	
	input.className = "";
	div.className = div.defaultClass;
	label.className = "";
	
	if(warning){
		warning.innerHTML = "";
	}
}

// Prototypes
GwmValidator.prototype.insertFields = insertFields;
GwmValidator.prototype.addErrorList = addErrorList;
GwmValidator.prototype.trim = trim;
GwmValidator.prototype.validateSiteId = validateSiteId;
GwmValidator.prototype.validateText = validateText;
GwmValidator.prototype.validateFile = validateFile;
GwmValidator.prototype.validateCombo = validateCombo;
GwmValidator.prototype.validateEmail = validateEmail;
GwmValidator.prototype.validateDate = validateDate;
GwmValidator.prototype.validatePassword = validatePassword;
GwmValidator.prototype.validateUrl = validateUrl;
GwmValidator.prototype.callErrors = callErrors;
GwmValidator.prototype.validate = validate;
GwmValidator.prototype.backToDefault = backToDefault;
GwmValidator.prototype.insertBackStyle = insertBackStyle;
GwmValidator.prototype.backStyle = backStyle;
GwmValidator.prototype.callError = callError;
GwmValidator.prototype.backAllToDefault = backAllToDefault;

/*	
	@Fishy
	@Ultima Atualização : 01/07/2008
*/