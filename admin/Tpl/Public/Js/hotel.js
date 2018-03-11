window.onload=function()
{
	var addBtn=document.getElementById("addBtn");
	var parent=document.getElementById("addDiv");
	addBtn.onclick=function()
	{
		var obj=document.getElementById("room");
		var newObj=obj.cloneNode(true);
		del_ff(newObj);
		var newBtn=newObj.lastChild;
		newBtn.style.display="none";
		parent.appendChild(newObj);
	}
}
function del_ff(elem){

var elem_child = elem.childNodes;

for(var i=0; i<elem_child.length;i++){

if(elem_child[i].nodeName == "#text" && !/\s/.test(elem_child.nodeValue))

{elem.removeChild(elem_child[i])

}

}

}