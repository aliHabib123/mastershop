function service_validation(form)
{


if(form.service_title.value == "")
{
alert("Please fill the Service title field.");
form.service_title.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company field.");
form.company_id.focus();
return (false);
}

}