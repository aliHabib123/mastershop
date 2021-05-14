// JavaScript Document

function popUp(URL,w,h) {
day = new Date();
id = day.getTime();
var left = Math.floor( (screen.width - w) / 2);
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ eval(w) +",height="+ eval(h) +",left = "+ eval(left) +",top = 80');");
}