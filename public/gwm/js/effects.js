var Alpha = new Object();
Alpha.get = function(obj){
	
	if(typeof obj == "string") {
		var obj = $(obj);
	}
	if(obj._alpha == undefined){
		var _alpha = null;
		if(obj.currentStyle && obj.currentStyle != undefined) {
            _alpha = obj.currentStyle.opacity;
		} else if(document.defaultView.getComputedStyle != undefined){
			_alpha = document.defaultView.getComputedStyle(obj, null).getPropertyValue("opacity");
		}
		_alpha = _alpha <= 1  ? _alpha * 100 : _alpha;
		obj._alpha = _alpha != null ? _alpha : 100;
	}
	
	return obj._alpha;
	
}
Alpha.set = function(obj, newAlpha){
	
	if(typeof obj == "string"){
		var obj = $(obj);
	}
	obj._alpha = newAlpha == 1 ? 2 : newAlpha;
	obj.style.filter = "alpha(opacity:" + obj._alpha + ")";
	obj.style.opacity = Math.max(0, Math.min(obj._alpha/100, 1));
	obj.style.mozOpacity = obj.style.opacity;

	return obj._alpha;
	
}

var effects = {
	version: "1.3b"
}

effects.tweens = new Array();
effects.IntervalUpdate = null;
effects.dispatchTween = function(){
	var aT = effects.tweens;
	for(var i in aT) aT[i].update();
}
effects.removeTweenAt = function(index){
	var aT = effects.tweens, index = index - 1;
	if (index >= aT.length || index < 0 || index == undefined) return false;
	aT.splice(index, 1);
	for (var i=index; i<aT.length; i++) {
		aT[i].ID--;
	}
	if (aT.length == 0) {
		clearInterval(effects.IntervalUpdate);
		delete effects.IntervalUpdate;
	}
}
effects.Tween = function(objEvt, init, end, dur){
	
	if(objEvt == undefined) return false;
	if (typeof init != "number") this.arrayMode = true;
	else this.arrayMode = false;
	
	this.ID = (effects.tweens.length+1);
	effects.tweens.push(this);
	
	if(effects.IntervalUpdate == null || effects.IntervalUpdate == undefined){
		effects.IntervalUpdate = setInterval(effects.dispatchTween, 12);
	}
	
	this.objEvt = objEvt;
	this.init = init;
	this.end = end;
	this.duration = dur;
	this.initTime = (new Date()).getTime();
	this.started = false;
	
	if(this.duration == 0){
		this.endTween();
	}
	
}
effects.Tween.prototype = {
	
	easingEquation: function(t,b,c,d){
		return c/2 * ( Math.sin( Math.PI * (t/d-0.5) ) + 1 ) + b;
	},
	
	getCurVal: function(curTime){
		if (this.arrayMode) {
			var returnArray = new Array();
			for (var i=0; i<this.init.length; i++) {
				returnArray[i] = this.easingEquation(curTime, this.init[i], this.end[i]-this.init[i], this.duration);
			}
			return returnArray;
		} else {
			return this.easingEquation(curTime, this.init, this.end-this.init, this.duration);
		}
	},
	
	update: function(){
		var curTime = (new Date()).getTime()-this.initTime;
		var curVal= this.getCurVal(curTime);
		if (curTime >= this.duration) this.endTween();
		else {
			if (this.started == false) {
				this.objEvt["onTweenStart"](curVal);
				this.started = true;
			} else {
				if(this.objEvt.onTweenUpdate != undefined)
						this.objEvt.onTweenUpdate(curVal);
			}
		}
	},
	
	endTween: function(){
		if(this.objEvt.onTweenEnd != undefined)
				this.objEvt.onTweenEnd(this.end);
		effects.removeTweenAt(this.ID);
	}
}

var easing = new Object();
easing.Back = function(t, b, c, d, s) {
	if (s == undefined) s = 1.70158;
	return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
}
easing.Bounce = function(t, b, c, d) {
	if ((t/=d) < (1/2.75)) {
		return c*(7.5625*t*t) + b;
	} else if (t < (2/2.75)) {
		return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
	} else if (t < (2.5/2.75)) {
		return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
	} else {
		return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
	}
}
easing.Elastic = function(t, b, c, d, a, p) {
	if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
	if (!a || a < Math.abs(c)) { a=c; var s=p/4; }
	else var s = p/(2*Math.PI) * Math.asin (c/a);
	return (a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b);
}
easing.None = function(t, b, c, d) {
	return c*t/d + b;
}
easing.Strong = function(t, b, c, d) {
	return c*((t=t/d-1)*t*t*t*t + 1) + b;
}