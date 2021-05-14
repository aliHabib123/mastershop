function partner_validation(form)
{


if(form.partner_firstname.value == "")
{
alert("Please fill the Partner firstname field.");
form.partner_firstname.focus();
return (false);
}

if(form.partner_lastname.value == "")
{
alert("Please fill the Partner lastname field.");
form.partner_lastname.focus();
return (false);
}

if(form.partner_username.value == "")
{
alert("Please fill the Partner username field.");
form.partner_username.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company field.");
form.company_id.focus();
return (false);
}

}