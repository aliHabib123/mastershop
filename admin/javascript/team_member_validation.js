function team_member_validation(form)
{


if(form.team_member_firstname.value == "")
{
alert("Please fill the Team member firstname field.");
form.team_member_firstname.focus();
return (false);
}

if(form.team_member_lastname.value == "")
{
alert("Please fill the Team member lastname field.");
form.team_member_lastname.focus();
return (false);
}

if(form.comapny_id.value == 0)
{
alert("Please Select the Comapny field.");
form.comapny_id.focus();
return (false);
}

}