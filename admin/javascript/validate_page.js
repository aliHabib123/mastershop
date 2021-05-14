function validate_page(form)
{ 
	if (form.page_title.value == "")
	{
		alert("Please enter Page Title.");
		form.page_title.focus();
		return (false);
	}
	
	if (form.page_content.value=="") 
	{
		alert("Please enter Page Content.");
		return (false);
	}
	
	return (true);
}