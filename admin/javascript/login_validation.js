// JavaScript Document

function validation(frm)
{
if(frm.username.value=="")
{
alert("Please enter the user name");
frm.username.focus();
return false;
}
if(frm.password.value=="")
{
alert("Please enter the password");
frm.password.focus();
return false;
}

return true;
}
