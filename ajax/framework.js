var timeoutF = null;
var ajax = null;
function ajaxLoadFrw(method, URL, data, displayId){	
	
	if(window.ActiveXObject){
		ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		ajax = new XMLHttpRequest();
	}else{
		alert("Your browser dosen't support Ajax");
		return;
	}

	method = method.toLowerCase();
	//URL += "" + (new Date()).getTime();

	ajax.open(method, URL);

	if(method.toLowerCase()=="post" ){
		ajax.setRequestHeader ('Content-Type', 'application/x-www-form-urlencoded');
	}

	ajax.onreadystatechange = function (){
		if(ajax.readyState==4 && ajax.status==200){
			var atype = ajax.getResponseHeader("content-type");
			atype = atype.toLowerCase();
			
			ajaxCallbackFrw(atype, displayId, ajax.responseText);

			delete ajax;
			ajax = null;
		}

	}

	ajax.send(data);

}

function ajaxCallbackFrw(contentType, displayId, responseText){
	
	//Picture hiding
	//document.getElementById('fountainG').style.display = 'none';

	//Picture hiding
	if(contentType.match("text/javascript")){
		eval(responseText);
		clearTimeout(timeoutF);
	}else{
		var dv = document.getElementById(displayId);
		dv.innerHTML = responseText;
		
		clearTimeout(timeoutF);	
	}	

}

function ajaxTimeoutFrw(){

	if(ajax.readyState == 1){
			
			ajax.abort(); //Ajax stop
			
			//document.getElementById('subject_chk').style.display = 'none';
			
			alert('No response from server !');
		}
	clearTimeout(timeoutF);
}

//------------------------------------Framework ending -----------------------------------------

function getFrmData(formid){

    var frm = document.forms[formid];
	if(frm==null){
		alert("form not found!");
	}

	var data = "";
	var num_el = frm.elements.length;
	for(i=0; i<num_el; i++){
		var el = frm.elements[i];
		if(el.name=="" && el.id==""){
			continue;
		}
		
		var param_name = "";
		if(el.name!=""){
			param_name = el.name;
		}else if(el.id!=""){
			param_name = el.id;
		}
		
		var t = frm.elements[i].type;
		var value = "";
		if(t=="text"||t=="password"||t=="hidden"||t=="textarea"||t=="number" || t=="date"){
			value = encodeURI(el.value);
		}else if(t=="radio"||t=="checkbox"){
			if(el.checked){
				value = encodeURI(el.value);
			}else{
				value = '';
			}
		}else if(t=="select-one"){
			value = encodeURI(el.options[el.selectedIndex].value);
		}else if(t=="select-multiple"){
			for(j=0; j<el.length; j++){
				if(el.options[i].selected){
					if(data!=""){
						data += "&";
					}
					data += param_name + "=";
					data += encodeURI(select.options[j].value);
				}
			}
			
			continue;
		}

		//when it have a value before , slash by "&"
		if(data!=""){
			data += "&"
		}

		data += param_name + "=" + value;
	}

	return data;
}

function getData(formName){
	var data = getFrmData(formName);
	alert(data);
}