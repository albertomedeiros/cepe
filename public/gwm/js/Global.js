function initObjects(mDiv, hidObjects, showArea, fGetObjects, fGetObjectsCounter, fSetSelectedObjects, fSetMainFunc, maxDrops) {
	var windowSize = getWindowSize();
	
	__div = mDiv;
	//$(__div).css("height", windowSize[1] + "px");
	
	__active = true;
	window.onresize = resize;

	objModMulti = new ObjMultiLoader(showArea, 10, 90, 67, fGetObjects, fGetObjectsCounter, fSetSelectedObjects, fSetMainFunc, maxDrops, hidObjects);

	return objModMulti;
}

function getWindowSize() {
  var arr = [-1,-1];  
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  
  arr[0] = myWidth;
  arr[1] = myHeight;
  
  return arr;
}

function getWHProperties(element) {
	var arr = [0,0];
	
	if (typeof(element) == "string") {
		element = document.getElementById(element);
	}

	arr[0] = element.scrollWidth;		
	arr[1] = element.scrollHeight;
	
	return arr;
}

function isIE() {
	var result = false;
	if (navigator.appName.indexOf("Microsoft")!=-1) {
		result = true;
	}	
	return result;
}

function resize() {
	var windowSize = getWindowSize();	
	$(__div).css("height", windowSize[1] + "px");
}

function associateObjWithEvent(obj, methodName){
    return (
        function (e) {
            console.log("ops");
            e = e || window.event;
            return obj[methodName](e, this);
        }
	);
}

function SelectAll(id){
	document.getElementById(id).focus();
	document.getElementById(id).select();
}

function formatDateTime(dateStr){

    pSlash1 = dateStr.indexOf("/",0);
    if(pSlash1 > -1){
        pSlash2 = dateStr.indexOf("/",pSlash1+1);

        strData = dateStr.substring(0,pSlash1) + "/" + dateStr.substring(pSlash1+1,pSlash2)

        if (pSlash2 > -1){
            pDotz = dateStr.indexOf(":",pSlash2+1);
            strHora = dateStr.substring(pDotz-3,pDotz) + ":" + dateStr.substring(pDotz+1,pDotz+3);
        }else{
            strHora = "";
        }
    }else{
        strData = ""
    }
    fStr = strData + " " + strHora;
    
    return fStr;
}