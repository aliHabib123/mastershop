function document_validation(form)
{


if(form.document_title.value == "")
{
alert("Please fill the Document title field.");
form.document_title.focus();
return (false);
}

if(form.partner_id.value == 0)
{
alert("Please Select the Partner id field.");
form.partner_id.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company id field.");
form.company_id.focus();
return (false);
}

}