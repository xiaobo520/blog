function hasClass(obj, cls) {//判断是否有CLASS
    return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}

function addClass(obj, cls) {
	var obj = document. getElementById(obj);
    if (!this.hasClass(obj, cls)) obj.className += " " + cls;
}

function removeClass(obj, cls) {
	var obj = document. getElementById(obj);
    if (hasClass(obj, cls)) {
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        obj.className = obj.className.replace(reg, ' ');
    }
}

function toggleClass(obj,cls){//反向
	var obj = document. getElementById(obj);
	if(hasClass(obj,cls)){
		removeClass(obj, cls);
	}else{
		addClass(obj, cls);
	}
}