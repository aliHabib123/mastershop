function event_validation(form)
{


if(form.event_title.value == "")
{
alert("Please fill the Event title field.");
form.event_title.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company field.");
form.company_id.focus();
return (false);
}

}