function page_validation(form)
{


if(form.page_title.value == "")
{
alert("Please fill the Page title field.");
form.page_title.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company id field.");
form.company_id.focus();
return (false);
}

}