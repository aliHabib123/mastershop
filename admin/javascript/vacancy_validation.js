function vacancy_validation(form)
{


if(form.vacancy_title.value == "")
{
alert("Please fill the Vacancy title field.");
form.vacancy_title.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company field.");
form.company_id.focus();
return (false);
}

}