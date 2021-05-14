function company_validation(form)
{


if(form.company_name.value == "")
{
alert("Please fill the Company name field.");
form.company_name.focus();
return (false);
}

}