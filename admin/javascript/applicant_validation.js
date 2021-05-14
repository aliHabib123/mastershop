function applicant_validation(form)
{


if(form.applicant_fullname.value == "")
{
alert("Please fill the Applicant fullname field.");
form.applicant_fullname.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company id field.");
form.company_id.focus();
return (false);
}

}