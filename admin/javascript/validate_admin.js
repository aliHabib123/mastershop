function validate_admin(form)
{ 
	if (form.admin_name.value == "")
	{
		alert("Please enter Admin Name.");
		form.admin_name.focus();
		return (false);
	}
	
	if (form.user_name.value.length < 6)
	{
		alert("Please enter Username , Username must be at least 6 characters.");
		form.user_name.focus();
		return (false);
	}
	
	if (form.password.value.length < 6)
	{
		alert("Please enter Password , Password must be at least 6 characters.");
		form.password.focus();
		return (false);
	}
	
	return (true);
}