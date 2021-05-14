// JavaScript Document

function CheckAll(chk)
{
for (i = 0; i < document. myform.elements.length; i++){
var e=document. myform.elements[i];
e.checked = true ;
}
}

function UnCheckAll(chk)
{
for (i = 0; i < document. myform.elements.length; i++){
var e=document. myform.elements[i];
e.checked = false ;
}
}
