function package_validation(form)
{


if(form.package_title.value == "")
{
alert("Please fill the Package title field.");
form.package_title.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company id field.");
form.company_id.focus();
return (false);
}

}