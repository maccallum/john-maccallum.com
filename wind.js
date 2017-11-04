function pageWidth(){
	if(window.innerWidth != null){
		return window.innerWidth;
	}else if(document.documentElement && document.documentElement.clientWidth){
		return document.documentElement.clientWidth;
	}else if(document.body != null){
		return document.body.clientWidth;
	}else{
		return null;
	}
}

function pageHeight(){
	if(window.innerHeight != null){
		return window.innerHeight;
	}else if(document.documentElement && document.documentElement.clientHeight){
		return document.documentElement.clientHeight;
	}else if(document.body != null){
		return document.body.clientHeight;
	}else{
		return null;
	}
}